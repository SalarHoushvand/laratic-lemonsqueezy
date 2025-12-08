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
        $plans = Plan::where('status', 'published')->get();

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
            if ($plan->trial_period && $plan->trial_interval && rand(0, 100) < 30) {
                $trialCount = (int) $plan->trial_interval;
                $trialUnit = $plan->trial_period;

                $trialEndsAt = match ($trialUnit) {
                    'day' => $startDate->copy()->addDays($trialCount),
                    'week' => $startDate->copy()->addWeeks($trialCount),
                    'month' => $startDate->copy()->addMonths($trialCount),
                    'year' => $startDate->copy()->addYears($trialCount),
                    default => $startDate->copy()->addDays($trialCount),
                };
            }

            $endsAt = null;
            $renewsAt = null;
            if ($status === 'canceled') {
                $endsAt = $startDate->copy()->addDays(rand(30, 365));
            } elseif ($status === 'active') {
                // Set renews_at for active subscriptions based on billing period
                $billingPeriod = $plan->billing_period ?? 'month';
                $renewsAt = match ($billingPeriod) {
                    'year', 'yearly' => $startDate->copy()->addYear(),
                    'month', 'monthly' => $startDate->copy()->addMonth(),
                    'week', 'weekly' => $startDate->copy()->addWeek(),
                    'day', 'daily' => $startDate->copy()->addDay(),
                    default => $startDate->copy()->addMonth(),
                };
            }

            // LemonSqueezy subscription IDs are numeric (e.g., 1000000)
            $lemonSqueezyId = (string) (1000000 + $subscriptionCounter++);

            DB::table('lemon_squeezy_subscriptions')->insert([
                'billable_type' => User::class,
                'billable_id' => $userId,
                'type' => 'default',
                'lemon_squeezy_id' => $lemonSqueezyId,
                'status' => $status,
                'product_id' => $plan->lemon_squeezy_product_id,
                'variant_id' => $plan->lemon_squeezy_variant_id,
                'card_brand' => rand(0, 100) < 50 ? ['visa', 'mastercard', 'amex'][array_rand(['visa', 'mastercard', 'amex'])] : null,
                'card_last_four' => rand(0, 100) < 50 ? str_pad((string) rand(0, 9999), 4, '0', STR_PAD_LEFT) : null,
                'pause_mode' => null,
                'pause_resumes_at' => null,
                'trial_ends_at' => $trialEndsAt,
                'renews_at' => $renewsAt,
                'ends_at' => $endsAt,
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
