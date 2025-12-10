<?php

namespace App\Livewire\Admin\SubscriptionInvoices;

use App\Models\SubscriptionInvoice;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Admin subscription invoices table with search and pagination
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
        $invoices = SubscriptionInvoice::with('billable')
            ->when($this->search, function ($query, $search) {
                $trimmedSearch = trim($search);
                $query->where(function ($q) use ($trimmedSearch) {
                    $q->where('lemon_squeezy_id', 'like', "%{$trimmedSearch}%")
                        ->orWhereHasMorph('billable', ['App\Models\User'], function ($query) use ($trimmedSearch) {
                            $query->where('name', 'like', "%{$trimmedSearch}%")
                                ->orWhere('email', 'like', "%{$trimmedSearch}%");
                        });
                });
            })
            ->latest('invoiced_at')
            ->paginate(8);

        return view('livewire.admin.subscription-invoices.subscription-invoices-table', [
            'invoices' => $invoices,
        ]);
    }
}

