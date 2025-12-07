@push('head')
    <title>{{ __('Reset password') }} - {{ config('app.name') }}</title>
    <meta name="description" content="{{ __('Reset your password on :app.', ['app' => config('app.name')]) }}">
@endpush

<div class="flex flex-col gap-6">
    <x-typography.auth-header :title="__('Reset password')" :description="__('Please enter your new password below')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="resetPassword" class="flex flex-col gap-6">
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" :error="$errors->has('email')" />
            <x-input id="email" wire:model="email" :label="__('Email')" type="email" required autocomplete="email"
                placeholder="email@example.com" class="mt-1" :error="$errors->has('email')" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" :error="$errors->has('password')" />
            <x-input id="password" wire:model="password" :label="__('Password')" type="password" required
                autocomplete="new-password" :placeholder="__('Password')" class="mt-1" :error="$errors->has('password')" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm password')" :error="$errors->has('password_confirmation')" />
            <x-input id="password_confirmation" wire:model="password_confirmation" :label="__('Confirm password')"
                type="password" required autocomplete="new-password" :placeholder="__('Confirm password')" class="mt-1"
                :error="$errors->has('password_confirmation')" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2"/>
        </div>

        <div class="flex items-center justify-end">
            <x-button variant="primary" type="submit" class="w-full">{{ __('Reset password') }}</x-button>
        </div>
    </form>
</div>
