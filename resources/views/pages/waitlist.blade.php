<x-layouts.minimal>
    @push('head')
        <title>{{ config('app.name') }} - {{ __('Coming Soon') }}</title>
        <meta
            content="{{ __(':app is designed to make cloud management simpler, faster, and more efficient.', ['app' => config('app.name')]) }}"
            name="description">
    @endpush

    <div class="px-6">
        <!-- Polka dot background -->
        <div aria-hidden="true" class="absolute -z-10 inset-0 bg-pattern dark:block hidden pointer-events-none"></div>

        <!-- Background Blur Effect -->
        <div aria-hidden="true"
            class="absolute -top-20 -z-10 left-1/2 h-40 opacity-30 rounded-full -translate-x-1/2 w-80 bg-primary blur-[60px] dark:bg-primary-dark">
        </div>

        <div class="container flex flex-col items-center justify-center min-h-[80vh] mx-auto text-center">
            <div class="mb-8">
                <x-typography.guest-page-header size="h1" title="{{ __('Coming Soon') }}"
                    description="{{ __(':app is designed to save you months of development time.', ['app' => config('app.name')]) }}" />
            </div>

            <livewire:forms.waitlist class="mb-8" />

            <p class="text-sm text-on-surface-muted dark:text-on-surface-dark-muted mb-12 mt-4">
                {{ __("You'll be notified when :app is launched", ['app' => config('app.name')]) }}
            </p>

            <!-- Social Links -->
            <div class="flex gap-6 items-center">
                <a class="text-on-surface hover:text-primary dark:text-on-surface-dark dark:hover:text-primary-dark"
                    href="#">
                    <span class="sr-only">{{ __('Facebook') }}</span>
                    <x-icons.facebook class="size-5" />
                </a>
                <a class="text-on-surface hover:text-primary dark:text-on-surface-dark dark:hover:text-primary-dark"
                    href="#">
                    <span class="sr-only">{{ __('Instagram') }}</span>
                    <x-icons.instagram class="size-5" />
                </a>
                <a class="text-on-surface hover:text-primary dark:text-on-surface-dark dark:hover:text-primary-dark"
                    href="#">
                    <span class="sr-only">{{ __('Twitter') }}</span>
                    <x-icons.twitter class="size-5" />
                </a>
            </div>
        </div>
        
         <!-- Background Blur Effect -->
         <div aria-hidden="true"
         class="absolute -bottom-10 -z-10 left-1/2 h-25 opacity-20 rounded-full -translate-x-1/2 w-full bg-primary blur-[60px] dark:bg-primary-dark">
     </div>
    </div>

</x-layouts.minimal>
