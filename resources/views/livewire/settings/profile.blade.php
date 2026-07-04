<section class="w-full">
    <!-- Header -->
   
    <x-typography.settings-header :title="__('Profile')" :description="__('Update your name and email address')" />

    <!-- Profile Form -->
    <form wire:submit="updateProfileInformation" class="my-6 w-full max-w-sm space-y-6 ">
        <!-- Avatar Field -->
        <div class="flex flex-col gap-1">
            <div class="flex items-center gap-4 w-fit">
                <x-input-file wire:model="uploadedAvatar" :errorMessage="$errors->get('uploadedAvatar')">
                    <div class="group relative inline-block cursor-pointer">
                        <x-avatar :img="$avatar ?: auth()->user()->avatar" :fallback="auth()->user()->initials() ?? 'Unknown'" size="xl" />
                        <div
                            class="absolute inset-0 flex items-center justify-center rounded-full bg-black/50 opacity-0 transition-opacity group-hover:opacity-100">
                            <x-icons.camera variant="solid" size="lg" class="text-white" />
                        </div>
                    </div>
                </x-input-file>
                @if ($avatar || auth()->user()->avatar)
                    <x-button type="button" variant="outline" size="sm" wire:click="removeAvatar"
                        wire:loading.attr="disabled">
                        <x-icons.spinner wire:loading wire:target="removeAvatar"
                            class="size-4 animate-spin fill-on-primary dark:fill-on-primary-dark" />
                        <span wire:loading.remove>{{ __('Remove Avatar') }}</span>
                        <span wire:loading wire:target="removeAvatar">{{ __('Removing...') }}</span>
                    </x-button>
                @endif
            </div>
            <x-input-error :messages="$errors->get('avatar')" />
        </div>

        <!-- Name Field -->
        <div class="flex flex-col gap-1">
            <x-input-label for="name" :value="__('Name')" :error="$errors->has('name')" />
            <x-input id="name" type="text" wire:model="name" class="w-full" :error="$errors->has('name')" required autofocus
                autocomplete="name" :placeholder="__('Name')" aria-required="true" />
            <x-input-error :messages="$errors->get('name')" />
        </div>

        <!-- Email Field -->
        <div class="flex flex-col gap-1">
            <x-input-label for="email" :value="__('Email')" :error="$errors->has('email')" />
            <x-input id="email" type="email" wire:model="email" class="w-full" :error="$errors->has('email')" required
                autocomplete="email" :placeholder="__('Email')" aria-required="true" />
            <x-input-error :messages="$errors->get('email')" />

            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !auth()->user()->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-sm text-on-surface/60 dark:text-on-surface-dark/60">
                        {{ __('Your email address is unverified.') }}
                        <button type="button"
                            class="text-primary hover:opacity-75 dark:text-primary-dark text-sm underline"
                            wire:click.prevent="resendVerificationNotification">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-sm font-medium text-success dark:text-success-dark">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Submit Button -->
        <div class="flex items-center justify-between gap-4">
            <x-button type="submit" variant="primary" class="min-w-32" wire:loading.attr="disabled">
                <x-icons.spinner wire:loading wire:target="updateProfileInformation"
                    class="size-4 animate-spin fill-on-primary dark:fill-on-primary-dark" />
                <span wire:loading.remove>{{ __('Save') }}</span>
                <span wire:loading wire:target="updateProfileInformation" class="flex items-center gap-2">
                    {{ __('Saving...') }}
                </span>
            </x-button>
        </div>
    </form>

    {{-- <livewire:settings.delete-user-form /> --}}
</section>
