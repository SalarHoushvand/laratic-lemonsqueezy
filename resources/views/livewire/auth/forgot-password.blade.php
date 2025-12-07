@push('head')
    <title>{{ __('Forgot password') }} - {{ config('app.name') }}</title>
    <meta name="description" content="{{ __('Reset your password on :app.', ['app' => config('app.name')]) }}">
@endpush

<div class="flex flex-col gap-6">
    <x-typography.auth-header :title="__('Forgot password')" :description="__('Enter your email to receive a password reset link')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="sendPasswordResetLink" class="flex flex-col gap-6">
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email Address')" :error="$errors->has('email')" />
            <x-input id="email" wire:model="email" :label="__('Email Address')" type="email" required autofocus
                placeholder="email@example.com" class="mt-1" :error="$errors->has('email')" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <x-button variant="primary" type="submit" class="w-full">{{ __('Email password reset link') }}</x-button>
    </form>

    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-on-surface-muted dark:text-on-surface-dark-muted">
        {{ __('Or, return to') }}
        <x-link :href="route('login')" wire:navigate>{{ __('log in') }}</x-link>
    </div>
</div>
