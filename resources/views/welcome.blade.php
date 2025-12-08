<x-layouts.guest>
    @push('head')
        <title>{{ config('app.name', 'Laravel') }} - {{ __('Your all in one saas solution') }}</title>
        <meta name="description"
            content="{{ __(':app is your all in one saas solution. We provide a range of services to help you grow your business.', ['app' => config('app.name')]) }}">
    @endpush
    <div class="px-8 max-w-7xl 2xl:max-w-7xl mx-auto">
        <!-- Polka dot background -->
        <div class="hidden dark:block absolute inset-0 -z-10 bg-pattern pointer-events-none" aria-hidden="true"></div>
    
        <x-blocks.welcome.hero />

        <x-blocks.welcome.featured-logos class="mt-6" />

        <x-blocks.welcome.large-banner />
       
        <x-blocks.welcome.features class="mt-24 max-w-6xl mx-auto scroll-mt-24" id="features" />

        <x-blocks.welcome.statistics class="mt-24" />

        <x-blocks.welcome.integrations class="mt-24" />

        <x-blocks.welcome.themes class="mt-24" />
        
        <x-blocks.welcome.testimonials class="mt-24" />

        <x-blocks.welcome.pricing class="mt-24" />

        <x-blocks.welcome.all-features class="mt-24" />

        <x-blocks.welcome.faq class="mt-32 max-w-3xl mx-auto mb-24" />

        <x-blocks.blog.newsletter id="newsletter-signup" class="my-12" />

    </div>
</x-layouts.guest>
