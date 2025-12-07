<x-layouts.app :sidebar="true">
    @push('head')
        <title>{{ __('AI Chat') }} - {{ config('app.name') }}</title>
    @endpush
    <livewire:ai-chat />
</x-layouts.app>
