<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(float $percentageOfUsers = 0.3, int $minOrders = 1, int $maxOrders = 4): void
    {
        $products = Product::where('status', 'active')->get();

        if ($products->count() === 0) {
            $this->command->warn('No active products found.');

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
        $orderCounter = 1;
        $invoiceCounter = 1;

        foreach ($userIds as $userId) {
            $orderCount = rand($minOrders, $maxOrders);

            for ($i = 0; $i < $orderCount; $i++) {
                $product = $products->random();
                $createdAt = now()->subDays(rand(0, 480));

                $statuses = ['paid', 'paid', 'paid', 'incomplete', 'refunded'];
                $status = $statuses[array_rand($statuses)];

                Order::create([
                    'user_id' => $userId,
                    'product_id' => $product->id,
                    'status' => $status,
                    'variant_ids' => [$product->lemon_squeezy_variant_id],
                    'total' => $product->price,
                    'currency' => $product->currency,
                    'lemon_squeezy_id' => 'ord_'.str_pad((string) $orderCounter++, 10, '0', STR_PAD_LEFT),
                    'invoice_number' => 'INV-'.date('Y').'-'.str_pad((string) $invoiceCounter++, 6, '0', STR_PAD_LEFT),
                    'shipping_address' => rand(0, 100) < 80 ? fake()->streetAddress() : null,
                    'shipping_city' => rand(0, 100) < 80 ? fake()->city() : null,
                    'shipping_state' => rand(0, 100) < 70 ? fake()->stateAbbr() : null,
                    'shipping_zip' => rand(0, 100) < 70 ? fake()->postcode() : null,
                    'shipping_country' => rand(0, 100) < 80 ? fake()->country() : null,
                    'paid_at' => $status === 'paid' ? $createdAt : null,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);

                $ordersCreated++;

                if ($ordersCreated % 100 === 0) {
                    $this->command->info("Created $ordersCreated orders...");
                }
            }
        }

        $this->command->info("Total orders created: $ordersCreated");
    }
}
