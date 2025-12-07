@push('head')
    <title>{{ __('Manage your blog posts') }} - {{ config('app.name') }}</title>
@endpush

<x-layouts.admin>
    <x-typography.admin-page-header :title="__('Posts')" :description="__('Manage your blog posts here.')" />
    <livewire:admin.posts.posts-table />
</x-layouts.admin>
