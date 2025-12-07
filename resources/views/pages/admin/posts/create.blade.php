@push('head')
    <title>{{ __('New Post') }}</title>
@endpush

<x-layouts.admin>
    <x-typography.admin-page-header :title="__('New Post')" :description="__('Create a new blog post here.')" />
    
    <livewire:forms.admin.create-post />

    @push('scripts')
        @vite(['resources/js/markdownEditor.js'])
    @endpush
</x-layouts.admin>
