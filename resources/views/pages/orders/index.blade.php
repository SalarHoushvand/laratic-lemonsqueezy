@push('head')
    <title>{{ __('Your orders') }}</title>
    <meta name="description" content="{{ __('View all your orders here.') }}">
@endpush

<x-layouts.app>
    <div class="p-8">
        <x-typography.admin-page-header :title="__('Orders')" :description="__('View all your orders.')" />

        <livewire:orders.orders-table />    
    </div>
</x-layouts.app>
