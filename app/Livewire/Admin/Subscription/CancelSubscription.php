<?php

namespace App\Livewire\Admin\Subscription;

use Illuminate\Contracts\View\View;
use Laravel\Paddle\Subscription;
use Livewire\Attributes\Validate;
use Livewire\Component;

/**
 * Admin component for canceling user subscriptions
 */
class CancelSubscription extends Component
{
    /**
     * The subscription to be canceled
     */
    public Subscription $subscription;

    /**
     * Whether the cancellation confirmation modal is open
     */
    public bool $confirmingCancellation = false;

    /**
     * The cancellation method selected by admin
     */
    #[Validate('required|in:immediately,at-end-of-period')]
    public string $cancel_method = '';

    /**
     * Cancel the subscription based on selected method
     */
    public function cancel(): void
    {
        $this->validate();

        if ($this->cancel_method === 'immediately') {
            $this->subscription->cancelNow();
        } else {
            if ($this->subscription->onTrial()) {
                $this->subscription->cancelNow();
            } else {
                $this->subscription->cancel();
            }
        }

        session()->flash('notification', [
            'variant' => 'success',
            'title' => __('Subscription Cancelled'),
            'message' => __('The subscription has been cancelled successfully.'),
        ]);

        $this->redirect(route('admin.users.show', $this->subscription->billable_id, absolute: false), navigate: true);
    }

    /**
     * Render the component
     */
    public function render(): View
    {
        return view('livewire.admin.subscription.cancel-subscription');
    }
}
