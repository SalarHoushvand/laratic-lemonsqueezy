<?php

namespace App\Livewire\Subscription;

use App\Models\Plan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Livewire\Attributes\Locked;
use Livewire\Component;

/**
 * Component for managing user subscriptions
 */
class Manage extends Component
{
    /**
     * The authenticated user
     */
    #[Locked]
    public User $user;

    /**
     * Available subscription plans
     */
    public Collection $plans;

    /**
     * Current plan name
     */
    public ?string $currentPlan = null;

    /**
     * Next payment amount in cents
     */
    public ?string $nextPaymentAmount = null;

    /**
     * Next payment currency code
     */
    public ?string $nextPaymentCurrency = null;

    /**
     * Next payment date
     */
    public ?Carbon $nextPaymentDate = null;

    /**
     * Initialize component with user data and subscription info
     */
    public function mount(): void
    {
        /** @var User $user */
        $this->user = Auth::user();
        $this->plans = Plan::where('status', 'published')
            ->orderBy('sort_order')
            ->get();
        $this->currentPlan = $this->user->currentPlanName();

        $subscription = $this->user->subscription();

        if ($subscription && $subscription->renews_at) {
            $this->nextPaymentDate = $subscription->renews_at;

            if ($subscription->variant_id) {
                $plan = Plan::where('lemon_squeezy_variant_id', $subscription->variant_id)->first();

                if ($plan) {
                    $this->nextPaymentAmount = (string) $plan->price;
                    $this->nextPaymentCurrency = $plan->currency;
                }
            }
        }
    }

    /**
     * Render the component
     */
    public function render(): View
    {
        return view('livewire.subscription.manage');
    }

    /**
     * Swap to a different subscription plan
     */
    public function swapPlan(string $variantId): void
    {
        try {
            $subscription = $this->user->subscription();

            if (! $subscription) {
                $this->dispatch(
                    'notify',
                    variant: 'danger',
                    title: __('Error'),
                    message: __('No active subscription found.')
                );

                return;
            }

            if ($subscription->onTrial()) {
                $this->dispatch(
                    'notify',
                    variant: 'danger',
                    title: __('Cannot Swap Plan'),
                    message: __('You cannot swap plans while on a trial period.')
                );

                return;
            }

            $plan = Plan::where('lemon_squeezy_variant_id', $variantId)->first();

            if (! $plan) {
                $this->dispatch(
                    'notify',
                    variant: 'danger',
                    title: __('Error'),
                    message: __('Plan not found.')
                );

                return;
            }

            $subscription->swapAndInvoice($subscription->product_id, $variantId);

            session()->flash('notification', [
                'variant' => 'success',
                'title' => __('Plan Swapped'),
                'message' => __('You have successfully swapped to the new plan.'),
            ]);

            $this->redirect(route('subscription.manage', absolute: false), navigate: true);
        } catch (\Exception $e) {
            $this->dispatch(
                'notify',
                variant: 'danger',
                title: __('Error'),
                message: __('Failed to swap plan. Please try again.')
            );

            Log::error('Failed to swap plan', ['error' => $e->getMessage()]);
        }
    }

    /**
     * Cancel the current subscription at the end of the billing period
     */
    public function cancelPlan(): void
    {
        try {
            $subscription = $this->user->subscription();

            if (! $subscription) {
                $this->dispatch(
                    'notify',
                    variant: 'danger',
                    title: __('Error'),
                    message: __('No active subscription found.')
                );

                return;
            }

            $subscription->cancel();

            session()->flash('notification', [
                'variant' => 'success',
                'title' => __('Subscription Cancelled'),
                'message' => __('The subscription will be cancelled at the end of the current billing period.'),
            ]);

            $this->redirect(route('subscription.manage', absolute: false), navigate: true);
        } catch (\Exception $e) {
            $this->dispatch(
                'notify',
                variant: 'danger',
                title: __('Error'),
                message: __('Failed to cancel subscription. Please try again.')
            );

            Log::error('Failed to cancel subscription', ['error' => $e->getMessage()]);
        }
    }

    /**
     * Resume a cancelled subscription
     */
    public function resumePlan(): void
    {
        try {
            $subscription = $this->user->subscription();

            if (! $subscription) {
                $this->dispatch(
                    'notify',
                    variant: 'danger',
                    title: __('Error'),
                    message: __('No subscription found.')
                );

                return;
            }

            if ($subscription->expired()) {
                $this->dispatch(
                    'notify',
                    variant: 'danger',
                    title: __('Cannot Resume'),
                    message: __('Cannot resume an expired subscription.')
                );

                return;
            }

            $subscription->resume();

            session()->flash('notification', [
                'variant' => 'success',
                'title' => __('Subscription Resumed'),
                'message' => __('The subscription has been resumed successfully.'),
            ]);

            $this->redirect(route('subscription.manage', absolute: false), navigate: true);
        } catch (\Exception $e) {
            $this->dispatch(
                'notify',
                variant: 'danger',
                title: __('Error'),
                message: __('Failed to resume subscription. Please try again.')
            );

            Log::error('Failed to resume subscription', ['error' => $e->getMessage()]);
        }
    }

    /**
     * Redirect to update payment method
     */
    public function updatePaymentMethod(): void
    {
        $subscription = $this->user->subscription();

        if ($subscription) {
            $paymentMethodUrl = $subscription->updatePaymentMethodUrl();

            if ($paymentMethodUrl) {
                $this->js("window.open('{$paymentMethodUrl}', '_blank')");
            }
        }
    }
}
