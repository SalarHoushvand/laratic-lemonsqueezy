@push('head')
    <title>Introduction - {{ config('app.name') }}</title>
    <meta name="description"
        content="Learn about {{ config('app.name') }}, a comprehensive Laravel SaaS starter kit built with Laravel 12 and Livewire 3.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'Basics', 'url' => '#'], ['label' => 'Introduction', 'url' => '#']]">
    <h2>What is {{ config('app.name') }}?</h2>
    <p>
        {{ config('app.name') }} is a comprehensive Laravel SaaS starter kit that provides everything you need to launch
        your SaaS application quickly. Built with modern technologies and best practices, it gives you a solid foundation
        to build upon without spending weeks on boilerplate code.
    </p>
    <p>
        Whether you're an indie hacker, part of a small team, or an agency, {{ config('app.name') }} helps you ship a
        polished SaaS quickly without rebuilding the same foundation every time. If you're comfortable with Laravel and
        want to skip weeks of setup work, {{ config('app.name') }} is for you.
    </p>

    <h2>Key Features</h2>
    <p>{{ config('app.name') }} includes a comprehensive set of features to get your SaaS up and running:</p>
    <ul class="space-y-2">
        <li><strong>Authentication System</strong> - Complete user authentication with email/password, two-factor verification, and social login (Google, GitHub)</li>
        <li><strong>Two-Factor Authentication</strong> - Enhanced security with 2FA support via email</li>
        <li><strong>Subscription Management</strong> - Full subscription and one-time payment management with LemonSqueezy integration</li>
        <li><strong>Admin Dashboard</strong> - Comprehensive admin dashboard with analytics, user management, and more</li>
        <li><strong>AI-Powered Features</strong> - Interactive AI chat with streaming responses and AI-powered blog content generation</li>
        <li><strong>Blog & Post System</strong> - Complete blog management platform with markdown support, tags, and categories and AI-powered blog content generation and translation</li>
        <li><strong>Multi-Language Support</strong> - Seamless translation system with support for multiple languages</li>
        <li><strong>Email Notifications</strong> - Email verification, password reset, and custom notification system</li>
        <li><strong>Marketing Features</strong> - Homepage, pricing page, about us page, blog listing and posts, all pages SEO optimized, newsletter integration, XML sitemap generator</li>
        <li><strong>Role-Based Access Control</strong> - User roles and permissions powered by Spatie Laravel Permission</li>
        <li><strong>Modern UI Components</strong> - Beautiful, responsive UI built with Tailwind CSS 4 and Penguin UI</li>
        <li><strong>Product Catalog</strong> - Full-featured product catalog and one-time payment orders with Lemonsqueezy integration</li>
        <li><strong>Newsletter Integration</strong> - Newsletter subscription and management with Mailchimp integration</li>
    </ul>

    <h2>What You Get</h2>
    <p>{{ config('app.name') }} is free and open source under the MIT license. Clone the repository from GitHub to get the full codebase. Similar to Laravel's official starter kits, you can modify, extend, and customize everything to fit your specific needs. You're free to add, remove, or update dependencies as your project evolves.</p>


    <h2>Tech Stack</h2>
    <p>{{ config('app.name') }} is built with modern, industry-standard technologies:</p>

    <h3>Backend</h3>
    <ul class="space-y-2">
        <li><strong>PHP</strong> - ^8.4</li>
        <li><strong>Laravel Framework</strong> - ^12.0</li>
        <li><strong>Livewire</strong> - ^3.6.1</li>
    </ul>

    <h3>Frontend</h3>
    <ul class="space-y-2">
        <li><strong>Tailwind CSS</strong> - ^4.0.7</li>
        <li><strong>Alpine.js</strong> - Included with Livewire 3</li>
        <li><strong>ApexCharts</strong> - 5.3.5 (for analytics and charts)</li>
        <li><strong>Marked</strong> - 16.4.1 (for markdown parsing)</li>
        <li><strong>EasyMDE</strong> - 2.20.0 (markdown editor)</li>
        <li><strong>Highlight.js</strong> - 11.11.1 (syntax highlighting)</li>
    </ul>

    <h3>Key Packages & Integrations</h3>
    <ul class="space-y-2">
        <li><strong>Laravel Socialite</strong> - ^5.23 (social authentication)</li>
        <li><strong>Spatie Laravel Permission</strong> - ^6.17 (role and permission management)</li>
        <li><strong>Spatie Laravel Tags</strong> - ^4.10 (tagging system)</li>
        <li><strong>Spatie Laravel Newsletter</strong> - ^5.3 (newsletter management)</li>
        <li><strong>Spatie Laravel Sitemap</strong> - ^7.3 (sitemap generation)</li>
        <li><strong>Cloudinary Laravel</strong> - ^3.0 (image and media management)</li>
        <li><strong>Laravel AI SDK</strong> - ^0.8 (AI integration)</li>
        <li><strong>Symfony Mailgun Mailer</strong> - ^7.3 (email delivery)</li>
    </ul>

    <h3>Development Tools</h3>
    <ul class="space-y-2">
        <li><strong>Pest PHP</strong> - ^3.8 (testing framework)</li>
        <li><strong>Laravel Pint</strong> - ^1.18 (code formatting)</li>
        <li><strong>Laravel Boost</strong> - ^1.1 (development tools)</li>
    </ul>

    <h2>Next Steps</h2>
    <p>Now that you're familiar with {{ config('app.name') }}, you can:</p>
    <ul>
        <li>Follow the <a href="{{ route('docs.show', ['topic' => 'installation']) }}">Installation</a> guide to get started</li>
        <li>Explore the <a href="{{ route('docs.show', ['topic' => 'ui-components/button']) }}">UI Components</a> documentation</li>
        <li>Learn about <a href="{{ route('docs.show', ['topic' => 'auth/social-login/index']) }}">Authentication</a> configuration</li>
        <li>Check out the <a href="{{ route('docs.show', ['topic' => 'changelog']) }}">Changelog</a> to see what's new</li>
    </ul>

</x-layouts.docs>
