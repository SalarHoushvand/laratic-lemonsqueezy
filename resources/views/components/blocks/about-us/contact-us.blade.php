<div {{ $attributes }}>
    <x-typography.guest-page-header size="h2" class="mb-12" title="{{ __('Contact Us') }}"
        description="{{ __('We are here to help you. Fill out the form below to contact us.', ['app' => config('app.name')]) }}" />

    <!-- Contact Form -->
   <livewire:forms.contact />
</div>
