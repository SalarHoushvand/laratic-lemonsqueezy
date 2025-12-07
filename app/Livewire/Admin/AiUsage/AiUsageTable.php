<?php

namespace App\Livewire\Admin\AiUsage;

use App\Models\AiUsage;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Admin AI usage table with search and pagination
 */
class AiUsageTable extends Component
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
     * Reset pagination when search query changes
     */
    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    /**
     * Render the AI usage table component
     */
    public function render(): View
    {
        $aiUsages = AiUsage::with('user')
            ->when($this->search, function ($query, $search) {
                $trimmedSearch = trim($search);
                $query->where(function ($q) use ($trimmedSearch) {
                    $q->where('model', 'like', "%{$trimmedSearch}%")
                        ->orWhereHas('user', function ($query) use ($trimmedSearch) {
                            $query->where('name', 'like', "%{$trimmedSearch}%")
                                ->orWhere('email', 'like', "%{$trimmedSearch}%");
                        });
                });
            })
            ->latest()
            ->paginate(5);

        return view('livewire.admin.ai-usage.ai-usage-table', [
            'aiUsages' => $aiUsages,
        ]);
    }
}
