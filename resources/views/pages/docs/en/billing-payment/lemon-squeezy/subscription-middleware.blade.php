@push('head')
    <title>Subscription Middleware - {{ config('app.name') }}</title>
    <meta name="description"
        content="Learn how to use the subscription middleware to protect routes and require specific subscription plans in {{ config('app.name') }}.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'Billing & Payments', 'url' => '#'], ['label' => 'Lemon Squeezy', 'url' => '#'], ['label' => 'Subscription Middleware', 'url' => '#']]">

    <h1>Subscription Middleware</h1>
    <p class="text-on-surface-muted dark:text-on-surface-dark-muted">
        The <code>subscribed</code> middleware allows you to protect routes and require users to have an active subscription, optionally to specific plan variants.
    </p>

    <h2>Require Any Subscription</h2>
    <p>
        To require any active subscription for a route or group of routes:
    </p>

    <pre><code class="language-php">// Single route
Route::get('/premium-feature', [FeatureController::class, 'index'])
    ->middleware(['auth', 'subscribed']);

// Route group
Route::middleware(['auth', 'subscribed'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/reports', [ReportController::class, 'index']);
});</code></pre>

    <h2>Require Specific Plan Variants</h2>
    <p>
        To require users to be subscribed to one or more specific plan variants, pass variant IDs as middleware parameters:
    </p>

    <pre><code class="language-php">// Require subscription to a specific variant
Route::get('/enterprise-feature', [EnterpriseController::class, 'index'])
    ->middleware(['auth', 'subscribed:1135284']);

// Require subscription to any of multiple variants
Route::get('/premium-feature', [PremiumController::class, 'index'])
    ->middleware(['auth', 'subscribed:1135284,1135285']);

// Route group with specific variant requirement
Route::middleware(['auth', 'subscribed:1135284'])->group(function () {
    Route::get('/enterprise/dashboard', [EnterpriseDashboardController::class, 'index']);
    Route::get('/enterprise/reports', [EnterpriseReportController::class, 'index']);
});</code></pre>

    <p>
        When variant IDs are provided, the middleware checks if the user is subscribed to <strong>any</strong> of the specified variants. If not, they will be redirected to the plans page.
    </p>

    <h2>Finding Variant IDs</h2>
    <p>
        You can find variant IDs in your database by checking the <code>plans</code> table's <code>lemon_squeezy_variant_id</code> column, or in your Lemon Squeezy dashboard under Products > Variants.
    </p>

</x-layouts.docs>
