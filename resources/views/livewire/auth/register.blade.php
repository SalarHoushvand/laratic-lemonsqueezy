@push('head')
    <title>{{ __('Create an account') }} - {{ config('app.name') }}</title>
    <meta name="description" content="{{ __('Create an account on :app.', ['app' => config('app.name')]) }}">
@endpush

<div class="flex flex-col gap-4">
    <x-typography.auth-header :title="__('Create an account')"  />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="register" class="flex flex-col gap-4">

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" :error="$errors->has('name')" />
            <x-input id="name" wire:model="name" :label="__('Name')" type="text" required autofocus
                autocomplete="name" :placeholder="__('Full name')" class="mt-1" :error="$errors->has('name')" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email address')" :error="$errors->has('email')" />
            <x-input id="email" wire:model="email" :label="__('Email address')" type="email" required autocomplete="email"
                :placeholder="__('email@example.com')" class="mt-1" :error="$errors->has('email')" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" :error="$errors->has('password')" />
            <x-input variant="password" id="password" wire:model="password" :label="__('Password')" type="password" required
                autocomplete="new-password" :placeholder="__('Password')" class="mt-1" :error="$errors->has('password')" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm password')" :error="$errors->has('password_confirmation')" />
            <x-input variant="password" id="password_confirmation" wire:model="password_confirmation" :label="__('Confirm password')"
                type="password" required autocomplete="new-password" :placeholder="__('Confirm password')" class="mt-1"
                :error="$errors->has('password_confirmation')" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end">
            <x-button variant="primary" type="submit" class="w-full">{{ __('Create account') }}</x-button>
        </div>
    </form>

    <x-blocks.auth.social-login provider="google" />
    
    <x-blocks.auth.social-login provider="github" />
    
    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
        {{ __('Already have an account?') }}
        <x-link :href="route('login')" wire:navigate>{{ __('Log in') }}</x-link>
    </div>
</div>
