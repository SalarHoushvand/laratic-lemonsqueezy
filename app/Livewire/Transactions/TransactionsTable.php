<?php

namespace App\Livewire\Transactions;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * User transactions table with pagination
 */
class TransactionsTable extends Component
{
    use WithPagination;

    /**
     * Render the transactions table component
     */
    public function render(): View
    {
        /** @var User $user */
        $user = Auth::user();
        $transactions = $user
            ->transactions()
            ->with('subscription')
            ->latest('billed_at')
            ->paginate(8);

        return view('livewire.transactions.transactions-table', [
            'transactions' => $transactions,
        ]);
    }
}
