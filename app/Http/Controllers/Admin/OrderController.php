<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Product;
use LemonSqueezy\Laravel\Order;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Display a listing of orders
     *
     * Authorization is handled by the 'role:admin' middleware at the route level
     */
    public function index(): View
    {
        return view('pages.admin.orders.index');
    }

    /**
     * Display the specified order
     *
     * Authorization is handled by the 'role:admin' middleware at the route level
     */
    public function show(Order $order): View
    {
        $order->load('billable');

        $item = null;
        if ($order->variant_id) {
            if ($order->product_type === 'subscription') {
                $item = Plan::where('lemon_squeezy_variant_id', $order->variant_id)->first();
            } elseif ($order->product_type === 'one-time') {
                $item = Product::where('lemon_squeezy_variant_id', $order->variant_id)->first();
            }
        }

        return view('pages.admin.orders.show', compact('order', 'item'));
    }
}
