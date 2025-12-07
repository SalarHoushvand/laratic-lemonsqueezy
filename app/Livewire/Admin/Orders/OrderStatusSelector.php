<?php

namespace App\Livewire\Admin\Orders;

use App\Models\Order;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Component;

/**
 * Order status selector component for admin
 */
class OrderStatusSelector extends Component
{
    /**
     * Available order statuses
     */
    private const STATUSES = [
        'completed',
        'paid',
        'pending',
        'failed',
        'refunded',
        'disputed',
        'cancelled',
    ];

    /**
     * The order being managed
     */
    public Order $order;

    /**
     * Current selected status
     */
    public string $status;

    /**
     * Initialize the component with the order
     */
    public function mount(): void
    {
        $this->status = $this->order->status;
    }

    /**
     * Update order status when changed
     */
    public function updatedStatus(string $value): void
    {
        $this->validate([
            'status' => ['required', Rule::in(self::STATUSES)],
        ]);

        $this->order->update(['status' => $value]);

        $this->dispatch('notify',
            variant: 'success',
            title: __('Status Updated'),
            message: __('Order status has been updated successfully.')
        );
    }

    /**
     * Get available statuses
     *
     * @return array<int, string>
     */
    public function getStatusesProperty(): array
    {
        return self::STATUSES;
    }

    /**
     * Render the component
     */
    public function render(): View
    {
        return view('livewire.admin.orders.order-status-selector');
    }
}
