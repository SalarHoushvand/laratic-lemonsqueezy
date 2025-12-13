<div class="flex flex-col items-center justify-center gap-8 py-8 md:py-24">
    <!-- Background Blur Effect -->
    <div class="absolute -z-10 -top-20 left-1/2 h-40 w-80 -translate-x-1/2 rounded-full bg-primary opacity-30 blur-[60px] dark:bg-primary-dark"
        aria-hidden="true"></div>
    
    <x-typography.guest-page-header size="h1" class="mb-12" title="{{ __('About') }} {{ config('app.name') }}"
        description="{{ __(
            'At :app, we are helping developers launch their SaaS applications faster by eliminating weeks of boilerplate work.',
        ['app' => config('app.name')]
    ) }}" />
</div>
