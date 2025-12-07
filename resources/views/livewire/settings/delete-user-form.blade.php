<section class="space-y-6">
    <x-typography.settings-header :title="__('Delete Account')" :description="__('Permanently delete your account')" />

    <x-modal name="delete-account" :show="$errors->userDeletion->isNotEmpty()" :maxWidth="'lg'">
        <x-slot:header>
            <p accent size="lg">
                {{ __('Are you sure you want to delete your account?') }}
            </p>
        </x-slot:header>

        <form wire:submit="deleteUser">
            <div class="p-4">
                <p class="text-sm text-on-surface dark:text-on-surface-dark">
                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                </p>

                <div class="mt-6">
                    <x-input-label for="password_reenter" value="{{ __('Password') }}" class="sr-only" />

                    <x-input id="password_reenter" type="password" variant="password" wire:model="password"
                        class="block w-3/4" :error="$errors->userDeletion->has('password')" required autocomplete="current-password"
                        :placeholder="__('Password')" />

                    <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                </div>
            </div>

            <x-slot:footer>
                <x-button variant="ghost" type="button" x-on:click="modalIsOpen = false" class="w-full md:w-fit">
                    {{ __('Cancel') }}
                </x-button>

                <x-button variant="danger" type="submit" class="ms-3 w-full md:w-fit" wire:loading.attr="disabled">
                    <x-icons.spinner wire:loading wire:target="deleteUser"
                        class="size-4 animate-spin fill-on-primary dark:fill-on-primary-dark" />
                    <span wire:loading.remove>{{ __('Delete Account') }}</span>
                    <span wire:loading wire:target="deleteUser" class="flex items-center gap-2">
                        {{ __('Deleting...') }}
                    </span>
                </x-button>
            </x-slot:footer>
        </form>
    </x-modal>

    <x-modal-trigger target="delete-account">
        <x-button variant="danger">
            {{ __('Delete Account') }}
        </x-button>
    </x-modal-trigger>
</section>
