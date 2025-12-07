<x-modal name="cancel-plan" :maxWidth="'lg'">
    <x-slot name="header">
        <p class="text-sm text-on-surface-strong dark:text-on-surface-dark-strong font-bold">{{ __('Are you sure you want to cancel?') }}</p>
    </x-slot>
    <div>

        <div class="space-y-2 p-4">
            <p class="text-sm text-on-surface dark:text-on-surface-dark">
                {{ __("You're about to cancel your :app subscription.", ['app' => config('app.name')]) }}
            </p>
            <p class="text-sm text-on-surface dark:text-on-surface-dark">
                {{ __('By canceling, you will lose access to all premium features at the end of your billing period.') }}
            </p>
            <p class="text-sm text-on-surface dark:text-on-surface-dark">
                {{ __('Are you sure you want to proceed with the cancellation?') }}
            </p>
        </div>

        <div
            class="mt-4 flex flex-col-reverse gap-2 border-t border-outline bg-surface-alt/60 p-4 dark:border-outline-dark dark:bg-surface-dark/20 sm:flex-row sm:items-center sm:justify-end">
            <x-button variant="ghost" type="button" x-on:click="modalIsOpen = false" class="w-full md:w-fit">
                {{ __('Keep Subscription') }}
            </x-button>

            <x-button variant="danger" wire:click="cancelPlan" class="w-full md:w-fit">
                <x-icons.spinner class="size-4 animate-spin fill-on-primary dark:fill-on-primary-dark" wire:loading
                    wire:target="cancelPlan" />
                {{ __('Cancel Subscription') }}
            </x-button>
        </div>

    </div>
</x-modal>

<x-modal-trigger target="cancel-plan">
    <div {{ $attributes }}>
        {{ $slot }}
    </div>
</x-modal-trigger>
