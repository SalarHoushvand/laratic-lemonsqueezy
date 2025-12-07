<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use LemonSqueezy\Laravel\Order as Order;
use App\Models\User;

class ProductController extends Controller
{
    /**
     * Show the available products page
     */
    public function index()
    {
        $products = Product::where('status', 'active')
            ->orderBy('is_featured', 'desc')
            ->get();

        return view('pages.products.index', compact('products'));
    }

    /**
     * Show the product page
     *
     * @param  string  $lemon_squeezy_variant_id
     * @return \Illuminate\View\View
     */
    public function show(Request $request, $lemon_squeezy_variant_id)
    {
        $product = Product::where('lemon_squeezy_variant_id', $lemon_squeezy_variant_id)->firstOrFail();

        $checkout = $request->user()->checkout($product->lemon_squeezy_variant_id)
            ->withBillingAddress($request->user()->country ?? 'US', $request->user()->zip) // Country & Zip Code
            ->redirectTo(route('dashboard'));

        // $checkout = $request->user()->checkout($product->paddle_id)->customData(['order_id' => $order->id])
        //     ->returnTo(route('orders.pending', $order->id));

        return view('pages.products.show', compact('product', 'checkout'));
    }
}
