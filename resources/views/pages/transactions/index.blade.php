@push('head')
    <title>{{ __('Transactions') }}</title>
    <meta name="description" content="{{ __('View all your transactions here.') }}">
@endpush

<x-layouts.app>
    <div class="p-8">
        <x-typography.admin-page-header :title="__('Transactions')" :description="__('View all your transactions here.')" />

        <livewire:transactions.transactions-table />
    </div>
</x-layouts.app>
