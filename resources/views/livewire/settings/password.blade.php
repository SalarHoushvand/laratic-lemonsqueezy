<section class="space-y-6">
    <x-typography.settings-header :title="__('Update Password')" :description="__('Ensure your account is using a long, random password to stay secure')" />

    <form wire:submit="updatePassword" class="max-w-lg space-y-6">
        <!-- Current Password -->
        <div class="flex flex-col gap-1">
            <x-input-label for="current_password" :value="__('Current Password')" :error="$errors->has('current_password')" />
            <x-input variant="password" id="current_password" type="password" wire:model="current_password" class="w-full"
                :error="$errors->has('current_password')" required autocomplete="current-password" :placeholder="__('Current Password')" aria-required="true" />
            <x-input-error :messages="$errors->get('current_password')" />
        </div>

        <!-- New Password -->
        <div class="flex flex-col gap-1">
            <x-input-label for="password" :value="__('New Password')" :error="$errors->has('password')" />
            <x-input variant="password" id="password" type="password" wire:model="password" class="w-full"
                :error="$errors->has('password')" required autocomplete="new-password" :placeholder="__('New Password')" aria-required="true" />
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <!-- Confirm Password -->
        <div class="flex flex-col gap-1">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" :error="$errors->has('password_confirmation')" />
            <x-input variant="password" id="password_confirmation" type="password" wire:model="password_confirmation"
                class="w-full" :error="$errors->has('password_confirmation')" required autocomplete="new-password" :placeholder="__('Confirm Password')"
                aria-required="true" />
            <x-input-error :messages="$errors->get('password_confirmation')" />
        </div>

        <!-- Submit Button -->
        <div class="flex items-center justify-between gap-4">
            <x-button type="submit" variant="primary" class="min-w-32" wire:loading.attr="disabled">
                <x-icons.spinner wire:loading wire:target="updatePassword"
                    class="size-4 animate-spin fill-on-primary dark:fill-on-primary-dark" />
                <span wire:loading.remove>{{ __('Save') }}</span>
                <span wire:loading wire:target="updatePassword" class="flex items-center gap-2">
                    {{ __('Saving...') }}
                </span>
            </x-button>
        </div>
    </form>
</section>
