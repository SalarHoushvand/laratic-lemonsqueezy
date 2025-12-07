<section class="w-full">
    <!-- Header -->
    <x-typography.settings-header :title="__('Two-Factor Authentication')" :description="__('Add an extra layer of security to your account by enabling two-factor authentication via SMS')" />

    <!-- Current Status -->
    <div class="my-4 sm:my-6 w-full max-w-lg">
        @if (auth()->user()->two_factor_enabled)
            <!-- 2FA Enabled State -->
            <div class="panel-alt p-3 sm:p-4">
                <div class="flex flex-col items-start gap-2 sm:gap-3">
                    <div class="flex items-center gap-1.5 sm:gap-2">
                        <x-icons.check-circle class="text-success" size="md" variant="mini" />
                        <h3 class="text-sm sm:text-base font-semibold">{{ __('Two-Factor Authentication is enabled') }}</h3>
                    </div>
                    <div class="flex-1">
                        <p class="mt-1 text-xs sm:text-sm text-on-surface dark:text-on-surface-dark">
                            {{ __('Your account is protected with SMS verification.') }}
                        </p>
                        @if (auth()->user()->phone)
                            <p class="mt-2 text-xs sm:text-sm text-on-surface-muted dark:text-on-surface-dark-muted">
                                {{ __('Phone number:') }} <span class="font-mono font-light">{{ str_repeat('*', max(0, strlen(auth()->user()->phone) - 4)) . substr(auth()->user()->phone, -4) }}</span>
                            </p>
                        @endif
                    </div>
                </div>
                <div class="mt-3 sm:mt-4">
                    <x-button type="button" variant="danger" class="w-full sm:w-fit" x-on:click="$dispatch('open-modal', { name: 'disable-2fa-confirm' })">
                        {{ __('Disable Two-Factor Authentication') }}
                    </x-button>
                </div>
            </div>
        @else
            <!-- 2FA Disabled State -->
            <div class="panel-alt p-3 sm:p-4">
                <div class="flex flex-col items-start gap-2 sm:gap-3">
                    <div class="flex items-center gap-1.5 sm:gap-2">
                        <x-icons.lock-closed class="text-on-surface-muted dark:text-on-surface-dark-muted shrink-0" size="sm" variant="mini" />
                        <h3 class="text-sm sm:text-base font-semibold">{{ __('Two-Factor Authentication is disabled') }}</h3>
                    </div>
                    <div class="flex-1">
                        <p class="mt-1 text-xs sm:text-sm text-on-surface dark:text-on-surface-dark">
                            {{ __('Enable 2FA to receive a verification code via SMS each time you log in.') }}
                        </p>
                    </div>
                </div>
                <div class="mt-3 sm:mt-4">
                    <x-button type="button" variant="primary" class="w-full sm:w-fit" x-on:click="$dispatch('open-modal', { name: 'enable-2fa' })">
                        {{ __('Enable Two-Factor Authentication') }}
                    </x-button>
                </div>
            </div>
        @endif
    </div>

    <!-- Enable 2FA Modal (Step 1: Enter Phone Number) -->
    <x-modal name="enable-2fa" maxWidth="lg">
        <x-slot name="header">
            <h3 class="heading-6 text-on-surface-strong dark:text-on-surface-dark-strong">
                {{ __('Enable Two-Factor Authentication') }}
            </h3>
        </x-slot>

        <div class="space-y-3 sm:space-y-4 px-4 sm:px-6 py-2">
            <p class="text-xs sm:text-sm text-on-surface dark:text-on-surface-dark">
                {{ __('Enter your phone number to receive verification codes via SMS.') }}
            </p>

            <div class="flex flex-col gap-1">
                <x-combobox-phone wireModel="phone" id="phone" name="phone" label="{{ __('Phone Number') }}"
                    placeholder="+1 234-567-8900" defaultCountry="us" />
                <x-input-error :messages="$errors->get('phone')" />
            </div>

            <div class="flex flex-col gap-1">
                <x-checkbox wire:model="sms_consent" id="sms_consent" :label="__('I consent to receive SMS messages')" :description="__(
                    'By checking this box, you agree to receive SMS messages for two-factor authentication purposes. Standard message and data rates may apply.',
                )" />
                <x-input-error :messages="$errors->get('sms_consent')" />
            </div>
        </div>

        <x-slot name="footer">
            <x-button type="button" variant="ghost" x-on:click="$dispatch('close-modal')" class="w-full md:w-fit">
                {{ __('Cancel') }}
            </x-button>
            <x-button type="button" variant="primary" wire:click="sendVerificationCode" wire:loading.attr="disabled" class="w-full md:w-fit">
                <x-icons.spinner wire:loading wire:target="sendVerificationCode"
                    class="size-4 animate-spin fill-on-primary dark:fill-on-primary-dark" />
                <span>{{ __('Send Verification Code') }}</span>
            </x-button>
        </x-slot>
    </x-modal>

    <!-- Verify Phone Modal (Step 2: Enter Verification Code) -->
    <x-modal name="verify-phone" maxWidth="md">
        <x-slot name="header">
            <h3 class="heading-6 text-on-surface-strong dark:text-on-surface-dark-strong">
                {{ __('Verify Phone Number') }}
            </h3>
        </x-slot>

        <div class="space-y-3 sm:space-y-4 px-4 sm:px-6 py-2">
            <p class="text-xs sm:text-sm text-on-surface dark:text-on-surface-dark">
                {{ __('We\'ve sent a 6-digit verification code to') }} <span
                    class="font-mono font-semibold">{{ $phone }}</span>
            </p>

            <div class="flex flex-col gap-1">
                <x-input-label for="verification_code" :value="__('Verification Code')" :error="$errors->has('verification_code')" />
                <x-input id="verification_code" type="text" wire:model="verification_code" :error="$errors->has('verification_code')"
                    placeholder="000000" maxlength="6" autofocus x-on:keydown.enter="$wire.verifyAndEnable()" />
                <x-input-error :messages="$errors->get('verification_code')" />
                <p class="mt-1 text-xs text-on-surface/60 dark:text-on-surface-dark/60">
                    {{ __('The code will expire in 15 minutes.') }}
                </p>
            </div>

            <div>
                <button type="button" wire:click="resendCode"
                    class="text-xs sm:text-sm text-primary hover:text-primary-hover dark:text-primary-dark dark:hover:text-primary-dark-hover underline"
                    wire:loading.attr="disabled">
                    {{ __('Resend code') }}
                </button>
            </div>
        </div>

        <x-slot name="footer">
            <x-button type="button" variant="ghost" x-on:click="$dispatch('close-modal')" class="w-full md:w-fit">
                {{ __('Cancel') }}
            </x-button>
            <x-button type="button" variant="primary" wire:click="verifyAndEnable" wire:loading.attr="disabled" class="w-full md:w-fit">
                <x-icons.spinner wire:loading wire:target="verifyAndEnable"
                    class="size-4 animate-spin fill-on-primary dark:fill-on-primary-dark" />
                <span wire:loading.remove wire:target="verifyAndEnable">{{ __('Verify and Enable') }}</span>
                <span wire:loading wire:target="verifyAndEnable">{{ __('Verifying...') }}</span>
            </x-button>
        </x-slot>
    </x-modal>

    <!-- Disable 2FA Confirmation Modal -->
    <x-modal name="disable-2fa-confirm" maxWidth="md">
        <x-slot name="header">
            <h3 class="heading-6 text-on-surface-strong dark:text-on-surface-dark-strong">
                {{ __('Are you sure?') }}
            </h3>
        </x-slot>
        <div class="space-y-3 sm:space-y-4 px-4 sm:px-6 py-2">
            <p class="text-xs sm:text-sm text-on-surface dark:text-on-surface-dark">
                {{ __('Disabling two-factor authentication will make your account less secure. You will no longer receive SMS verification codes when logging in. Please enter your password to confirm.') }}
            </p>

            <div class="flex flex-col gap-1">
                <x-input-label for="password_disable_2fa" :value="__('Password')" :error="$errors->has('password')" />
                <x-input id="password_disable_2fa" type="password" variant="password" wire:model="password"
                    :error="$errors->has('password')" required autocomplete="current-password"
                    :placeholder="__('Password')" x-on:keydown.enter="$wire.disableTwoFactor()" />
                <x-input-error :messages="$errors->get('password')" />
            </div>
        </div>

        <x-slot name="footer">
            <x-button type="button" variant="ghost" x-on:click="$dispatch('close-modal')" class="w-full md:w-fit">
                {{ __('Cancel') }}
            </x-button>
            <x-button type="button" variant="danger" wire:click="disableTwoFactor" wire:loading.attr="disabled" class="w-full md:w-fit">
                <x-icons.spinner wire:loading wire:target="disableTwoFactor"
                    class="size-4 animate-spin fill-on-primary dark:fill-on-primary-dark" />
                <span wire:loading.remove wire:target="disableTwoFactor">{{ __('Disable 2FA') }}</span>
                <span wire:loading wire:target="disableTwoFactor">{{ __('Disabling...') }}</span>
            </x-button>
        </x-slot>
    </x-modal>
</section>
