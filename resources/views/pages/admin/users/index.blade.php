@push('head')
    <title>{{ __('Admin Users') }}</title>
@endpush

<x-layouts.admin>
    <x-typography.admin-page-header :title="__('Users')" :description="__('View and manage users here.')" />

    <livewire:admin.users.users-table :searchable="true" />
</x-layouts.admin>
