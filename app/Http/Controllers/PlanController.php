<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    /**
     * Show all the available plans
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $subscription = $request->user()->subscription();

        if ($subscription && $subscription->valid() && ! $subscription->onGracePeriod()) {
            return redirect()->route('subscription.manage')->with('notification', [
                'variant' => 'danger',
                'title' => __('Error'),
                'message' => __('You are already subscribed to a plan.'),
            ]);
        }

        return redirect()->route('pricing');
    }

    /**
     * Show the plan page
     *
     * @param  string  $lemon_squeezy_variant_id
     * @return \Illuminate\View\View
     */
    public function show(Request $request, $lemon_squeezy_variant_id)
    {
        $subscription = $request->user()->subscription();

        if ($subscription && $subscription->valid() && ! $subscription->onGracePeriod()) {
            return redirect()->route('subscription.manage')->with('notification', [
                'variant' => 'danger',
                'title' => __('Error'),
                'message' => __('You are already subscribed to a plan.'),
            ]);
        }

        $plan = Plan::where('lemon_squeezy_variant_id', $lemon_squeezy_variant_id)->firstOrFail();

        $checkout = $request->user()->checkout($lemon_squeezy_variant_id)
            ->withBillingAddress($request->user()->country ?? 'US', $request->user()->zip)
            ->redirectTo(route('dashboard'));

        return view('pages.plans.show', ['checkout' => $checkout, 'plan' => $plan]);
    }

    /**
     * Unified pricing page showing marketing content and available plans.
     *
     * @return \Illuminate\View\View
     */
    public function pricing(Request $request)
    {
        $plans = Plan::where('status', 'active')->get();

        return view('pages.pricing', compact('plans'));
    }
}
