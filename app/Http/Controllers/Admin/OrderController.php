<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\View\View;
use Laravel\Paddle\Transaction;

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
     * Display the specified order with its transactions
     *
     * Authorization is handled by the 'role:admin' middleware at the route level
     */
    public function show(Order $order): View
    {
        $order->load('product', 'user');
        $transactions = Transaction::where('invoice_number', $order->invoice_number)->get();

        return view('pages.admin.orders.show', compact('order', 'transactions'));
    }
}
