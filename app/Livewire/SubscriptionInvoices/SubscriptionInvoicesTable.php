<?php

namespace App\Livewire\SubscriptionInvoices;

use App\Models\SubscriptionInvoice;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * User subscription invoices table with search and pagination
 */
class SubscriptionInvoicesTable extends Component
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
     * Render the subscription invoices table component
     */
    public function render(): View
    {
        /** @var User $user */
        $user = Auth::user();
        $invoices = SubscriptionInvoice::where('billable_id', $user->id)
            ->where('billable_type', User::class)
            ->when($this->search, function ($query, $search) {
                $trimmedSearch = trim($search);
                $query->where('lemon_squeezy_id', 'like', "%{$trimmedSearch}%");
            })
            ->latest('invoiced_at')
            ->paginate(8);

        return view('livewire.subscription-invoices.subscription-invoices-table', [
            'invoices' => $invoices,
        ]);
    }
}

