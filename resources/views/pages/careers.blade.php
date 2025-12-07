<x-layouts.guest>
    @push('head')
        <title>{{ config('app.name', 'Laravel') }} - {{ __('Careers') }}</title>
        <meta name="description" content="{{ __('Join our team and help us build the future of cloud management.') }}">
    @endpush
    <div class="px-6 max-w-6xl 2xl:max-w-6xl mx-auto py-12">

        <!-- Polka dot background -->
        <div class="hidden dark:block absolute inset-0 -z-10 bg-pattern pointer-events-none" aria-hidden="true"></div>

        <x-typography.guest-page-header size="h1" class="mb-12" title="{{ __('Careers') }}"
            description="{{ __('Join our team and help us build the future of cloud management.') }}" />


        <x-blocks.careers.listings class="mb-24" />

    </div>

</x-layouts.guest>
