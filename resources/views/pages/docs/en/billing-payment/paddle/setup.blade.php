@push('head')
    <title>Paddle Setup - {{ config('app.name') }}</title>
    <meta name="description"
        content="Learn how to configure Paddle Billing and Cashier Paddle in {{ config('app.name') }}, including sandbox setup and environment variables.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'Billing & Payments', 'url' => '#'], ['label' => 'Paddle', 'url' => '#'], ['label' => 'Setup', 'url' => '#']]">

    <h1>Paddle Setup</h1>
    <p class="text-on-surface-muted dark:text-on-surface-dark-muted">
        This guide explains how {{ config('app.name') }} integrates with Paddle Billing via Laravel Cashier Paddle and
        how to configure your Paddle account, sandbox mode, and environment variables.
    </p>

    <h2>1. Create Paddle Sandbox Account</h2>
    <p>
        <a href="https://sandbox-login.paddle.com/signup" target="_blank" rel="noopener noreferrer">Sign up for a Paddle
            sandbox account</a> complete all onboarding steps in the Paddle dashboard before continuing.
    </p>

    <h2>2. Enable Sandbox Mode</h2>
    <p>
        For development and testing, enable <strong>Sandbox mode</strong> in the Paddle dashboard > Developer Tools >
        Authentication. Create the following tokens:
    </p>
    <ul>
        <li>API key</li>
        <li>Client side token</li>
    </ul>
    <p>
        These values should be stored in your <code>.env</code> file; see the example in the code snippet below.
    </p>

    <pre><code>
PADDLE_SANDBOX=true # Do not add this to your production environment
PADDLE_CLIENT_SIDE_TOKEN=XXXXXXXXXXXXXXXXXXXXX
PADDLE_API_KEY=XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
PADDLE_WEBHOOK_SECRET=XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX # After you create the webhook in the Paddle dashboard</code></pre>

    <p>
        After changing these values, clear and cache your configuration:
    </p>

    <pre><code class="language-bash">php artisan config:clear
php artisan config:cache</code></pre>

    <h2>3. Add App URL to Checkout Overlay Tab</h2>
    <p>
        {{ config('app.name') }} uses the <strong>Checkout Overlay</strong> feature to display the Paddle checkout
        overlay. You need to add your app URL to the <strong>Checkout Overlay</strong> tab in the Paddle dashboard >
        Checkout > Checkout Settings > General > Default Payment Linke. in developmene you can use
        https://127.0.0.1:8000.
    </p>

    <p>
        See the dedicated <a href="{{ route('docs.show', 'billing-payment/paddle/webhooks') }}">Paddle Webhooks</a> page for details on
        configuring and testing webhooks.
    </p>

    <h2>Webhooks</h2>
    <p>
        Webhooks are used to receive events from Paddle and keep your local database in sync. See the dedicated <a href="{{ route('docs.show', 'billing-payment/paddle/webhooks') }}">Paddle Webhooks</a> page for details on
        configuring and testing webhooks.
    </p>

    <h2>Switching Between Sandbox &amp; Production</h2>
    <p>
        When you are ready to go live:
    </p>
    <ul>
        <li>Set <code>PADDLE_SANDBOX=false</code>.</li>
        <li>Replace your sandbox credentials with live Paddle Vendor ID, auth code, and public key.</li>
        <li>Verify that webhooks are configured for the live environment.</li>
    </ul>

    <p>
        Always test new billing flows thoroughly in sandbox before switching your production credentials.
    </p>

    <x-alert variant="info" class="my-6">
        To go live, please follow <a href="https://developer.paddle.com/build/onboarding/go-live-checklist"
            target="_blank" rel="noopener noreferrer">Paddle's go to live checklist</a>.
    </x-alert>

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
                <td>Order model with Paddle transaction relationship</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Model</x-badge></td>
                <td><strong>App\Models\Plan</strong></td>
                <td>Subscription plan model with Paddle price ID</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Model</x-badge></td>
                <td><strong>App\Models\Product</strong></td>
                <td>One-time product model with Paddle price ID</td>
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
                <td><strong>App\Http\Controllers\TransactionController</strong></td>
                <td>Handles user transaction viewing and invoice downloads</td>
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
                <td><strong>App\Livewire\Orders\OrdersTable</strong></td>
                <td>User orders table with search and pagination</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Livewire</x-badge></td>
                <td><strong>App\Livewire\Transactions\TransactionsTable</strong></td>
                <td>User transactions table with pagination</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Livewire</x-badge></td>
                <td><strong>App\Livewire\Admin\Subscription\CancelSubscription</strong></td>
                <td>Admin component for canceling user subscriptions</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Livewire</x-badge></td>
                <td><strong>App\Livewire\Admin\Transactions\TransactionsTable</strong></td>
                <td>Admin transactions table component</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Listener</x-badge></td>
                <td><strong>App\Listeners\PaddleEventListener</strong></td>
                <td>Handles Paddle webhook events (price.created, price.updated, transaction.completed)</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Helper</x-badge></td>
                <td><strong>app/Helpers/paddle_helpers.php</strong></td>
                <td>Helper functions for processing Paddle webhook payloads</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Command</x-badge></td>
                <td><strong>App\Console\Commands\DeleteOldIncompleteOrders</strong></td>
                <td>Artisan command to clean up incomplete orders older than 24 hours</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Migration</x-badge></td>
                <td><strong>create_orders_table</strong></td>
                <td>Migration for orders table with paddle_id field</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Migration</x-badge></td>
                <td><strong>create_plans_table</strong></td>
                <td>Migration for plans table with paddle_id field</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Migration</x-badge></td>
                <td><strong>create_products_table</strong></td>
                <td>Migration for products table with paddle_id field</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Migration</x-badge></td>
                <td><strong>create_subscriptions_table</strong></td>
                <td>Laravel Cashier migration for subscriptions with paddle_id</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Migration</x-badge></td>
                <td><strong>create_customers_table</strong></td>
                <td>Laravel Cashier migration for customers with paddle_id</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Migration</x-badge></td>
                <td><strong>create_transactions_table</strong></td>
                <td>Laravel Cashier migration for transactions with paddle_id</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Routes</x-badge></td>
                <td><strong>GET /plans/start (plans.start)</strong></td>
                <td>Route to view available subscription plans</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Routes</x-badge></td>
                <td><strong>GET /plans/{price_id} (plans.show)</strong></td>
                <td>Route to initiate subscription checkout</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Routes</x-badge></td>
                <td><strong>GET /products (products.index)</strong></td>
                <td>Route to view available products</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Routes</x-badge></td>
                <td><strong>GET /products/{product} (products.show)</strong></td>
                <td>Route to initiate product checkout</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Routes</x-badge></td>
                <td><strong>GET /orders (orders.index)</strong></td>
                <td>Route to view user orders</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Routes</x-badge></td>
                <td><strong>GET /orders/pending/{order_id} (orders.pending)</strong></td>
                <td>Route to view order pending page after checkout</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Routes</x-badge></td>
                <td><strong>GET /orders/status/{order_id} (orders.status)</strong></td>
                <td>Route to check order status (returns JSON)</td>
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
                <td><strong>GET /transactions (transactions.index)</strong></td>
                <td>Route to view user transactions</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Routes</x-badge></td>
                <td><strong>GET /admin/orders (admin.orders.index)</strong></td>
                <td>Admin route to view all orders</td>
            </tr>
        </tbody>
    </table>

</x-layouts.docs>
