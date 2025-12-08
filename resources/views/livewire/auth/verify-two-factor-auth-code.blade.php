@push('head')
    <title>{{ __('Two-Factor Authentication') }} - {{ config('app.name') }}</title>
    <meta name="description" content="{{ __('Verify your identity with a code sent to your email') }}">
@endpush

<div class="flex flex-col gap-6">
    <x-typography.auth-header :title="__('Two-Factor Authentication')" :description="__('A verification code has been sent to your email. Please enter it below.')" />

    <form wire:submit="verify" class="flex flex-col gap-6">
        <!-- Verification Code -->
        <div class="relative">
            <x-input-label for="code" :value="__('Verification Code')" :error="$errors->has('code')" />
            <x-input wire:model="code" :label="__('Verification Code')" type="text" id="code" required autofocus
                autocomplete="off" inputmode="numeric" pattern="[0-9]*" maxlength="6" placeholder="000000"
                class="block mt-1 w-full text-center text-2xl tracking-widest" :error="$errors->has('code')" />
            <x-input-error :messages="$errors->get('code')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end">
            <x-button variant="primary" type="submit" class="w-full">
                {{ __('Verify') }}
            </x-button>
        </div>
    </form>

    <div class="flex flex-col gap-3 text-center text-sm text-on-surface-muted dark:text-on-surface-dark-muted">
        <p>{{ __('Didn\'t receive a code?') }} <span class="link cursor-pointer" wire:click="resendCode">{{ __('Resend') }}</span></p>
        <x-button type="button" variant="ghost" wire:click="logout"
            class="w-full">
            {{ __('Use a different account') }}
        </x-button>
    </div>
</div>
