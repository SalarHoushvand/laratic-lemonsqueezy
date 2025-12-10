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
}
