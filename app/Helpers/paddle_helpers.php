<?php

use App\Models\Order;
use App\Models\Plan;
use App\Models\Product;
use App\Models\User;
use App\Notifications\OrderPaidAdminNotification;
use App\Notifications\OrderPaidNotification;
use Illuminate\Support\Facades\Log;

if (! function_exists('handle_paddle_price_created')) {
    /**
     * Handle the Paddle price.created webhook event
     *
     * @param  array  $payload  The Paddle webhook payload
     * @return \App\Models\Plan|null
     */
    function handle_paddle_price_created(array $payload)
    {
        // Extract the data from the payload
        $data = $payload['data'];

        // Check if this is a subscription plan or one-time product
        if (isset($data['billing_cycle'])) {
            return handle_subscription_plan_created($data);
        } else {
            return handle_one_time_product_created($data);
        }
    }
}

if (! function_exists('handle_subscription_plan_created')) {
    /**
     * Handle creation of subscription plan
     *
     * @return \App\Models\Plan
     */
    function handle_subscription_plan_created(array $planData)
    {
        // Extract features from custom data
        $features = [];
        if (! empty($planData['custom_data']['features'])) {
            $features = array_map('trim', explode(',', $planData['custom_data']['features']));
        }

        // Map the Paddle data to your Plan model structure
        $plan = Plan::create([
            'name' => $planData['name'],
            'paddle_id' => $planData['id'],
            'description' => $planData['description'] ?? null,
            'price' => intval($planData['unit_price']['amount']),
            'currency' => $planData['unit_price']['currency_code'],
            'billing_period' => $planData['billing_cycle']['interval'],
            'status' => $planData['status'],
            'trial_period' => $planData['trial_period']['frequency'] ?? null,
            'trial_interval' => $planData['trial_period']['interval'] ?? null,
            'is_featured' => $planData['custom_data']['is_featured'] ?? false,
            'features' => $features,
        ]);

        Log::info('New subscription plan created from Paddle webhook', [
            'plan_id' => $plan->id,
            'paddle_id' => $plan->paddle_id,
            'name' => $plan->name,
        ]);

        return $plan;
    }
}

if (! function_exists('handle_one_time_product_created')) {
    /**
     * Handle creation of one-time product
     *
     * @return \App\Models\Product|null
     */
    function handle_one_time_product_created(array $productData)
    {
        // Extract features from custom data if exists
        $features = [];
        if (! empty($productData['custom_data']['features'])) {
            $features = array_map('trim', explode(',', $productData['custom_data']['features']));
        }

        // Create the product
        $product = Product::create([
            'name' => $productData['name'],
            'paddle_id' => $productData['id'],
            'description' => $productData['description'] ?? null,
            'img_url' => $productData['custom_data']['img_url'] ?? 'https://placehold.co/600x400',
            'price' => intval($productData['unit_price']['amount']),
            'currency' => $productData['unit_price']['currency_code'],
            'status' => $productData['status'],
            'features' => $features,
            'category' => $productData['custom_data']['category'] ?? null,
            'is_featured' => $productData['custom_data']['is_featured'] ?? false,
            'delivery_method' => $productData['custom_data']['delivery_method'] ?? null,
        ]);

        Log::info('New product created from Paddle webhook', [
            'product_id' => $product->id,
            'paddle_id' => $product->paddle_id,
            'name' => $product->name,
        ]);

        return $product;
    }
}

if (! function_exists('handle_paddle_price_updated')) {
    /**
     * Handle the Paddle price.updated webhook event
     *
     * @param  array  $payload  The Paddle webhook payload
     * @return \App\Models\Plan|null
     */
    function handle_paddle_price_updated(array $payload)
    {
        $data = $payload['data'];

        // Check if this is a subscription plan or one-time product
        if (isset($data['billing_cycle'])) {
            return handle_subscription_plan_updated($data);
        } else {
            return handle_one_time_product_updated($data);
        }
    }
}

