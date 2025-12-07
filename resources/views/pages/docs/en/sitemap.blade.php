@push('head')
    <title>Sitemap Generation - {{ config('app.name') }}</title>
    <meta name="description"
        content="Learn how to generate and customize sitemaps for {{ config('app.name') }}. Our sitemap generation system automatically discovers public routes and makes it easy to optimize your site for search engines.">
@endpush


<x-layouts.docs :breadcrumbs="[['label' => 'SEO & Marketing', 'url' => '#'], ['label' => 'Sitemap Generation', 'url' => '#']]">

    <h1>Sitemap Generation</h1>
    <p>{{ config('app.name') }} includes a powerful sitemap generation system that automatically discovers all public routes and creates an optimized XML sitemap for search engines using the <a href="https://github.com/spatie/laravel-sitemap" target="_blank" rel="noopener">Spatie Sitemap</a> package. The sitemap is intelligently filtered to exclude authentication routes, admin areas, and other private pages while including all public content, documentation, and blog posts.</p>

    <h2>Generating the Sitemap</h2>
    <p>The sitemap is generated using a simple Artisan command. This command can be run manually or scheduled to run automatically to keep your sitemap up to date with the latest content:</p>
    <pre><code>php artisan sitemap:generate</code></pre>

    <p>After running this command, your sitemap will be saved to <code>public/sitemap.xml</code> and will be accessible at <code>yoursite.com/sitemap.xml</code>.</p>

    <h2>What's Included</h2>
    <p>The sitemap automatically includes:</p>
    <ul>
        <li><strong>Public Static Routes</strong> - All publicly accessible pages like home, features, pricing, contact, etc.</li>
        <li><strong>Documentation Pages</strong> - All documentation files are automatically discovered and included</li>
        <li><strong>Blog Posts</strong> - Active blog posts with their last modification dates</li>
        <li><strong>Priority Optimization</strong> - Each URL is assigned an appropriate priority value based on its importance</li>
    </ul>

    <h2>What's Excluded</h2>
    <p>The sitemap intelligently excludes routes that should not be indexed by search engines:</p>
    <ul>
        <li>Authentication routes (login, register, password reset)</li>
        <li>Admin routes and authenticated-only areas</li>
        <li>API endpoints</li>
        <li>Internal routes (debugbar, webhooks, etc.)</li>
        <li>Livewire component routes</li>
        <li>Routes requiring authentication middleware</li>
    </ul>


    <h2>Customizing Priority Values</h2>
    <p>Each URL in the sitemap is assigned a priority value between 0.0 and 1.0. You can customize these values by editing the priority map in <code>app/Console/Commands/GenerateSitemap.php</code>:</p>
    <pre><code>// Define priority mapping for specific routes
$priorityMap = [
    'home' => 1.0,        // Highest priority
    'pricing' => 0.9,     // Very high priority
    'features' => 0.8,    // High priority
    'blog' => 0.8,        // High priority
    'careers' => 0.7,     // Medium-high priority
    'about-us' => 0.7,    // Medium-high priority
    'contact' => 0.7,     // Medium-high priority
    'waitlist' => 0.6,    // Medium priority
    'terms' => 0.5,       // Lower priority
    'privacy' => 0.5,     // Lower priority
];</code></pre>

    <h2>Adding Custom Routes</h2>
    <p>If you need to manually add specific routes to your sitemap, you can modify the <code>addPublicRoutes()</code> method in the <code>GenerateSitemap</code> command:</p>
    <pre><code>// Add a custom route
$sitemap->add(
    Url::create(route('your.custom.route'))
        ->setPriority(0.8)
        ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
);</code></pre>

    <h2>Excluding Specific Routes</h2>
    <p>To exclude additional routes from the sitemap, add them to the <code>shouldSkipRoute()</code> method in <code>app/Console/Commands/GenerateSitemap.php</code>:</p>
    <pre><code>// Skip your custom routes
if ($name === 'your.route.name') {
    return true;
}

// Or skip by URI pattern
if (str_starts_with($uri, 'internal/')) {
    return true;
}</code></pre>


    <h2>Troubleshooting</h2>
    <p>If you encounter issues with sitemap generation:</p>
    <ul>
        <li>Ensure the <code>public</code> directory is writable</li>
        <li>Check that all routes are properly named in your route files</li>
        <li>Verify that the Spatie Sitemap package is installed (<code>composer require spatie/laravel-sitemap</code>)</li>
        <li>Clear your route cache with <code>php artisan route:clear</code></li>
    </ul>

</x-layouts.docs>

