@push('head')
    <title>{{ __('Transactions') }} - {{ config('app.name') }}</title>
@endpush

<x-layouts.admin>
    <x-typography.admin-page-header :title="__('Transactions')" :description="__('View and manage transactions here.')" />

    <livewire:admin.transactions.transactions-table />
</x-layouts.admin>
