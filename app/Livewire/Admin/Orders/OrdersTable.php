<?php

namespace App\Livewire\Admin\Orders;

use Illuminate\Contracts\View\View;
use LemonSqueezy\Laravel\Order;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Admin orders table with search and pagination
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
        $orders = Order::with('billable')
            ->when($this->search, function ($query, $search) {
                $trimmedSearch = trim($search);
                $query->where(function ($q) use ($trimmedSearch) {
                    $q->where('order_number', 'like', "%{$trimmedSearch}%")
                        ->orWhereHasMorph('billable', ['App\Models\User'], function ($query) use ($trimmedSearch) {
                            $query->where('name', 'like', "%{$trimmedSearch}%")
                                ->orWhere('email', 'like', "%{$trimmedSearch}%");
                        });
                });
            })
            ->latest('ordered_at')
            ->paginate(8);

        return view('livewire.admin.orders.orders-table', [
            'orders' => $orders,
        ]);
    }
}
