<x-layouts.app :sidebar="true">
    @push('head')
        <title>{{ __('A Page to Demonstrate AI Integration') }} - {{ config('app.name') }}</title>
    @endpush

    <div class="max-w-3xl mx-auto p-8">
        <livewire:ai-simple />
    </div>
</x-layouts.app>
