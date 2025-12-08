<?php

namespace App\Listeners;

use Carbon\Carbon;
use LemonSqueezy\Laravel\Events\WebhookHandled;
use LemonSqueezy\Laravel\Order;
use LemonSqueezy\Laravel\Subscription;
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
                // Keep the order and update product_type
                $order->update(['product_type' => 'one-time']);

                Log::info('One-time order product_type updated', [
                    'order_id' => $orderId,
                    'product_type' => 'one-time',
                ]);
            } elseif ($orderType === 'subscription') {
                // Remove subscription orders (they will be created from subscription_payment_success)
                $order->delete();

                Log::info('Subscription order removed (will be created from subscription_payment_success)', [
                    'order_id' => $orderId,
                ]);
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
            $invoiceId = $payload['data']['id'] ?? null;
            $subscriptionId = $payload['data']['attributes']['subscription_id'] ?? null;
            $customData = $payload['meta']['custom_data'] ?? [];
            $attributes = $payload['data']['attributes'] ?? [];

            if (! $invoiceId || ! $subscriptionId) {
                Log::warning('Missing invoice_id or subscription_id in webhook payload', [
                    'invoice_id' => $invoiceId,
                    'subscription_id' => $subscriptionId,
                ]);

                return;
            }

            $billableId = $customData['billable_id'] ?? null;
            $billableType = $customData['billable_type'] ?? null;
            $customerId = $attributes['customer_id'] ?? null;

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

            // Find the subscription to get product_id and variant_id
            $subscription = Subscription::where('lemon_squeezy_id', (string) $subscriptionId)->first();

            if (! $subscription) {
                Log::warning('Subscription not found in database', [
                    'lemon_squeezy_id' => $subscriptionId,
                ]);

                return;
            }

            // Check if order already exists for this invoice
            $existingOrder = Order::where('lemon_squeezy_id', (string) $invoiceId)->first();

            if ($existingOrder) {
                Log::info('Order already exists for subscription invoice', [
                    'invoice_id' => $invoiceId,
                ]);

                return;
            }

            // Generate a unique identifier for the order
            $identifier = $attributes['urls']['invoice_url'] ?? 'sub-invoice-'.$invoiceId;

            // Create order from subscription invoice
            Order::create([
                'billable_id' => (int) $billableId,
                'billable_type' => $billableType,
                'lemon_squeezy_id' => (string) $invoiceId,
                'customer_id' => (string) $customerId,
                'identifier' => $identifier,
                'product_id' => (string) $subscription->product_id,
                'variant_id' => (string) $subscription->variant_id,
                'product_type' => 'subscription',
                'order_number' => (int) $invoiceId,
                'currency' => $attributes['currency'] ?? 'USD',
                'subtotal' => (int) ($attributes['subtotal'] ?? 0),
                'discount_total' => (int) ($attributes['discount_total'] ?? 0),
                'tax' => (int) ($attributes['tax'] ?? 0),
                'total' => (int) ($attributes['total'] ?? 0),
                'tax_name' => $attributes['tax_name'] ?? null,
                'status' => $attributes['status'] ?? 'paid',
                'receipt_url' => $attributes['urls']['invoice_url'] ?? null,
                'refunded' => (bool) ($attributes['refunded'] ?? false),
                'refunded_at' => $attributes['refunded_at'] ? Carbon::parse($attributes['refunded_at']) : null,
                'ordered_at' => isset($attributes['created_at']) ? Carbon::parse($attributes['created_at']) : now(),
            ]);

            Log::info('Subscription order created from payment success', [
                'invoice_id' => $invoiceId,
                'subscription_id' => $subscriptionId,
                'billable_id' => $billableId,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to handle subscription_payment_success event', [
                'error' => $e->getMessage(),
                'payload' => $payload,
            ]);
        }
    }
}