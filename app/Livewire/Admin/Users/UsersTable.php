<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Admin users table with search and pagination
 */
class UsersTable extends Component
{
    use WithPagination;

    /**
     * Search query bound to URL
     */
    #[Url]
    public string $search = '';

    /**
     * Whether search input should be displayed
     */
    public bool $searchable = true;

    /**
     * Sort direction for created date: 'asc', 'desc', or null.
     */
    public ?string $sortCreated = null;

    /**
     * Reset pagination when search query changes
     */
    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    /**
     * Toggle created sort - cycles through desc, asc, null.
     */
    public function toggleCreated(): void
    {
        if ($this->sortCreated === null) {
            $this->sortCreated = 'desc';
        } elseif ($this->sortCreated === 'desc') {
            $this->sortCreated = 'asc';
        } else {
            $this->sortCreated = null;
        }
        $this->resetPage();
    }

    /**
     * Render the users table component
     */
    public function render(): View
    {
        $users = User::with('roles')
            ->when($this->search, function ($query, $search) {
                $trimmedSearch = trim($search);
                $query->where(function ($q) use ($trimmedSearch) {
                    $q->where('name', 'like', "%{$trimmedSearch}%")
                        ->orWhere('email', 'like', "%{$trimmedSearch}%");
                });
            })
            ->when($this->sortCreated === 'desc', function ($query) {
                $query->latest('created_at');
            })
            ->when($this->sortCreated === 'asc', function ($query) {
                $query->oldest('created_at');
            })
            ->when($this->sortCreated === null, function ($query) {
                $query->latest('created_at');
            })
            ->paginate(6);

        return view('livewire.admin.users.users-table', [
            'users' => $users,
        ]);
    }
}
