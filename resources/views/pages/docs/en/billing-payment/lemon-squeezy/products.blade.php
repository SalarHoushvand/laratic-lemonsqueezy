@push('head')
    <title>Lemon Squeezy One-Time Products - {{ config('app.name') }}</title>
    <meta name="description"
        content="Learn how to define and sell single-payment products with Lemon Squeezy in {{ config('app.name') }}.">
@endpush

<x-layouts.docs :breadcrumbs="[
    ['label' => 'Billing & Payments', 'url' => '#'],
    ['label' => 'Lemon Squeezy', 'url' => '#'],
    ['label' => 'One-Time Products', 'url' => '#'],
]">

    <h1>One-Time Products (Single Payments)</h1>
    <p class="text-on-surface-muted dark:text-on-surface-dark-muted">
        With {{ config('app.name') }} you can easily sell one-time products (single payments). You can create or update
        one-time products in your Lemon Squeezy dashboard and sync them to your local database.
    </p>

    <h2>Adding New One-Time Products</h2>
    <p>
        To add a new one-time product in Lemon Squeezy:
    </p>

    <ol>
        <li>Go to your <strong>Store</strong> > <strong>Products</strong> in the Lemon Squeezy dashboard.</li>
        <li>Click <strong>Add New Product</strong>.</li>
        <li>Add a name and description. You can add a list of features in the description.
            <img src="{{ asset('images/docs/lemonsqueezy-add-product-details.webp') }}" alt="Add Product Details"
                class="w-full md:w-2/3">
        </li>
        <li>Choose <strong>Single payment</strong>.</li>
        <li>Set the price.</li>
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
        When you sync, the command will create or update a <code>Product</code> record for each one-time variant. Once
        the product exists and has a <code>published</code> status, it will appear on the products page.
    </p>

    <h2>Updating Products</h2>
    <p>
        Any updates to a one-time product in the Lemon Squeezy dashboard will be synced when you run the sync command.
    </p>

    <p>
        To hide a product from the public products page:
    </p>
    <ul>
        <li>Delete or archive the variant in Lemon Squeezy and sync</li>
    </ul>

    <h2>Product Listing Page</h2>
    <p>
        {{ config('app.name') }} has a product listing page that displays all active one-time products. You can sort or
        promote products in your admin dashboard > Plans & Products.
    </p>
    <img src="{{ asset('images/docs/products-lemonsqueezy-dark.webp') }}" alt="Products User" class="hidden dark:block">
    <img src="{{ asset('images/docs/products-lemonsqueezy-light.webp') }}" alt="Products User" class="dark:hidden">

</x-layouts.docs>

