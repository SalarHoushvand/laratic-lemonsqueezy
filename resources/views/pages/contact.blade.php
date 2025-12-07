<x-layouts.guest>
    @push('head')
        <title>{{ config('app.name') }} - {{ __('Contact') }}</title>
        <meta content="{{ __('Contact us for more information or to get started.') }}" name="description">
    @endpush

    <div class="px-6 max-w-6xl 2xl:max-w-6xl mx-auto py-12">
        <!-- Polka dot background -->
        <div aria-hidden="true" class="absolute -z-10 bg-pattern dark:block hidden inset-0 pointer-events-none"></div>

        <!-- Main Content Container -->
        <div class="flex gap-6 items-center min-h-svh mx-auto py-6">
            <!-- Left Column: Content -->
            <div class="flex flex-col gap-6 items-center mx-auto w-full">
                <!-- Background Blur Effect -->
                <div aria-hidden="true"
                    class="absolute -top-20 -z-10 bg-primary blur-[60px] dark:bg-primary-dark h-40 left-1/2 opacity-30 rounded-full -translate-x-1/2 w-80">
                </div>

                <x-typography.guest-page-header size="h1" title="{{ __('Get in Touch with Us') }}"
                    description="{{ __('Whether you have questions, need support, or want to learn more about :app, we are here to help. Fill out the form and a member of our team will be in touch shortly.', ['app' => config('app.name')]) }}" />

                <!-- Form Section -->
                <livewire:forms.contact />

            </div>
        </div>
    </div>
</x-layouts.guest>
