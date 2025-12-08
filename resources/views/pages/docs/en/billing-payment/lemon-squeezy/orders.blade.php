@push('head')
    <title>Lemon Squeezy Orders &amp; Transactions - {{ config('app.name') }}</title>
    <meta name="description"
        content="Understand how orders and transactions work with Lemon Squeezy in {{ config('app.name') }}, including user and admin views.">
@endpush

<x-layouts.docs :breadcrumbs="[
    ['label' => 'Billing & Payments', 'url' => '#'],
    ['label' => 'Lemon Squeezy', 'url' => '#'],
    ['label' => 'Orders & Transactions', 'url' => '#'],
]">

    <h1>Order History</h1>
    <p class="text-on-surface-muted dark:text-on-surface-dark-muted">
        Lemonsqueezy consolidates orders and transactions into a single order history for you.
    </p>

    <h2>Order Types</h2>
    <p>
        Orders can be one of two types:
    </p>
    <ul>
        <li><strong>One-time</strong> - Orders for single-payment products</li>
        <li><strong>Subscription</strong> - Orders created from subscription payment success events</li>
    </ul>

    <h2>Order Page for Users</h2>
    <p>
        {{ config('app.name') }} has an order page for users that displays all their order history. This includes both
        one-time and subscription orders.
    </p>
    <img src="{{ asset('images/docs/user-orders-lemonsqueezy-dark.webp') }}" alt="User Orders" class="hidden dark:block">
    <img src="{{ asset('images/docs/user-orders-lemonsqueezy-light.webp') }}" alt="User Orders" class="dark:hidden">


    <h2>Admin Orders</h2>
    <p>
        Admins can review and manage all orders and transactions from the admin panel. The admin orders page shows:
    </p>
    <img src="{{ asset('images/docs/admin-orders-lemonsqueezy-dark.webp') }}" alt="Admin Orders"
        class="hidden dark:block border-0!">
    <img src="{{ asset('images/docs/admin-orders-lemonsqueezy-light.webp') }}" alt="Admin Orders" class="dark:hidden border-0!">

   

</x-layouts.docs>
