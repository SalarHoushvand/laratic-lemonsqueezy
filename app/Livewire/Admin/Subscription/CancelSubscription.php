<?php

namespace App\Livewire\Admin\Subscription;

use Illuminate\Contracts\View\View;
use LemonSqueezy\Laravel\Subscription;
use Livewire\Component;

/**
 * Admin component for canceling and resuming user subscriptions
 */
class CancelSubscription extends Component
{
    /**
     * The subscription to be canceled or resumed
     */
    public Subscription $subscription;

    /**
     * Cancel the subscription at the end of the billing period
     */
    public function cancel(): void
    {
        $this->subscription->cancel();

        session()->flash('notification', [
            'variant' => 'success',
            'title' => __('Subscription Cancelled'),
            'message' => __('The subscription will be cancelled at the end of the current billing period.'),
        ]);

        $this->redirect(route('admin.users.show', $this->subscription->billable_id, absolute: false), navigate: true);
    }

    /**
     * Resume a cancelled subscription
     */
    public function resume(): void
    {
        if ($this->subscription->expired()) {
            session()->flash('notification', [
                'variant' => 'danger',
                'title' => __('Cannot Resume'),
                'message' => __('Cannot resume an expired subscription.'),
            ]);

            return;
        }

        $this->subscription->resume();

        session()->flash('notification', [
            'variant' => 'success',
            'title' => __('Subscription Resumed'),
            'message' => __('The subscription has been resumed successfully.'),
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
