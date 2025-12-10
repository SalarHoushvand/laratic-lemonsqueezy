<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\SubscriptionInvoice;
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
        $invoiceCounter = 2000000; // LemonSqueezy invoice IDs start from 2000000

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
            $billingPeriod = $plan->billing_period ?? 'month';
            if ($status === 'canceled') {
                $endsAt = $startDate->copy()->addDays(rand(30, 365));
            } elseif ($status === 'active') {
                // Set renews_at for active subscriptions based on billing period
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

            // Create subscription invoices
            $this->createSubscriptionInvoices(
                $userId,
                $lemonSqueezyId,
                $plan,
                $startDate,
                $status,
                $billingPeriod,
                $endsAt,
                $invoiceCounter
            );

            $subscriptionsCreated++;

            if ($subscriptionsCreated % 100 === 0) {
                $this->command->info("Created $subscriptionsCreated subscriptions...");
            }
        }

        $this->command->info("Total subscriptions created: $subscriptionsCreated");
    }

    /**
     * Create subscription invoices for a subscription
     *
     * @param  int  $userId
     * @param  string  $subscriptionId
     * @param  Plan  $plan
     * @param  \Carbon\Carbon  $startDate
     * @param  string  $status
     * @param  string  $billingPeriod
     * @param  \Carbon\Carbon|null  $endsAt
     * @param  int  &$invoiceCounter
     */
    private function createSubscriptionInvoices(
        int $userId,
        string $subscriptionId,
        Plan $plan,
        \Carbon\Carbon $startDate,
        string $status,
        string $billingPeriod,
        ?\Carbon\Carbon $endsAt,
        int &$invoiceCounter
    ): void {
        $customerId = (string) (5000000 + $userId);
        $totalPrice = $plan->price;
        $subtotal = (int) ($totalPrice * 0.9); // Simulate some discount
        $tax = (int) ($totalPrice * 0.1);
        $discountTotal = $totalPrice - $subtotal;

        // Determine invoice status based on subscription status
        $invoiceStatus = match ($status) {
            'active' => SubscriptionInvoice::STATUS_PAID,
            'past_due' => rand(0, 100) < 50 ? SubscriptionInvoice::STATUS_PENDING : SubscriptionInvoice::STATUS_PAID,
            'canceled' => rand(0, 100) < 20 ? SubscriptionInvoice::STATUS_REFUNDED : SubscriptionInvoice::STATUS_PAID,
            default => SubscriptionInvoice::STATUS_PAID,
        };

        $refunded = $invoiceStatus === SubscriptionInvoice::STATUS_REFUNDED;
        $refundedAt = $refunded ? $startDate->copy()->addDays(rand(1, 30)) : null;

        // Create initial invoice
        $initialInvoiceDate = $startDate->copy();
        $invoiceId = (string) ($invoiceCounter++);

        SubscriptionInvoice::create([
            'billable_type' => User::class,
            'billable_id' => $userId,
            'lemon_squeezy_id' => $invoiceId,
            'subscription_id' => $subscriptionId,
            'customer_id' => $customerId,
            'currency' => $plan->currency,
            'subtotal' => $subtotal,
            'discount_total' => $discountTotal,
            'tax' => $tax,
            'total' => $totalPrice,
            'status' => $invoiceStatus,
            'invoice_url' => $invoiceStatus === SubscriptionInvoice::STATUS_PAID
                ? "https://app.lemonsqueezy.com/invoice/{$invoiceId}"
                : null,
            'refunded' => $refunded,
            'refunded_at' => $refundedAt,
            'billing_reason' => SubscriptionInvoice::BILLING_REASON_INITIAL,
            'card_brand' => rand(0, 100) < 50 ? ['visa', 'mastercard', 'amex'][array_rand(['visa', 'mastercard', 'amex'])] : null,
            'card_last_four' => rand(0, 100) < 50 ? str_pad((string) rand(0, 9999), 4, '0', STR_PAD_LEFT) : null,
            'invoiced_at' => $initialInvoiceDate,
        ]);

        // For active subscriptions, create renewal invoices based on billing period
        if ($status === 'active') {
            $currentDate = $initialInvoiceDate->copy();
            $maxInvoices = match ($billingPeriod) {
                'year', 'yearly' => 3, // Up to 3 years of invoices
                'month', 'monthly' => 12, // Up to 12 months of invoices
                'week', 'weekly' => 24, // Up to 24 weeks of invoices
                'day', 'daily' => 30, // Up to 30 days of invoices
                default => 12,
            };

            $invoiceCount = 0;
            while ($invoiceCount < $maxInvoices && $currentDate < now()) {
                // Move to next billing period
                $currentDate = match ($billingPeriod) {
                    'year', 'yearly' => $currentDate->copy()->addYear(),
                    'month', 'monthly' => $currentDate->copy()->addMonth(),
                    'week', 'weekly' => $currentDate->copy()->addWeek(),
                    'day', 'daily' => $currentDate->copy()->addDay(),
                    default => $currentDate->copy()->addMonth(),
                };

                // Stop if we've passed the end date (for canceled subscriptions)
                if ($endsAt && $currentDate > $endsAt) {
                    break;
                }

                // Stop if we've passed today
                if ($currentDate > now()) {
                    break;
                }

                // Occasionally skip an invoice to simulate missed payments (5% chance)
                if (rand(0, 100) < 5) {
                    continue;
                }

                $renewalInvoiceId = (string) ($invoiceCounter++);

                SubscriptionInvoice::create([
                    'billable_type' => User::class,
                    'billable_id' => $userId,
                    'lemon_squeezy_id' => $renewalInvoiceId,
                    'subscription_id' => $subscriptionId,
                    'customer_id' => $customerId,
                    'currency' => $plan->currency,
                    'subtotal' => $subtotal,
                    'discount_total' => $discountTotal,
                    'tax' => $tax,
                    'total' => $totalPrice,
                    'status' => SubscriptionInvoice::STATUS_PAID,
                    'invoice_url' => "https://app.lemonsqueezy.com/invoice/{$renewalInvoiceId}",
                    'refunded' => false,
                    'refunded_at' => null,
                    'billing_reason' => SubscriptionInvoice::BILLING_REASON_RENEWAL,
                    'card_brand' => rand(0, 100) < 50 ? ['visa', 'mastercard', 'amex'][array_rand(['visa', 'mastercard', 'amex'])] : null,
                    'card_last_four' => rand(0, 100) < 50 ? str_pad((string) rand(0, 9999), 4, '0', STR_PAD_LEFT) : null,
                    'invoiced_at' => $currentDate,
                ]);

                $invoiceCount++;
            }
        }
    }
}
