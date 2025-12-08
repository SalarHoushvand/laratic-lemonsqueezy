<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\Plan;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
class SyncLemonSqueezyProducts extends Command
{
    protected $signature = 'lemonsqueezy:sync-products';

    protected $description = 'Sync Lemon Squeezy products and variants with local products and plans tables';

    public function handle(): int
    {
        $storeId = env('LEMON_SQUEEZY_STORE');
        $apiKey  = env('LEMON_SQUEEZY_API_KEY');

        if (! $storeId || ! $apiKey) {
            $this->error('LEMON_SQUEEZY_STORE or LEMON_SQUEEZY_API_KEY is not set in .env.');
            return self::FAILURE;
        }

        $this->info('Syncing Lemon Squeezy products...');

        $allVariantIds = [];

        $page     = 1;
        $lastPage = 1;

        do {
            $response = Http::withHeaders([
                    'Accept'       => 'application/vnd.api+json',
                    'Content-Type' => 'application/vnd.api+json',
                ])
                ->withToken($apiKey)
                ->get('https://api.lemonsqueezy.com/v1/products', [
                    'filter[store_id]' => $storeId,
                    'page[number]'     => $page,
                    'page[size]'       => 50,
                ]);

            if (! $response->successful()) {
                $this->error('Failed to fetch products from Lemon Squeezy: ' . $response->body());
                return self::FAILURE;
            }

            $body     = $response->json();
            $products = $body['data'] ?? [];
            $pageMeta = $body['meta']['page'] ?? [];
            $current  = $pageMeta['currentPage'] ?? $page;
            $lastPage = $pageMeta['lastPage'] ?? $lastPage;

            foreach ($products as $product) {

                $productId         = $product['id']; // Lemon Squeezy product ID
                $productAttributes = $product['attributes'] ?? [];

                $productName   = $productAttributes['name'] ?? '';
                $productDesc   = $productAttributes['description'] ?? '';
                $productStatus = $productAttributes['status'] ?? null;
                $productImage  = $productAttributes['large_thumb_url']
                    ?? $productAttributes['thumb_url']
                    ?? null;

                // Fetch variants for this product using the "related" link
                $variantsUrl = $product['relationships']['variants']['links']['related'] ?? null;

                if (! $variantsUrl) {
                    continue;
                }

                $variantsResponse = Http::withHeaders([
                        'Accept'       => 'application/vnd.api+json',
                        'Content-Type' => 'application/vnd.api+json',
                    ])
                    ->withToken($apiKey)
                    ->get($variantsUrl);

                if (! $variantsResponse->successful()) {
                    $this->warn('Failed to fetch variants for product ID '.$productId);
                    continue;
                }

                $variants = $variantsResponse->json('data') ?? [];

                foreach ($variants as $variant) {
                    $variantId         = $variant['id']; // Lemon Squeezy variant ID
                    $variantAttributes = $variant['attributes'] ?? [];

                    $allVariantIds[] = $variantId;

                    // Decide if this is a subscription or a one-time product.
                    $isSubscription = (bool) ($variantAttributes['is_subscription'] ?? false);

                    // Name always from product (variant name is usually "Default")
                    $name        = $productName;
                    $description = $productDesc;
                    $price       = $variantAttributes['price'] ?? 0; // in cents
                    $currency    = $variantAttributes['currency'] ?? 'USD';
                    $status      = $productStatus;
                    $hasFreeTrial = (bool) ($variantAttributes['has_free_trial'] ?? false);

                    if ($isSubscription) {
                        // Map to plans table (subscriptions)
                        Plan::updateOrCreate(
                            ['lemon_squeezy_variant_id' => $variantId],
                            [
                                'lemon_squeezy_product_id' => $productId,
                                'name'                     => $name,
                                'description'              => $description,
                                'price'                    => $price,
                                'currency'                 => $currency,
                                'billing_period'           => $variantAttributes['interval'] ?? 'monthly',
                                'status'                   => $status ?? 'active',
                                'trial_period'             => $hasFreeTrial ? $variantAttributes['trial_interval'] : null,
                                'trial_interval'           => $hasFreeTrial ? $variantAttributes['trial_interval_count'] : null,
                                // is_featured, features left for manual control
                            ]
                        );
                    } else {
                        // Map to products table (one-time payment)
                        Product::updateOrCreate(
                            ['lemon_squeezy_variant_id' => $variantId],
                            [
                                'lemon_squeezy_product_id' => $productId,
                                'name'                     => $name,
                                'description'              => $description,
                                'price'                    => $price,
                                'currency'                 => $currency,
                                'status'                   => $status,
                                'img_url'                  => $productImage,
                                // category, delivery_method, features, is_featured left for manual control
                            ]
                        );
                    }
                }
            }

            $this->info("Synced page {$current} of {$lastPage}...");

            $page++;
        } while ($page <= $lastPage);

        // Delete local records that no longer exist in Lemon Squeezy
        if (! empty($allVariantIds)) {
            Product::whereNotIn('lemon_squeezy_variant_id', $allVariantIds)->delete();
            Plan::whereNotIn('lemon_squeezy_variant_id', $allVariantIds)->delete();
        }

        $this->info('Lemon Squeezy products synced successfully.');

        return self::SUCCESS;
    }
}
