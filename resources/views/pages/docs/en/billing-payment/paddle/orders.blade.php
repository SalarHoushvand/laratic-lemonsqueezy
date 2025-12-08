@push('head')
    <title>Paddle Orders &amp; Transactions - {{ config('app.name') }}</title>
    <meta name="description"
        content="Understand how orders and transactions work with Paddle Billing in {{ config('app.name') }}, including user and admin views.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'Billing & Payments', 'url' => '#'], ['label' => 'Paddle', 'url' => '#'], ['label' => 'Orders & Transactions', 'url' => '#']]">

    <h1>Orders &amp; Transactions</h1>
    <p class="text-on-surface-muted dark:text-on-surface-dark-muted">
        Admins can view orders and transactions.
    </p>

    <h2>Order Lifecycle</h2>
    <p>
        An order is created whenever a user starts a one-time purchase or a subscription flow that needs local tracking.
        The typical lifecycle is:
    </p>

    <ol>
        <li>An <code>Order</code> record is created with the status
            <code>incomplete</code> once the user starts a one-time
            purchase or a subscription flow.
        </li>
        <li>User continues the checkout process using the checkout overlay.
        </li>
        <li>Once the payment is submitted, the user is redirected to the pending page.
        </li>
        <li>When Paddle sends a <code>transaction.completed</code> webhook, the order is marked as paid and invoice
            details are stored. User is redirected to the orders page.</li>
    </ol>

    <h2>Cleaning Up Incomplete Orders</h2>
    <p>
        Incomplete orders can take up space in the database and could be safely deleted after a certain period of time.
        You can use the following command to delete all incomplete orders older than 24 hours.
    </p>

    <pre><code class="language-bash">php artisan orders:delete-old-incomplete</code></pre>

    <p>
        This command will:
    </p>

    <ul>
        <li>Find all orders with <code>status = 'incomplete'</code> that were created more than 24 hours ago.</li>
        <li>Delete those orders from the database.</li>
        <li>Display a message indicating how many orders were deleted.</li>
    </ul>

    <h2>Order Page for Users</h2>
    <p>
        {{ config('app.name') }} has a order page for users that displays all their order history.
    </p>
    <img src="{{ asset('images/docs/orders-user-dark.webp') }}" alt="Orders User" class="hidden dark:block">
    <img src="{{ asset('images/docs/orders-user-light.webp') }}" alt="Orders User" class="dark:hidden">

    <h2>Transactions &amp; Invoices</h2>
    <p>
        In addition to orders, users can view their transactions and download invoices.
    </p>
    <img src="{{ asset('images/docs/transactions-user-dark.webp') }}" alt="Transactions User" class="hidden dark:block">
    <img src="{{ asset('images/docs/transactions-user-light.webp') }}" alt="Transactions User" class="dark:hidden">

    <h2>Admin Orders &amp; Transactions</h2>
    <p>
        Admins can review and manage orders and transactions.
    </p>
    <img src="{{ asset('images/docs/admin-orders-dark.webp') }}" alt="Orders Admin" class="hidden dark:block border-0!">
    <img src="{{ asset('images/docs/admin-orders-light.webp') }}" alt="Orders Admin" class="dark:hidden border-0!">



</x-layouts.docs>
