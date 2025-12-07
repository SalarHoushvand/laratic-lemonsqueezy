<x-layouts.guest>
    @push('head')
        <title>{{ config('app.name', 'Laravel') }} - {{ __('Pricing') }}</title>
        <meta name="description"
            content="{{ __('Choose the plan that best suits your needs. We offer a range of plans to suit different businesses and budgets.') }}">
    @endpush
    <div class="px-6 max-w-6xl 2xl:max-w-6xl mx-auto">
        <!-- Polka dot background -->
        <div class="hidden dark:block absolute inset-0 -z-10 bg-pattern pointer-events-none" aria-hidden="true"></div>
        <!-- Background Blur Effect -->
        <div class="absolute -z-10 -top-20 left-1/2 h-40 w-80 -translate-x-1/2 rounded-full bg-primary opacity-30 blur-[60px] dark:bg-primary-dark"
            aria-hidden="true"></div>

        <x-blocks.pricing.hero class="my-6 md:my-12" />

        <x-blocks.pricing.plans class="my-6 md:my-12" :plans="$plans" />

        <x-blocks.pricing.faq class="my-12 md:my-24 max-w-3xl mx-auto" />

        <x-blocks.pricing.request-demo class="my-12 md:my-24" />
    </div>
</x-layouts.guest>
