<div {{ $attributes }}>
    <!-- Header Section -->
    <div
        class="flex flex-col gap-8 items-center text-center justify-between p-8">
        <x-typography.guest-page-header
            title="{{ __('Subscribe to our newsletter') }}"
            description="{{ __('Get the latest news and updates from :app in your inbox.', ['app' => config('app.name')]) }}"
            size="h2"
            :divider-dots="true" />
        <livewire:forms.newsletter />
    </div>
</div>
