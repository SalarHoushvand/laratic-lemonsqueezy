<?php

namespace App\Livewire\Admin\Transactions;

use Illuminate\Contracts\View\View;
use Laravel\Paddle\Transaction;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Admin transactions table with search and pagination
 */
class TransactionsTable extends Component
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
     * Render the transactions table component
     */
    public function render(): View
    {
        $transactions = Transaction::when($this->search, function ($query, $search) {
            $trimmedSearch = trim($search);
            $query->where('invoice_number', 'like', "%{$trimmedSearch}%");
        })
            ->latest()
            ->paginate(8);

        return view('livewire.admin.transactions.transactions-table', [
            'transactions' => $transactions,
        ]);
    }
}
