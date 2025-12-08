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

        $country = $this->normalizeCountryCode($request->user()->country ?? 'US');

        $checkout = $request->user()->checkout($lemon_squeezy_variant_id)
            ->withBillingAddress($country, $request->user()->zip)
            ->withCustomData(['order_type' => 'subscription'])
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
        $plans = Plan::where('status', 'published')->get();

        return view('pages.pricing', compact('plans'));
    }

    /**
     * Normalize country code, converting US variations to 'US'
     *
     * @param  string|null  $country
     * @return string
     */
    private function normalizeCountryCode(?string $country): string
    {
        if (empty($country)) {
            return 'US';
        }

        $normalized = strtoupper(str_replace(['.', ' '], '', trim($country)));

        $usVariations = [
            'UNITEDSTATES',
            'UNITEDSTATESOFAMERICA',
            'USA',
            'US',
        ];

        if (in_array($normalized, $usVariations, true)) {
            return 'US';
        }

        return $country;
    }
}
