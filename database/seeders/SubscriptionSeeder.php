<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(float $percentageOfUsers = 0.4): void
    {
        $plans = Plan::where('status', 'active')->get();

        if ($plans->count() === 0) {
            $this->command->warn('No active plans found.');

            return;
        }

        $totalUsers = User::role('user')->count();
        $targetCount = (int) ($totalUsers * $percentageOfUsers);

        // Get random user IDs without loading all users
        $userIds = User::role('user')
            ->inRandomOrder()
            ->limit($targetCount)
            ->pluck('id');

        $subscriptionsCreated = 0;
        $subscriptionCounter = 1;

        foreach ($userIds as $userId) {
            $plan = $plans->random();
            $startDate = now()->subDays(rand(0, 480));

            $statuses = ['active', 'active', 'active', 'past_due', 'canceled'];
            $status = $statuses[array_rand($statuses)];

            $trialEndsAt = null;
            if ($plan->trial_period && rand(0, 100) < 30) {
                $trialEndsAt = $startDate->copy()->addDays((int) $plan->trial_period);
            }

            $endsAt = null;
            if ($status === 'canceled') {
                $endsAt = $startDate->copy()->addDays(rand(30, 365));
            }

            $paddleId = 'sub_'.str_pad((string) $subscriptionCounter++, 10, '0', STR_PAD_LEFT);

            $subscription = DB::table('subscriptions')->insertGetId([
                'billable_type' => User::class,
                'billable_id' => $userId,
                'type' => 'default',
                'paddle_id' => $paddleId,
                'status' => $status,
                'trial_ends_at' => $trialEndsAt,
                'paused_at' => null,
                'ends_at' => $endsAt,
                'created_at' => $startDate,
                'updated_at' => $startDate,
            ]);

            DB::table('subscription_items')->insert([
                'subscription_id' => $subscription,
                'product_id' => 'prod_'.rand(100000, 999999),
                'price_id' => $plan->lemon_squeezy_variant_id,
                'status' => $status,
                'quantity' => 1,
                'created_at' => $startDate,
                'updated_at' => $startDate,
            ]);

            $subscriptionsCreated++;

            if ($subscriptionsCreated % 100 === 0) {
                $this->command->info("Created $subscriptionsCreated subscriptions...");
            }
        }

        $this->command->info("Total subscriptions created: $subscriptionsCreated");
    }
}
