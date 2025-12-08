<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Show the available products page
     */
    public function index()
    {
        $products = Product::where('status', 'published')
            ->orderBy('sort_order')
            ->orderByDesc('is_featured')
            ->orderBy('id')
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
            ->withBillingAddress($this->normalizeCountryCode($request->user()->country ?? 'US'), $request->user()->zip) // Country & Zip Code
            ->withCustomData(['order_type' => 'one-time'])
            ->redirectTo(route('dashboard'));

        return view('pages.products.show', compact('product', 'checkout'));
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
