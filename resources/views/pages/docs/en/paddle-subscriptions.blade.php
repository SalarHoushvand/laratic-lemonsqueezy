@push('head')
    <title>Paddle Subscriptions &amp; Pricing - {{ config('app.name') }}</title>
    <meta name="description"
        content="Learn how subscription plans, pricing, monthly and yearly options are managed with Paddle and Cashier in {{ config('app.name') }}.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'Billing', 'url' => '#'], ['label' => 'Subscriptions', 'url' => '#']]">

    <h1>Subscriptions, Plans &amp; Pricing Page</h1>
    <p class="text-on-surface-muted dark:text-on-surface-dark-muted">
        {{ config('app.name') }} has configured to easily sell recurring subscription plans. You can create or update
        subscription plans in your Paddle dashboard and they will be automatically synced into your local database.
    </p>


    <h2>Adding New Subscription Plans</h2>
    <p>
        To add a new plan (for example, a Basic Monthly and Basic Yearly option):
    </p>

    <ol>
        <li>Create a <strong>Product</strong> in the Paddle Billing dashboard (for example, <em>Basic</em>).</li>
        <li>Under that product, create one or more <strong>Prices</strong>:
            <ul>
                <li>Monthly example: <code>price_basic_monthly</code> with a monthly billing interval.</li>
                <li>Yearly example: <code>price_basic_yearly</code> with a yearly billing interval.</li>
            </ul>
        </li>
        <li>Configure <strong>custom data</strong> for each price to control how it appears in the app:
            <ul>
                <li><code>features</code> &mdash; a comma-separated list of feature bullet points.</li>
                <li><code>is_featured</code> &mdash; <code>true</code> or <code>false</code> to highlight the plan.</li>
            </ul>
        </li>
        <li>Ensure Paddle sends <code>price.created</code> webhooks to your app (see
            <a href="{{ route('docs.show', 'paddle-webhooks') }}">Paddle Webhooks</a>).
        </li>
    </ol>

    <p>
        When the webhook arrives, the corresponding helper creates a <code>Plan</code> record and logs the event. Once
        the plan exists and has an <code>active</code> status, it will appear on the pricing page.
    </p>

    <h2>Updating or Archiving Plans</h2>
    <p>
        Any updates to a subscription plan in the Paddle dashboard will be automatically synced into your local
        database.
        You can also archive a plan in Paddle to hide it from the public pricing page.
    </p>

    <h2>Pricing Page (Monthly &amp; Yearly)</h2>
    <img src="{{ asset('images/docs/pricing-monthly-dark.webp') }}" alt="Pricing Page" class="hidden dark:block">
    <img src="{{ asset('images/docs/pricing-monthly-light.webp') }}" alt="Pricing Page" class="dark:hidden">
    <p>
        {{ config('app.name') }} has a pricing page that displays all active subscription plans. When you add a new plan
        in Paddle (Monthly or Yearly), it will be automatically synced into your local database and appear on the pricing page.
    </p>

    <h2>Subscription Checkout Flow</h2>
    <p>
        When a user selects a plan, <code>PlanController::show()</code> initiates a Paddle checkout:
    </p>

    <pre><code class="language-php">$checkout = $request-&gt;user()
    -&gt;checkout($priceId)
    -&gt;returnTo(route('subscription.pending'));</code></pre>

    <p>
        The corresponding Blade view receives the <code>$checkout</code> object and typically uses the
        <code>&lt;x-paddle-button /&gt;</code> component to render the Paddle checkout overlay.
    </p>

    <p>
        After payment, the user lands on the Subscription Pending page. Once webhooks confirm the subscription, the
        user becomes fully subscribed and can access subscriber-only areas of the app.
    </p>

    <h2>Managing an Active Subscription</h2>
    <p>
        {{ config('app.name') }} has a subscription management page that allows users to manage their subscription.
        You can cancel or update your subscription from the subscription management page.
    </p>
    <img src="{{ asset('images/docs/manage-subscription-dark.webp') }}" alt="Subscription Management Page" class="hidden dark:block">
    <img src="{{ asset('images/docs/manage-subscription-light.webp') }}" alt="Subscription Management Page" class="dark:hidden">

</x-layouts.docs>
