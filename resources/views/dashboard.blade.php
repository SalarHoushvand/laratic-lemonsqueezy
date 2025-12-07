@push('head')
    <title>{{ __('Dashboard') }}</title>
@endpush

<x-layouts.app>
    <!-- Main Container -->
    <div class="flex min-h-screen w-full flex-col gap-8 rounded-radius p-8">
        <!-- Grid Section -->
        <div class="grid auto-rows-min gap-8 md:grid-cols-3">
            <!-- Placeholder Card 1 -->
            <div class="relative aspect-video overflow-hidden rounded-radius border border-outline dark:border-outline-dark">
                <x-placeholder-pattern
                    class="absolute inset-0 size-full stroke-on-surface/40 dark:stroke-on-surface-dark/30" />
            </div>

            <!-- Placeholder Card 2 -->
            <div class="relative aspect-video overflow-hidden rounded-radius border border-outline dark:border-outline-dark">
                <x-placeholder-pattern
                    class="absolute inset-0 size-full stroke-on-surface/40 dark:stroke-on-surface-dark/30" />
            </div>

            <!-- Placeholder Card 3 -->
            <div class="relative aspect-video overflow-hidden rounded-radius border border-outline dark:border-outline-dark">
                <x-placeholder-pattern
                    class="absolute inset-0 size-full stroke-on-surface/40 dark:stroke-on-surface-dark/30" />
            </div>
        </div>

        <!-- Full Width Placeholder -->
        <div class="relative flex-1 overflow-hidden rounded-radius border border-outline dark:border-outline-dark">
            <x-placeholder-pattern
                class="absolute inset-0 size-full stroke-on-surface/40 dark:stroke-on-surface-dark/30" />
        </div>
    </div>
    <x-notification />
</x-layouts.app>
