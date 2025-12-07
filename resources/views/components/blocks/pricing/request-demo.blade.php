<div {{ $attributes }}>
    <!-- Header Section -->
    <x-typography.guest-page-header size="h2" class="mb-12" title="{{ __('Request a Demo') }}"
        description="{{ __('Experience firsthand how :app can transform your business operations. Fill out the form below to schedule a personalized demo with our team.', ['app' => config('app.name')]) }}" />

    <!-- Form Section -->
    <livewire:forms.request-demo />
</div>
