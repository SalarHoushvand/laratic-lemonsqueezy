@push('head')
    <title>{{ __('Admin') }}</title>
@endpush

<x-layouts.admin>
    <x-typography.admin-page-header :title="__('Subscription Invoices')" :description="__('View and manage subscription invoices here.')" />

    <livewire:admin.subscription-invoices.subscription-invoices-table />
</x-layouts.admin>