if (! function_exists('handle_subscription_plan_updated')) {
    function handle_subscription_plan_updated(array $planData)
    {
        $plan = Plan::where('paddle_id', $planData['id'])->first();

        // Extract features from custom data
        $features = [];
        if (! empty($planData['custom_data']['features'])) {
            $features = array_map('trim', explode(',', $planData['custom_data']['features']));
        }

        if ($plan) {
            $plan->update([
                'name' => $planData['name'],
                'description' => $planData['description'] ?? null,
                'price' => intval($planData['unit_price']['amount']),
                'currency' => $planData['unit_price']['currency_code'],
                'billing_period' => $planData['billing_cycle']['interval'],
                'trial_period' => $planData['trial_period']['frequency'] ?? null,
                'trial_interval' => $planData['trial_period']['interval'] ?? null,
                'status' => $planData['status'],
                'features' => $features,
                'is_featured' => $planData['custom_data']['is_featured'] ?? false,
            ]);

            Log::info('Subscription plan updated:', [
                'plan_id' => $plan->id,
                'paddle_id' => $plan->paddle_id,
                'name' => $plan->name,
            ]);
        } else {
            Log::warning('Attempted to update non-existent subscription plan:', [
                'paddle_id' => $planData['id'],
            ]);
        }

        return $plan;
    }
}

if (! function_exists('handle_one_time_product_updated')) {
    /**
     * Handle update of one-time product.
     * Creates the product if it doesn't exist.
     *
     * @return \App\Models\Product
     */
    function handle_one_time_product_updated(array $productData)
    {
        // Extract features from custom data if exists
        $features = [];
        if (! empty($productData['custom_data']['features'])) {
            $features = array_map('trim', explode(',', $productData['custom_data']['features']));
        }

        $wasExisting = Product::where('paddle_id', $productData['id'])->exists();

        $product = Product::updateOrCreate(
            ['paddle_id' => $productData['id']],
            [
                'name' => $productData['name'],
                'description' => $productData['description'] ?? null,
                'img_url' => $productData['custom_data']['img_url'] ?? 'https://placehold.co/600x400',
                'price' => intval($productData['unit_price']['amount']),
                'currency' => $productData['unit_price']['currency_code'],
                'status' => $productData['status'] ?? null,
                'features' => $features,
                'category' => $productData['custom_data']['category'] ?? null,
                'is_featured' => $productData['custom_data']['is_featured'] ?? false,
                'delivery_method' => $productData['custom_data']['delivery_method'] ?? null,
            ],
        );

        Log::info($wasExisting ? 'Product updated from Paddle webhook' : 'Product created from Paddle webhook (update event)', [
            'product_id' => $product->id,
            'paddle_id' => $product->paddle_id,
            'name' => $product->name,
        ]);

        return $product;
    }
}

if (! function_exists('handle_paddle_transaction_completed')) {
    function handle_paddle_transaction_completed(array $payload)
    {
        $data = $payload['data'];

        // Get the order ID from custom data
        $orderId = $data['custom_data']['order_id'] ?? null;

        if (! $orderId) {
            Log::warning('No order_id found in transaction custom data', [
                'transaction_id' => $data['id'],
            ]);

            return null;
        }

        $order = Order::with(['user', 'product'])->find($orderId);

        if (! $order) {
            Log::warning('Order not found for transaction', [
                'order_id' => $orderId,
                'transaction_id' => $data['id'],
            ]);

            return null;
        }

        // Get the actual amount paid (grand_total includes tax, discounts, etc.)
        $grandTotal = $data['details']['totals']['grand_total'] ?? null;
        $total = $grandTotal ? intval($grandTotal) : $order->total;

        // Update order with payment details
        $order->update([
            'status' => 'paid',
            'paid_at' => now(),
            'paddle_id' => $data['id'],
            'invoice_number' => $data['invoice_number'],
            'total' => $total,
        ]);

        // Send notification to the user who placed the order
        if ($order->user) {
            $order->user->notify(new OrderPaidNotification($order));
        }

        // Send notification to all admin users
        $adminUsers = User::whereHas('roles', function ($query) {
            $query->where('name', 'admin');
        })->get();

        foreach ($adminUsers as $admin) {
            $admin->notify(new OrderPaidAdminNotification($order));
        }

        Log::info('Order marked as paid from Paddle webhook', [
            'order_id' => $order->id,
            'transaction_id' => $data['id'],
        ]);

        return $order;
    }
}
