@push('head')
    <title>Lemon Squeezy Setup - {{ config('app.name') }}</title>
    <meta name="description"
        content="Learn how to configure Lemon Squeezy in {{ config('app.name') }}, including API keys, store configuration, and environment variables.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'Billing & Payments', 'url' => '#'], ['label' => 'Lemon Squeezy', 'url' => '#'], ['label' => 'Setup', 'url' => '#']]">

    <h1>Lemon Squeezy Setup</h1>
    <p class="text-on-surface-muted dark:text-on-surface-dark-muted">
        There are some differences between the Lemon Squeezy setup and the Paddle setup. This guide explains how to configure Lemon Squeezy in {{ config('app.name') }}.
    </p>

    <h2>1. Create Lemon Squeezy Account</h2>
    <p>
        <a href="https://lemonsqueezy.com" target="_blank" rel="noopener noreferrer">Sign up for a Lemon Squeezy
            account</a> and complete all onboarding steps in the Lemon Squeezy dashboard before continuing.
    </p>

    <h2>2. Get Your Store ID and API Key</h2>
    <p>
        To configure Lemon Squeezy integration, you need:
    </p>
    <ul>
        <li><strong>Store ID</strong> - Found in your Lemon Squeezy dashboard under Settings > Stores</li>
        <li><strong>API Key</strong> - Create an API key in Settings > API</li>
        <li><strong>Signing Secret</strong> - Skip this for now.</li>
    </ul>
    <p>
        These values should be stored in your <code>.env</code> file; see the example in the code snippet below.
    </p>

    <pre><code>
LEMON_SQUEEZY_STORE=your_store_id
LEMON_SQUEEZY_API_KEY=your_api_key_here
LEMON_SQUEEZY_SIGNING_SECRET=skip_for_now</code></pre>

    <p>
        After changing these values, clear and cache your configuration:
    </p>

    <pre><code class="language-bash">php artisan config:clear
php artisan config:cache</code></pre>

    <h2>3. Configure Webhooks</h2>
    <p>
        Webhooks are used to receive events from Lemon Squeezy and keep your local database in sync. See the <a href="{{ route('docs.show', 'billing-payment/lemon-squeezy/webhooks') }}">Webhooks</a> page for more information.
    </p>

    <h2>4. Add Products and Plans</h2>
    <p>
        After setting up your Lemon Squeezy account, you can add your products and subscription plans. Please follow the guides on the <a href="{{ route('docs.show', 'billing-payment/lemon-squeezy/products') }}">Products</a> pages.
    </p>

    <h2>References</h2>
    <table>
        <thead>
            <tr>
                <th>Category</th>
                <th>Path / Name</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><x-badge variant="outline-primary">Model</x-badge></td>
                <td><strong>App\Models\Order</strong></td>
                <td>Order model with Lemon Squeezy order relationship</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Model</x-badge></td>
                <td><strong>App\Models\Plan</strong></td>
                <td>Subscription plan model with Lemon Squeezy variant ID</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Model</x-badge></td>
                <td><strong>App\Models\Product</strong></td>
                <td>One-time product model with Lemon Squeezy variant ID</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Controller</x-badge></td>
                <td><strong>App\Http\Controllers\PlanController</strong></td>
                <td>Handles subscription plan viewing and checkout</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Controller</x-badge></td>
                <td><strong>App\Http\Controllers\ProductController</strong></td>
                <td>Handles one-time product viewing and checkout</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Controller</x-badge></td>
                <td><strong>App\Http\Controllers\OrderController</strong></td>
                <td>Handles user order viewing and status checks</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Controller</x-badge></td>
                <td><strong>App\Http\Controllers\SubscriptionController</strong></td>
                <td>Handles subscription status and pending pages</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Controller</x-badge></td>
                <td><strong>App\Http\Controllers\Admin\OrderController</strong></td>
                <td>Admin controller for viewing orders and transactions</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Livewire</x-badge></td>
                <td><strong>App\Livewire\Subscription\Manage</strong></td>
                <td>Subscription management component (swap, cancel, update payment)</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Livewire</x-badge></td>
                <td><strong>App\Livewire\Admin\PlansProducts</strong></td>
                <td>Admin component for managing plans and products with sync functionality</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Listener</x-badge></td>
                <td><strong>App\Listeners\LemonSqueezyEventListener</strong></td>
                <td>Handles Lemon Squeezy webhook events (order_created, subscription_payment_success)</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Command</x-badge></td>
                <td><strong>App\Console\Commands\SyncLemonSqueezyProducts</strong></td>
                <td>Artisan command to sync products and plans from Lemon Squeezy</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Migration</x-badge></td>
                <td><strong>create_orders_table</strong></td>
                <td>Migration for orders table with lemon_squeezy_id field</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Migration</x-badge></td>
                <td><strong>create_plans_table</strong></td>
                <td>Migration for plans table with lemon_squeezy_product_id and lemon_squeezy_variant_id fields</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Migration</x-badge></td>
                <td><strong>create_products_table</strong></td>
                <td>Migration for products table with lemon_squeezy_product_id and lemon_squeezy_variant_id fields</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Migration</x-badge></td>
                <td><strong>create_lemon_squeezy_subscriptions_table</strong></td>
                <td>Lemon Squeezy package migration for subscriptions</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Migration</x-badge></td>
                <td><strong>create_lemon_squeezy_customers_table</strong></td>
                <td>Lemon Squeezy package migration for customers</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Routes</x-badge></td>
                <td><strong>GET /plans/start (plans.start)</strong></td>
                <td>Route to view available subscription plans</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Routes</x-badge></td>
                <td><strong>GET /plans/{variant_id} (plans.show)</strong></td>
                <td>Route to initiate subscription checkout</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Routes</x-badge></td>
                <td><strong>GET /products (products.index)</strong></td>
                <td>Route to view available products</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Routes</x-badge></td>
                <td><strong>GET /products/{variant_id} (products.show)</strong></td>
                <td>Route to initiate product checkout</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Routes</x-badge></td>
                <td><strong>GET /orders (orders.index)</strong></td>
                <td>Route to view user orders</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Routes</x-badge></td>
                <td><strong>GET /subscription/pending (subscription.pending)</strong></td>
                <td>Route to view subscription pending page after checkout</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Routes</x-badge></td>
                <td><strong>GET /subscription/status (subscription.status)</strong></td>
                <td>Route to check subscription status (returns JSON)</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Routes</x-badge></td>
                <td><strong>GET /subscription (subscription.manage)</strong></td>
                <td>Route to manage subscription (requires subscribed middleware)</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Routes</x-badge></td>
                <td><strong>GET /admin/orders (admin.orders.index)</strong></td>
                <td>Admin route to view all orders</td>
            </tr>
        </tbody>
    </table>

</x-layouts.docs>

