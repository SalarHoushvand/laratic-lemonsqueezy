<?php

namespace App\Livewire\Orders;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use LemonSqueezy\Laravel\Order as Order;

/**
 * User orders table with search and pagination
 */
class OrdersTable extends Component
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
     * Render the orders table component
     */
    public function render(): View
    {
        /** @var User $user */
        $user = Auth::user();
        $orders = Order::where('billable_id', $user->id)
            ->whereNotIn('status', ['incomplete'])
            ->when($this->search, function ($query, $search) {
                $trimmedSearch = trim($search);
                $query->where('order_number', 'like', "%{$trimmedSearch}%");
            })
            ->latest()
            ->paginate(8);

        return view('livewire.orders.orders-table', [
            'orders' => $orders,
        ]);
    }
}
