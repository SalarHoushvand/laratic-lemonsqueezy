<x-modal name="swap-plan-{{ $plan->lemon_squeezy_variant_id }}" :maxWidth="'lg'">
    <x-slot name="header">
        <p class="text-sm text-on-surface-strong dark:text-on-surface-dark-strong font-bold">{{ __('Are you sure you want to switch to this plan?') }}</p>
    </x-slot>
    <div>

        <div class="p-4">
            <p class="text-sm text-on-surface dark:text-on-surface-dark">
                {{ __('This will cancel your current plan and switch to the new plan. You will be charged for the new plan immediately.') }}
            </p>
        </div>

        <div
            class="mt-4 flex flex-col-reverse justify-between gap-2 border-t border-outline bg-surface-alt/60 p-4 dark:border-outline-dark dark:bg-surface-dark/20 sm:flex-row sm:items-center md:justify-end">
            <x-button variant="ghost" type="button" x-on:click="modalIsOpen = false" class="w-full md:w-fit">
                {{ __('Cancel') }}
            </x-button>

            <x-button variant="primary" wire:click="swapPlan('{{ $plan->lemon_squeezy_variant_id }}')" class="w-full md:w-fit">
                <x-icons.spinner class="size-4 animate-spin fill-on-primary dark:fill-on-primary-dark" wire:loading
                    wire:target="swapPlan('{{ $plan->lemon_squeezy_variant_id }}')" />
                {{ __('Switch to') }}<span class="font-bold">{{ $plan->name }}</span>
            </x-button>
        </div>

    </div>
</x-modal>

<x-modal-trigger target="swap-plan-{{ $plan->lemon_squeezy_variant_id }}">
    <div {{ $attributes }}>
        {{ $slot }}
    </div>
</x-modal-trigger>
