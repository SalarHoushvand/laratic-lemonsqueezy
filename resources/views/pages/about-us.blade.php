<x-layouts.guest>
    @push('head')
        <title>{{ config('app.name', 'Laravel') }} - {{ __('Features') }}</title>
        <meta name="description"
            content="{{ __(':app is your all in one saas solution. We provide a range of services to help you grow your business.', ['app' => config('app.name')]) }}">
    @endpush
    <div class="px-6">
        <!-- Polka dot background -->
        <div class="hidden dark:block absolute inset-0 -z-10 bg-pattern pointer-events-none" aria-hidden="true"></div>

        <x-blocks.about-us.hero />

        <x-blocks.about-us.our-story class="mb-28" />

        <x-blocks.about-us.statistics class="my-20" />

        <x-blocks.about-us.our-team class="my-20" />

        <x-blocks.about-us.contact-us class="my-24 scroll-mt-24" />

    </div>
</x-layouts.guest>
