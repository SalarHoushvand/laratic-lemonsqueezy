@push('head')
    <title>{{ __('Admin') }}</title>
@endpush

<x-layouts.admin>
    <x-typography.admin-page-header :title="__('Orders')" :description="__('View and manage orders here.')" />

    <livewire:admin.orders.orders-table />
</x-layouts.admin>
