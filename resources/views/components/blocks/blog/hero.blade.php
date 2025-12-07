<!-- Hero Section -->
<div {{ $attributes }}>
    <!-- Main Content Container -->
    <div class="flex min-h-[30svh] items-center gap-6 py-6 mx-auto">
        <!-- Background Blur Effect -->
        <div class="absolute -z-10 -top-20 left-1/2 h-40 w-80 -translate-x-1/2 rounded-full bg-primary opacity-30 blur-[60px] dark:bg-primary-dark"
            aria-hidden="true"></div>
        <x-typography.guest-page-header class="mx-auto" title="{{ __(config('app.name')) . ' ' . __('Blog') }}"
            description="{{ __('Stories of an imaginary traveling developer') }}" />
    </div>
</div>
