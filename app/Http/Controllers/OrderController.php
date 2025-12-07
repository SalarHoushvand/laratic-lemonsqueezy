<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use LemonSqueezy\Laravel\Order as Order;

class OrderController extends Controller
{
    /**
     * Display user orders
     */
    public function index(): View
    {
        return view('pages.orders.index');
    }

    /**
     * Show the order pending page
     */
    public function pending(string $order_id): View
    {
        $order = Order::findOrFail($order_id);

        return view('pages.orders.pending', compact('order'));
    }

    /**
     * Get order status as JSON
     */
    public function status(string $order_id): JsonResponse
    {
        $order = Order::findOrFail($order_id);

        return response()->json([
            'status' => $order->status === 'paid' ? 'paid' : 'pending',
        ]);
    }
}
