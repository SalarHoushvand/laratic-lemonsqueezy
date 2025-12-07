<div {{ $attributes }}>
    <!-- Header Section -->
    <div
        class="flex flex-col gap-8 items-center text-center justify-between p-8">
        <div class="flex flex-col gap-4">
            <h2 class="heading-3 text-pretty" id="newsletter-signup-title">
                {{ __('Subscribe to our newsletter') }}
            </h2>
            <p class="text-sm text-on-surface-muted dark:text-on-surface-dark-muted w-full">
                {{ __('Get the latest news and updates from :app in your inbox.', ['app' => config('app.name')]) }}
            </p>
        </div>
        <livewire:forms.newsletter />
    </div>

    <!-- Form Section -->

</div>
