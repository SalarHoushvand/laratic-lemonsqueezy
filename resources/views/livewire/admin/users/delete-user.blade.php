<div>
    <x-modal name="delete-user-{{ $user->id }}" :show="$errors->userDeletion->isNotEmpty()" :maxWidth="'lg'">
        <x-slot:header>
            <p class="font-medium text-on-surface-strong dark:text-on-surface-dark-strong">
                {{ __('You are about to delete a user permanently.') }}
            </p>
        </x-slot:header>
        <form wire:submit="delete">
            <div class="space-y-2 p-4">
                <p class="text-sm text-on-surface dark:text-on-surface-dark">
                    {{ __('Once you delete the user, you can no longer recover it. If the user has an active subscription, it will be cancelled immediately.') }}
                </p>
            </div>

            <x-slot:footer>
                <x-button variant="ghost" type="button" x-on:click="modalIsOpen = false" class="w-full md:w-fit">
                    {{ __('Cancel') }}
                </x-button>

                <x-button variant="danger" type="button" wire:click="delete" wire:loading.attr="disabled"
                    class="w-full md:w-fit">
                    <span wire:loading.remove>{{ __('Delete User') }}</span>
                    <span wire:loading>{{ __('Deleting...') }}</span>
                </x-button>
            </x-slot:footer>
        </form>
    </x-modal>

    <x-modal-trigger target="delete-user-{{ $user->id }}">
        <x-button variant="danger" class="mt-auto w-full whitespace-nowrap">
            {{ __('Delete User') }}
        </x-button>
    </x-modal-trigger>
</div>
