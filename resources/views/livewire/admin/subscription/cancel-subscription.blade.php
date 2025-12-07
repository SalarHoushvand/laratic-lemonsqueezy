<div>
    <x-modal name="cancel-subscription">
        <x-slot name="header">
            <p class="font-medium text-on-surface-strong dark:text-on-surface-dark-strong">
                {{ __('Are you sure you want to cancel?') }}
            </p>
        </x-slot>

        <div class="p-6">
            <p class="text-sm text-on-surface dark:text-on-surface-dark">
                {{ __('Once you cancel the subscription, you can no longer recover it. You need to start a new subscription.') }}
            </p>

            <div class="mt-4 space-y-2">
                <x-radio
                    wire:key="cancel-immediately"
                    wire:model="cancel_method"
                    value="immediately"
                    class="text-sm"
                    :label="__('Cancel the subscription immediately.')"
                />

                <x-radio
                    wire:key="cancel-at-end"
                    wire:model="cancel_method"
                    value="at-end-of-period"
                    class="text-sm"
                    :label="__('Cancel the subscription at the end of the current billing period.')"
                />
            </div>

            @error('cancel_method')
                <p class="mt-2 text-sm text-danger">{{ $message }}</p>
            @enderror

            <div class="mt-6 flex flex-col-reverse gap-2 sm:flex-row sm:justify-end">
                <x-button 
                    variant="ghost" 
                    type="button"
                    x-on:click="modalIsOpen = false"
                    class="w-full md:w-fit"
                >
                    {{ __('Keep Subscription') }}
                </x-button>

                <x-button 
                    variant="danger" 
                    type="button"
                    wire:click="cancel"
                    wire:loading.attr="disabled"
                    class="w-full md:w-fit"
                >
                    <span wire:loading.remove>{{ __('Cancel Subscription') }}</span>
                    <span wire:loading>{{ __('Cancelling...') }}</span>
                </x-button>
            </div>
        </div>
    </x-modal>

    <x-modal-trigger target="cancel-subscription">
        <x-button variant="outline" class="w-full">
            {{ __('Cancel Subscription') }}
        </x-button>
    </x-modal-trigger>
</div>
