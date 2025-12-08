<div>
    @if ($subscription->cancelled() && !$subscription->expired())
        <x-modal name="resume-subscription">
            <x-slot name="header">
                <p class="font-medium text-on-surface-strong dark:text-on-surface-dark-strong">
                    {{ __('Resume Subscription') }}
                </p>
            </x-slot>

            <div class="p-6">
                <p class="text-sm text-on-surface dark:text-on-surface-dark">
                    {{ __('Are you sure you want to resume this subscription? The subscription will continue as normal.') }}
                </p>

                <div class="mt-6 flex flex-col-reverse gap-2 sm:flex-row sm:justify-end">
                    <x-button 
                        variant="ghost" 
                        type="button"
                        x-on:click="modalIsOpen = false"
                        class="w-full md:w-fit"
                    >
                        {{ __('Cancel') }}
                    </x-button>

                    <x-button 
                        variant="primary" 
                        type="button"
                        wire:click="resume"
                        wire:loading.attr="disabled"
                        class="w-full md:w-fit"
                    >
                        <span wire:loading.remove>{{ __('Resume Subscription') }}</span>
                        <span wire:loading>{{ __('Resuming...') }}</span>
                    </x-button>
                </div>
            </div>
        </x-modal>

        <x-modal-trigger target="resume-subscription">
            <x-button variant="primary" class="w-full">
                {{ __('Resume Subscription') }}
            </x-button>
        </x-modal-trigger>
    @elseif (!$subscription->cancelled())
        <x-modal name="cancel-subscription">
            <x-slot name="header">
                <p class="font-medium text-on-surface-strong dark:text-on-surface-dark-strong">
                    {{ __('Are you sure you want to cancel?') }}
                </p>
            </x-slot>

            <div class="p-6">
                <p class="text-sm text-on-surface dark:text-on-surface-dark">
                    {{ __('The subscription will be cancelled at the end of the current billing period. You can resume it before it expires.') }}
                </p>

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
    @endif
</div>
