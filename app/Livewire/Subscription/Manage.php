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
        $this->plans = Plan::where('status', 'active')->get();
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

            $subscription->noProrate()->swapAndInvoice($subscription->product_id, $variantId);

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
     * Cancel the current subscription
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

            if ($subscription->onTrial()) {
                $subscription->cancelNow();
                $message = __('Your subscription has been cancelled immediately.');
            } else {
                $subscription->cancel();
                $message = __('Your subscription will be cancelled at the end of the billing period.');
            }

            session()->flash('notification', [
                'variant' => 'success',
                'title' => __('Subscription Cancelled'),
                'message' => $message,
            ]);

            $this->redirect(route('subscription.manage', absolute: false), navigate: true);
        } catch (\Exception $e) {
            $this->dispatch(
                'notify',
                variant: 'danger',
                title: __('Error'),
                message: __('Failed to cancel subscription. Please try again.')
            );
        }
    }

    /**
     * Redirect to update payment method
     */
    public function updatePaymentMethod(): void
    {
        $subscription = $this->user->subscription();

        if ($subscription) {
            $subscription->redirectToUpdatePaymentMethod();
        }
    }
}
