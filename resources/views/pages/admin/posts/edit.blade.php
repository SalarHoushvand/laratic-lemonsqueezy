@push('head')
    <title>{{ __('Edit Post') }}</title>
@endpush

<x-layouts.admin>
    <x-typography.admin-page-header :title="__('Edit Post')" :description="__('Edit your blog post here.')" />

    <livewire:forms.admin.edit-post :post="$post" />
    
    <x-modal name="manage-categories" maxWidth="lg" backdropBlur="none" backdropOpacity="md" title="{{ __('Manage Categories') }}">
        <x-slot:header>
            <h3 class="heading-6 text-on-surface dark:text-on-surface-dark">{{ __('Manage Categories') }}</h3>
        </x-slot:header>
        <div class="space-y-4">
            <livewire:admin.posts.manage-categories :postLanguage="$post->language" />
        </div>
    </x-modal>
 
    @push('scripts')
        @vite(['resources/js/markdownEditor.js'])
    @endpush
</x-layouts.admin>
