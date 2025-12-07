<div>
    <x-modal name="block-user-{{ $user->id }}" :show="$errors->userDeletion->isNotEmpty()" :maxWidth="'lg'">
        <x-slot name="header">
            <p class="font-medium text-on-surface-strong dark:text-on-surface-dark-strong">
                {{ __('Are you sure you want to :action this user?', ['action' => $user->hasRole('blocked') ? __('unblock') : __('block')]) }}
            </p>
        </x-slot>
        <form wire:submit="block">
            <div class="space-y-2 p-4">
                @if ($user->hasRole('blocked'))
                    <p class="text-on-surface text-sm dark:text-on-surface-dark">
                        {{ __('Once you unblock the user, they will be able to access the platform.') }}
                    </p>
                @else
                    <p class="text-on-surface text-sm dark:text-on-surface-dark">
                        {{ __('Once you block the user, they will not be able to access the platform.') }}
                    </p>
                @endif
            </div>

            <x-slot:footer>
                <x-button variant="ghost" type="button" x-on:click="modalIsOpen = false" class="w-full md:w-fit">
                    {{ __('Cancel') }}
                </x-button>

                @if ($user->hasRole('blocked'))
                    <x-button variant="success" type="button" wire:click="toggleBlock" wire:loading.attr="disabled"
                        class="w-full md:w-fit">
                        <span wire:loading.remove wire:target="toggleBlock">{{ __('Unblock User') }}</span>
                        <span wire:loading wire:target="toggleBlock">{{ __('Unblocking...') }}</span>
                    </x-button>
                @else
                    <x-button variant="danger" type="button" wire:click="toggleBlock" wire:loading.attr="disabled"
                        class="w-full md:w-fit">
                        <span wire:loading.remove wire:target="toggleBlock">{{ __('Block User') }}</span>
                        <span wire:loading wire:target="toggleBlock">{{ __('Blocking...') }}</span>
                    </x-button>
                @endif
            </x-slot:footer>
        </form>
    </x-modal>

    <x-modal-trigger target="block-user-{{ $user->id }}">
        @if ($user->hasRole('blocked'))
            <x-button variant="success" class="mt-auto w-full whitespace-nowrap">
                {{ __('Unblock User') }}
            </x-button>
        @else
            <x-button variant="danger" class="mt-auto w-full whitespace-nowrap">
                {{ __('Block User') }}
            </x-button>
        @endif
    </x-modal-trigger>
</div>
