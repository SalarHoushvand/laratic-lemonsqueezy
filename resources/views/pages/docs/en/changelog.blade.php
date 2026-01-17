@push('head')
    <title>Changelog - {{ config('app.name') }}</title>
    <meta name="description" content="View the complete changelog and version history for {{ config('app.name') }}.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'Changelog', 'url' => '#']]">

    <h1>Changelog</h1>
    <p class="text-on-surface-muted dark:text-on-surface-dark-muted">
        Track all notable changes, improvements, and updates to {{ config('app.name') }}.
    </p>

    <div class="mt-6 space-y-12">
        {{-- Version 1.2.0 --}}
        <x-blocks.docs.changelog-section 
        title="January 10, 2026" version="1.2.0" github="#">
            <x-slot:new>
                <ul class="space-y-1.5 text-sm">
                    <li>Added AI translation functionality to blog posts and products</li>
                    <li>Can generate translations for blog posts and products with AI</li>
                </ul>
                <img src="{{ asset('images/ai-translation-dark.webp') }}" alt="Enhanced Admin Dashboard" class="w-full border-0!" />
                <div
                    class="p-3 bg-surface-container-low dark:bg-surface-container-low-dark text-sm text-on-surface-weak dark:text-on-surface-dark-weak">
                    New AI translation functionality for blog posts and products
                </div>
            </x-slot:new>
            <x-slot:changed>
                <ul class="space-y-1.5 text-sm">
                    <li>Resolved issue with AI translation not working</li>
                    <li>Fixed issue with AI translation not working</li>
                </ul>
            </x-slot:changed>
            <x-slot:fixed>
                <ul class="space-y-1.5 text-sm">
                    <li>Resolved issue with AI translation not working</li>
                    <li>Fixed issue with AI translation not working</li>
                </ul>
            </x-slot:fixed>
        </x-blocks.docs.changelog-section>

        {{-- Version 1.1.0 --}}
        <x-blocks.docs.changelog-section :title="now()->addDays(7)->format('F j, Y')" version="1.1.0" github="#">
            <x-slot:new>
                    <ul class="space-y-1.5 text-sm">
                        <li>Added subscription middleware to protect routes</li>
                        <li>Can protect routes with subscription middleware</li>
                        <li>Can protect routes with specific price IDs</li>
                    </ul>

                    <div class="mt-4">
                        <p class="text-sm mb-2">Example of middleware usage:</p>
                        <pre class="bg-surface-container-low dark:bg-surface-container-low-dark p-4 rounded-lg overflow-x-auto text-sm"><code class="language-php">// In your Livewire component
// Protect premium features with specific price IDs
Route::middleware(['auth', 'subscribed:pri_premium_monthly,pri_premium_yearly'])->group(function () {
    Route::get('/ai-chat', [AiController::class, 'index'])->name('ai.chat');
    Route::get('/advanced-analytics', [AnalyticsController::class, 'advanced']);
});

// Protect enterprise features
Route::get('/enterprise-dashboard', [EnterpriseController::class, 'dashboard'])
    ->middleware(['auth', 'subscribed:pri_enterprise_monthly']);

// Any subscription required
Route::middleware('subscribed')->group(function () {
    Route::livewire('/subscription', Manage::class)->name('subscription.manage');
});</code></pre>
                    </div>
            </x-slot:new>
            <x-slot:changed>
                    <ul class="space-y-1.5 text-sm">
                        <li>Refactored subscription middleware for better performance</li>
                        <li>Updated subscription middleware to handle multiple price IDs</li>
                    </ul>
            </x-slot:changed>
            <x-slot:fixed>
                    <ul class="space-y-1.5 text-sm">
                        <li>Fixed issue with subscription middleware not working</li>
                        <li>Fixed issue with subscription middleware not working</li>
                    </ul>
            </x-slot:fixed>
        </x-blocks.docs.changelog-section>

        {{-- Version 1.0.0 --}}
        <x-blocks.docs.changelog-section :title="now()->format('F j, Y')" version="1.0.0" github="#">
            <x-slot:new>
                    <ul class="space-y-1.5 text-sm">
                        <li>Initial release of {{ config('app.name') }}</li>
                        <li>Complete user authentication and authorization system with role-based access control</li>
                        <li>Blog management platform with AI-powered content generation capabilities</li>
                        <li>Comprehensive admin dashboard with real-time analytics and reporting</li>
                        <li>Cookie consent banner with integrated Google Analytics support</li>
                        <li>Newsletter subscription and management system</li>
                        <li>Social authentication via Google and GitHub providers</li>
                        <li>Multi-language support with seamless translation system</li>
                        <li>Full-featured product catalog and order management</li>
                        <li>Interactive AI chat with streaming response capabilities</li>
                    </ul>
            </x-slot:new>
            <x-slot:changed>
                    <ul class="space-y-1.5 text-sm">
                        <li>First stable release - no previous versions</li>
                    </ul>
            </x-slot:changed>
            <x-slot:fixed>
                    <ul class="space-y-1.5 text-sm">
                        <li>Initial release - no bug fixes yet</li>
                    </ul>
            </x-slot:fixed>
        </x-blocks.docs.changelog-section>
    </div>

</x-layouts.docs>
