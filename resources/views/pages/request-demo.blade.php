<x-layouts.guest>
    @push('head')
        <title>{{ config('app.name', 'Laravel') }} - {{ __('Request a Demo') }}</title>
        <meta name="description"
            content="{{ __('Experience firsthand how :app can transform your business operations. Fill out the form below to schedule a personalized demo with our team.', ['app' => config('app.name')]) }}">
    @endpush
    <div class="p-12">
        <!-- Polka dot background -->
        <div class="hidden dark:block absolute inset-0 -z-10 bg-pattern pointer-events-none" aria-hidden="true"></div>
        <!-- Background Blur Effect -->
        <div class="absolute -z-10 -top-20 left-1/2 h-40 w-80 -translate-x-1/2 rounded-full bg-primary opacity-30 blur-[60px] dark:bg-primary-dark"
            aria-hidden="true"></div>
        <div class="px-6 max-w-6xl 2xl:max-w-6xl mx-auto py-12">
            <!-- Header Section -->
            <x-typography.guest-page-header size="h1" class="mb-12" title="{{ __('Request a Demo') }}"
                description="{{ __('Experience firsthand how :app can transform your business operations. Fill out the form below to schedule a personalized demo with our team.', ['app' => config('app.name')]) }}" />

            <!-- Form Section -->
            <livewire:forms.request-demo />
        </div>
</x-layouts.guest>
