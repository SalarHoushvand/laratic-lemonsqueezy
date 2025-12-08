@push('head')
    <title>Paddle One-Time Products - {{ config('app.name') }}</title>
    <meta name="description"
        content="Learn how to define and sell single-payment products with Paddle Billing and Cashier in {{ config('app.name') }}.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'Billing & Payments', 'url' => '#'], ['label' => 'Paddle', 'url' => '#'], ['label' => 'One-Time Products', 'url' => '#']]">

    <h1>One-Time Products (Single Payments)</h1>
    <p class="text-on-surface-muted dark:text-on-surface-dark-muted">
        With {{ config('app.name') }} you can easily sell one-time products (single payments). You can create or update
        one-time products in your Paddle dashboard and they will be automatically synced into your local database.
    </p>

    <x-alert variant="warning" class="my-6">
        Paddle does <strong>NOT support physical products</strong> that require shipping. You should
        only use it for digital or online products such as downloads, licenses, or services.
    </x-alert>

    <h2>Adding New One-Time Products</h2>
    <p>To add a new single-payment product:</p>

    <ol>
        <li>Create a <strong>Product</strong> in the Paddle Billing dashboard (for example,
            <em>Pro Template Pack</em>).
        </li>
        <li>Define a <strong>Price</strong> for that product (for example, <code>price_template_pack</code>) with no
            recurring billing interval.</li>
        <li>Configure <strong>custom data</strong> fields so the app can render the product correctly:
            <ul>
                <li><code>features</code> &mdash; comma-separated feature list.</li>
                <li><code>img_url</code> &mdash; optional image URL (falls back to a placeholder if missing).</li>
                <li><code>category</code> &mdash; optional category string for grouping.</li>
                <li><code>is_featured</code> &mdash; <code>true</code> or <code>false</code> to highlight the product.
                </li>
                <li><code>delivery_method</code> &mdash; optional text like <em>download</em>, <em>email</em>, or
                    <em>license key</em> or any other delivery method.
                </li>
            </ul>
        </li>
        <li>Ensure Paddle sends <code>price.created</code> and <code>price.updated</code> webhooks to your app (see
            <a href="{{ route('docs.show', 'billing-payment/paddle/webhooks') }}">Paddle Webhooks</a>).
        </li>
    </ol>

    <p>
        When a webhook arrives, the corresponding helper will create or update the <code>Product</code> model and log
        what happened.
    </p>

    <h2>Product Listing Page</h2>
    <p>
        {{ config('app.name') }} has a product listing page that displays all active one-time products.
    </p>

    <img src="{{ asset('images/docs/products-user-dark.webp') }}" alt="Products User" class="hidden dark:block">
    <img src="{{ asset('images/docs/products-user-light.webp') }}" alt="Products User" class="dark:hidden">

    <h2>Updating or Hiding Products</h2>
    <p>
        Any updates to a one-time product in the Paddle dashboard will be automatically synced into your local database.
        You can also archive a product in Paddle to hide it from the public products page.
    </p>

</x-layouts.docs>
