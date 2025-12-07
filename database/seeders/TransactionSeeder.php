<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $transactionCounter = 1;
        $transactionsCreated = 0;

        // Create transactions for paid orders - using chunk to avoid memory issues
        Order::where('status', 'paid')->chunk(100, function ($orders) use (&$transactionCounter, &$transactionsCreated) {
            $transactions = [];

            foreach ($orders as $order) {
                $tax = (int) ($order->total * 0.1);
                $total = $order->total + $tax;

                $transactions[] = [
                    'billable_type' => User::class,
                    'billable_id' => $order->user_id,
                    'paddle_id' => 'txn_'.str_pad((string) $transactionCounter++, 10, '0', STR_PAD_LEFT),
                    'paddle_subscription_id' => null,
                    'invoice_number' => $order->invoice_number,
                    'status' => 'completed',
                    'total' => (string) $total,
                    'tax' => (string) $tax,
                    'currency' => $order->currency,
                    'billed_at' => $order->paid_at ?? $order->created_at,
                    'created_at' => $order->created_at,
                    'updated_at' => $order->updated_at,
                ];
            }

            if (! empty($transactions)) {
                DB::table('transactions')->insert($transactions);
                $transactionsCreated += count($transactions);
                $this->command->info("Created $transactionsCreated transactions...");
            }
        });

        // Create transactions for subscriptions - using chunk to avoid memory issues
        DB::table('subscriptions')
            ->where('status', 'active')
            ->orWhere('status', 'past_due')
            ->orderBy('id')
            ->chunk(100, function ($subscriptions) use (&$transactionCounter, &$transactionsCreated) {
                $transactions = [];

                foreach ($subscriptions as $subscription) {
                    $subscriptionItem = DB::table('subscription_items')
                        ->where('subscription_id', $subscription->id)
                        ->first();

                    if (! $subscriptionItem) {
                        continue;
                    }

                    $plan = DB::table('plans')
                        ->where('lemon_squeezy_variant_id', $subscriptionItem->price_id)
                        ->first();

                    if (! $plan) {
                        continue;
                    }

                    // Calculate number of billing periods
                    $startDate = \Carbon\Carbon::parse($subscription->created_at);
                    $endDate = now();
                    $monthsPassed = $startDate->diffInMonths($endDate);
                    $transactionCount = max(1, min($monthsPassed, 16));

                    for ($i = 0; $i < $transactionCount; $i++) {
                        $billedAt = $startDate->copy()->addMonths($i);

                        $tax = (int) ($plan->price * 0.1);
                        $total = $plan->price + $tax;

                        $transactions[] = [
                            'billable_type' => User::class,
                            'billable_id' => $subscription->billable_id,
                            'paddle_id' => 'txn_'.str_pad((string) $transactionCounter++, 10, '0', STR_PAD_LEFT),
                            'paddle_subscription_id' => $subscription->paddle_id,
                            'invoice_number' => 'INV-'.date('Y', strtotime($billedAt)).'-'.str_pad((string) rand(1, 9999), 4, '0', STR_PAD_LEFT),
                            'status' => $i === $transactionCount - 1 && $subscription->status === 'past_due' ? 'past_due' : 'completed',
                            'total' => (string) $total,
                            'tax' => (string) $tax,
                            'currency' => $plan->currency,
                            'billed_at' => $billedAt,
                            'created_at' => $billedAt,
                            'updated_at' => $billedAt,
                        ];

                        // Insert in smaller batches to avoid too much memory usage
                        if (count($transactions) >= 500) {
                            DB::table('transactions')->insert($transactions);
                            $transactionsCreated += count($transactions);
                            $this->command->info("Created $transactionsCreated transactions...");
                            $transactions = [];
                        }
                    }
                }

                // Insert remaining transactions for this chunk
                if (! empty($transactions)) {
                    DB::table('transactions')->insert($transactions);
                    $transactionsCreated += count($transactions);
                    $this->command->info("Created $transactionsCreated transactions...");
                }
            });

        $this->command->info("Total transactions created: $transactionsCreated");
    }
}
