<?php

namespace App\Livewire\Admin\Orders;

use App\Models\Order;
use Illuminate\Contracts\View\View;
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
        $orders = Order::with(['user', 'transaction', 'product'])
            ->whereNotIn('status', ['incomplete'])
            ->when($this->search, function ($query, $search) {
                $trimmedSearch = trim($search);
                $query->where('invoice_number', 'like', "%{$trimmedSearch}%")
                    ->orWhereHas('user', function ($query) use ($trimmedSearch) {
                        $query->where('name', 'like', "%{$trimmedSearch}%");
                    });
            })
            ->latest()
            ->paginate(8);

        return view('livewire.admin.orders.orders-table', [
            'orders' => $orders,
        ]);
    }
}
