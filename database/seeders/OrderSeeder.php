<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use LemonSqueezy\Laravel\Order;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(float $percentageOfUsers = 0.3, int $minOrders = 1, int $maxOrders = 4): void
    {
        $products = Product::where('status', 'published')->get();
        $plans = Plan::where('status', 'published')->get();

        if ($products->count() === 0 && $plans->count() === 0) {
            $this->command->warn('No active products or plans found.');

            return;
        }

        $totalUsers = User::role('user')->count();
        $targetCount = (int) ($totalUsers * $percentageOfUsers);

        // Get random user IDs without loading all users
        $userIds = User::role('user')
            ->inRandomOrder()
            ->limit($targetCount)
            ->pluck('id');

        $ordersCreated = 0;
        $oneTimeOrdersCreated = 0;
        $subscriptionOrdersCreated = 0;
        // LemonSqueezy order IDs are numeric (e.g., 7004729)
        $orderCounter = 7000000;

        foreach ($userIds as $userId) {
            $orderCount = rand($minOrders, $maxOrders);

            for ($i = 0; $i < $orderCount; $i++) {
                $orderedAt = now()->subDays(rand(0, 480));

                // Randomly choose between one-time product or subscription plan (60% one-time, 40% subscription)
                $isSubscription = rand(0, 100) < 40 && $plans->count() > 0;

                if ($isSubscription && $plans->count() > 0) {
                    // Create subscription order
                    $plan = $plans->random();
                    $item = $plan;
                    $productType = 'subscription';
                    $subscriptionOrdersCreated++;
                } elseif ($products->count() > 0) {
                    // Create one-time product order
                    $product = $products->random();
                    $item = $product;
                    $productType = 'one-time';
                    $oneTimeOrdersCreated++;
                } else {
                    // Skip if no items available
                    continue;
                }

                $statuses = ['paid', 'paid', 'paid', 'incomplete', 'refunded'];
                $status = $statuses[array_rand($statuses)];

                $total = $item->price;
                $subtotal = (int) ($total * 0.9); // Simulate some discount
                $tax = (int) ($total * 0.1);
                $discountTotal = $total - $subtotal;

                $refunded = $status === 'refunded';
                $refundedAt = $refunded ? $orderedAt->copy()->addDays(rand(1, 30)) : null;

                $currentOrderNumber = $orderCounter++;

                Order::create([
                    'billable_type' => User::class,
                    'billable_id' => $userId,
                    'lemon_squeezy_id' => (string) $currentOrderNumber,
                    // LemonSqueezy customer IDs are numeric (e.g., 5000000)
                    'customer_id' => (string) (5000000 + $userId),
                    'identifier' => 'order-'.$currentOrderNumber.'-'.time(),
                    'product_id' => $item->lemon_squeezy_product_id,
                    'variant_id' => $item->lemon_squeezy_variant_id,
                    'product_type' => $productType,
                    'order_number' => $currentOrderNumber,
                    'currency' => $item->currency,
                    'subtotal' => $subtotal,
                    'discount_total' => $discountTotal,
                    'tax' => $tax,
                    'total' => $total,
                    'tax_name' => rand(0, 100) < 50 ? 'VAT' : null,
                    'status' => $status,
                    'receipt_url' => $status === 'paid' ? 'https://app.lemonsqueezy.com/receipt/'.$currentOrderNumber : null,
                    'refunded' => $refunded,
                    'refunded_at' => $refundedAt,
                    'ordered_at' => $orderedAt,
                ]);

                $ordersCreated++;

                if ($ordersCreated % 100 === 0) {
                    $this->command->info("Created $ordersCreated orders...");
                }
            }
        }

        $this->command->info("Total orders created: $ordersCreated");
        $this->command->info("  - One-time orders: $oneTimeOrdersCreated");
        $this->command->info("  - Subscription orders: $subscriptionOrdersCreated");
    }
}
