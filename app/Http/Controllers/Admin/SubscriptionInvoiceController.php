<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\SubscriptionInvoice;
use Illuminate\View\View;

class SubscriptionInvoiceController extends Controller
{
    /**
     * Display a listing of subscription invoices
     *
     * Authorization is handled by the 'role:admin' middleware at the route level
     */
    public function index(): View
    {
        return view('pages.admin.subscription-invoices.index');
    }

    /**
     * Display the specified subscription invoice
     *
     * Authorization is handled by the 'role:admin' middleware at the route level
     */
    public function show(SubscriptionInvoice $subscriptionInvoice): View
    {
        $subscriptionInvoice->load(['billable', 'subscription']);

        $plan = null;
        if ($subscriptionInvoice->subscription && $subscriptionInvoice->subscription->variant_id) {
            $plan = Plan::where('lemon_squeezy_variant_id', $subscriptionInvoice->subscription->variant_id)->first();
        }

        return view('pages.admin.subscription-invoices.show', [
            'invoice' => $subscriptionInvoice,
            'plan' => $plan,
        ]);
    }
}

