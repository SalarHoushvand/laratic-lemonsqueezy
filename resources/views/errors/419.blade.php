<x-layouts.guest>
    @push('head')
        <title>419 - {{ __('Page Expired') }} | {{ config('app.name', 'Laravel') }}</title>
        <meta name="description" content="{{ __('Your session has expired. Please refresh the page and try again.') }}">
    @endpush
    <!-- Background Blur Effect -->
    <div class="absolute -z-10 -top-20 left-1/2 h-40 w-80 -translate-x-1/2 rounded-full bg-primary opacity-30 blur-[60px] dark:bg-primary-dark"
        aria-hidden="true"></div>
    <div class="hidden dark:block absolute inset-0 -z-10 bg-pattern pointer-events-none" aria-hidden="true"></div>

    <div class="flex min-h-[calc(100vh-200px)] items-center justify-center px-6 py-20">
        <div class="mx-auto max-w-2xl text-center">
            <!-- 419 Number -->
            <div class="mb-8">
                <h1 class="text-6xl font-bold text-primary dark:text-primary-dark font-title">
                    419
                </h1>
            </div>

            <!-- Error Message -->
            <div class="mb-8 space-y-4">
                <h2 class="text-3xl font-semibold text-on-surface-strong dark:text-on-surface-dark-strong font-title">
                    {{ __('Page Expired') }}
                </h2>
                <p class=" text-on-surface-muted dark:text-on-surface-dark-muted">
                    {{ __('Your session has expired due to inactivity. Please refresh the page and try again.') }}
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col items-center justify-center gap-4 sm:flex-row">
                <x-button href="javascript:location.reload()" variant="primary">
                    {{ __('Refresh Page') }}
                </x-button>
                <x-button href="{{ route('home') }}" variant="outline">
                    {{ __('Go Home') }}
                </x-button>
            </div>

            <!-- Helpful Links -->
            <div class="mt-12 pt-8 border-t border-outline dark:border-outline-dark">
                <p class="mb-4 text-sm text-on-surface-muted dark:text-on-surface-dark-muted">
                    {{ __('You might want to check out:') }}
                </p>
                <div class="flex flex-wrap items-center justify-center gap-4">
                    <a href="{{ route('blog') }}"
                        class="text-sm font-medium text-primary hover:opacity-75 dark:text-primary-dark">
                        {{ __('Blog') }}
                    </a>
                    <span class="text-on-surface-muted dark:text-on-surface-dark-muted">•</span>
                    <a href="{{ route('pricing') }}"
                        class="text-sm font-medium text-primary hover:opacity-75 dark:text-primary-dark">
                        {{ __('Pricing') }}
                    </a>
                    <span class="text-on-surface-muted dark:text-on-surface-dark-muted">•</span>
                    <a href="{{ route('contact') }}"
                        class="text-sm font-medium text-primary hover:opacity-75 dark:text-primary-dark">
                        {{ __('Contact') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.guest>

