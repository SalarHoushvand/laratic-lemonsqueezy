@push('head')
    <title>{{ __('Your subscription invoices') }}</title>
    <meta name="description" content="{{ __('View all your subscription invoices here.') }}">
@endpush

<x-layouts.app>
    <div class="p-8">
        <x-typography.admin-page-header :title="__('Subscription Invoices')" :description="__('View all your subscription invoices.')" />

        <livewire:subscription-invoices.subscription-invoices-table />    
    </div>
</x-layouts.app>

