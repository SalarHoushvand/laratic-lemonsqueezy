<?php

namespace App\Listeners;

use App\Models\SubscriptionInvoice;
use Carbon\Carbon;
use LemonSqueezy\Laravel\Events\WebhookHandled;
use LemonSqueezy\Laravel\Order;
use Illuminate\Support\Facades\Log;

class LemonSqueezyEventListener
{
    /**
     * Handle received Lemon Squeezy webhooks.
     */
    public function handle(WebhookHandled $event): void
    {
        $eventName = $event->payload['meta']['event_name'] ?? null;

        if ($eventName === 'order_created') {
            $this->handleOrderCreated($event->payload);
        } elseif ($eventName === 'subscription_payment_success') {
            $this->handleSubscriptionPaymentSuccess($event->payload);
        }
    }

    /**
     * Handle order_created event
     */
    private function handleOrderCreated(array $payload): void
    {
        try {
            $orderId = $payload['data']['id'] ?? null;
            $orderType = $payload['meta']['custom_data']['order_type'] ?? null;

            if (! $orderId || ! $orderType) {
                Log::warning('Missing order_id or order_type in webhook payload', [
                    'order_id' => $orderId,
                    'order_type' => $orderType,
                ]);

                return;
            }

            $order = Order::where('lemon_squeezy_id', (string) $orderId)->first();

            if (! $order) {
                Log::warning('Order not found in database', [
                    'lemon_squeezy_id' => $orderId,
                ]);

                return;
            }

            if ($orderType === 'one-time') {
                // Update product_type for one-time orders
                $order->update(['product_type' => 'one-time']);
            } elseif ($orderType === 'subscription') {
                // Update product_type for subscription orders
                $order->update(['product_type' => 'subscription']);
            }
        } catch (\Exception $e) {
            Log::error('Failed to handle order_created event', [
                'error' => $e->getMessage(),
                'payload' => $payload,
            ]);
        }
    }

    /**
     * Handle subscription_payment_success event
     */
    private function handleSubscriptionPaymentSuccess(array $payload): void
    {
        try {
            $data = $payload['data'] ?? [];
            $attributes = $data['attributes'] ?? [];
            $customData = $payload['meta']['custom_data'] ?? [];

            $invoiceId = $data['id'] ?? null;
            $subscriptionId = $attributes['subscription_id'] ?? null;
            $customerId = $attributes['customer_id'] ?? null;
            $billableId = $customData['billable_id'] ?? null;
            $billableType = $customData['billable_type'] ?? null;

            if (! $invoiceId || ! $subscriptionId) {
                Log::warning('Missing invoice_id or subscription_id in webhook payload', [
                    'invoice_id' => $invoiceId,
                    'subscription_id' => $subscriptionId,
                ]);

                return;
            }

            if (! $billableId || ! $billableType) {
                Log::warning('Missing billable_id or billable_type in webhook payload', [
                    'billable_id' => $billableId,
                    'billable_type' => $billableType,
                ]);

                return;
            }

            if (! $customerId) {
                Log::warning('Missing customer_id in webhook payload', [
                    'invoice_id' => $invoiceId,
                ]);

                return;
            }

            // Check if invoice already exists
            $existingInvoice = SubscriptionInvoice::where('lemon_squeezy_id', (string) $invoiceId)->first();

            if ($existingInvoice) {
                Log::info('Subscription invoice already exists', [
                    'invoice_id' => $invoiceId,
                ]);

                return;
            }

            // Create subscription invoice
            SubscriptionInvoice::create([
                'billable_id' => (int) $billableId,
                'billable_type' => $billableType,
                'lemon_squeezy_id' => (string) $invoiceId,
                'subscription_id' => (string) $subscriptionId,
                'customer_id' => (string) $customerId,
                'currency' => $attributes['currency'] ?? 'USD',
                'subtotal' => (int) ($attributes['subtotal'] ?? 0),
                'discount_total' => (int) ($attributes['discount_total'] ?? 0),
                'tax' => (int) ($attributes['tax'] ?? 0),
                'total' => (int) ($attributes['total'] ?? 0),
                'status' => $attributes['status'] ?? 'paid',
                'invoice_url' => $attributes['urls']['invoice_url'] ?? null,
                'refunded' => (bool) ($attributes['refunded'] ?? false),
                'refunded_at' => isset($attributes['refunded_at']) && $attributes['refunded_at']
                    ? Carbon::parse($attributes['refunded_at'])
                    : null,
                'billing_reason' => $attributes['billing_reason'] ?? 'initial',
                'card_brand' => $attributes['card_brand'] ?? null,
                'card_last_four' => $attributes['card_last_four'] ?? null,
                'invoiced_at' => isset($attributes['created_at'])
                    ? Carbon::parse($attributes['created_at'])
                    : now(),
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to handle subscription_payment_success event', [
                'error' => $e->getMessage(),
                'payload' => $payload,
            ]);
        }
    }
}
