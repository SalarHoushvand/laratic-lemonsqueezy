@push('head')
    <title>Lemon Squeezy Subscriptions &amp; Pricing - {{ config('app.name') }}</title>
    <meta name="description"
        content="Learn how subscription plans, pricing, monthly and yearly options are managed with Lemon Squeezy in {{ config('app.name') }}.">
@endpush

<x-layouts.docs :breadcrumbs="[
    ['label' => 'Billing & Payments', 'url' => '#'],
    ['label' => 'Lemon Squeezy', 'url' => '#'],
    ['label' => 'Subscriptions', 'url' => '#'],
]">

    <h1>Subscriptions, Plans &amp; Pricing Page</h1>
    <p class="text-on-surface-muted dark:text-on-surface-dark-muted">
        {{ config('app.name') }} is configured to easily sell recurring subscription plans. You can create or update
        monthly and yearly subscription plans in your Lemon Squeezy dashboard and sync them to your app.
    </p>

    <h2>Adding New Subscription Plans</h2>
    <p>
        To add a new subscription plan in Lemon Squeezy:
    </p>

    <ol>
        <li>Go to your <strong>Store</strong> > <strong>Products</strong> in the Lemon Squeezy dashboard.</li>
        <li>Click <strong>Add New Product</strong>.</li>
        <li>Add a name and description. You can add a list of features in the description.
            <img src="{{ asset('images/docs/lemonsqueezy-add-product-details.webp') }}" alt="Add Product Details"
                class="w-full md:w-2/3">
        </li>
        <li>Choose <strong>Subscription Pricing</strong>.</li>
        <li>Set the price and interval (monthly or yearly).
            <img src="{{ asset('images/docs/lemonsqueezy-add-product-sub-pricing.webp') }}" alt="Add Product Details"
                class="w-full md:w-2/3">
        </li>
        <li>If it has a free trial, turn that feature on and assign a value to it.
            <img src="{{ asset('images/docs/lemonsqueezy-add-product-sub-trial.webp') }}" alt="Add Product Details"
                class="w-full md:w-2/3">
        </li>
        <li>Save the product.</li>
        <li>Sync your products from Lemon Squeezy using:
            <pre><code class="language-bash">php artisan lemonsqueezy:sync-products</code></pre>
            Or use the admin panel sync button at Admin > Plans & Products.

            <img src="{{ asset('images/docs/admin-lemonsqueezy-sync-dark.webp') }}" alt="Products User"
                class="hidden dark:block">
            <img src="{{ asset('images/docs/admin-lemonsqueezy-sync-light.webp') }}" alt="Products User"
                class="dark:hidden">
        </li>
    </ol>

    <x-alert variant="warning" title="Important" class="my-6">
        <p class="text-sm">
            {{ config('app.name') }} assumes each product has a single variant. Please don't add any variants to the
            products and leave it as the default variant.
        </p>
    </x-alert>

    <p>
        When you sync, the command will create a <code>Plan</code> record for each subscription variant. Once
        the plan exists and has an <code>published</code> status, it will appear on the pricing page.
    </p>

    <h2>Updating Plans</h2>
    <p>
        Any updates to a subscription plan in the Lemon Squeezy dashboard will be synced when you run the sync command.

    </p>

    <p>
        To hide a plan from the public pricing page, you can either:
    </p>
    <ul>
        <li>Delete or archive the variant in Lemon Squeezy and sync</li>
    </ul>

    <h2>Pricing Page (Monthly &amp; Yearly)</h2>
    <p>
        {{ config('app.name') }} has a pricing page that displays all active subscription plans. When you add a new plan
        in Lemon Squeezy (Monthly or Yearly) and sync, it will appear on the pricing page.You can sort or promote plans
        in your admin dashboard>Plans & Products.
    </p>
    <img src="{{ asset('images/docs/pricing-lemonsqueezy-dark.webp') }}" alt="Products User" class="hidden dark:block">
    <img src="{{ asset('images/docs/pricing-lemonsqueezy-light.webp') }}" alt="Products User" class="dark:hidden">

    <h2>Managing an Active Subscription</h2>
    <p>
        {{ config('app.name') }} has a subscription management page that allows users to manage their subscription.
        You can cancel or update your subscription from the subscription management page.
    </p>
    <img src="{{ asset('images/docs/manage-sub-lemonsqueezy-dark.webp') }}" alt="Products User" class="hidden dark:block">
    <img src="{{ asset('images/docs/manage-sub-lemonsqueezy-light.webp') }}" alt="Products User" class="dark:hidden">


</x-layouts.docs>
