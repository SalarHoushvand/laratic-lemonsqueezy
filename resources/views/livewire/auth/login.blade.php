@push('head')
    <title>{{ __('Log in to your account') }} - {{ config('app.name') }}</title>
    <meta name="description" content="{{ __('Log in to your account on :app.', ['app' => config('app.name')]) }}">
@endpush

<div class="flex flex-col gap-4">
    <x-typography.auth-header :title="__('Log in to your account')"/>

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="login" class="flex flex-col gap-4">
        <!-- Email Address -->
        <div class="relative">
            <x-input-label for="email" :value="__('Email address')" :error="$errors->has('email')" />
            <x-input wire:model="email" :label="__('Email address')" type="email" required autofocus autocomplete="email"
                placeholder="email@example.com" class="block mt-1 w-full" :error="$errors->has('email')" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="relative">
            <div>
                <div class="flex justify-between items-center">
                    <x-input-label for="password" :value="__('Password')" :error="$errors->has('password')" />
                    @if (Route::has('password.request'))
                        <x-link class="text-sm ml-auto" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </x-link>
                    @endif
                </div>

                <x-input variant="password" wire:model="password" :label="__('Password')" type="password" required
                    autocomplete="current-password" :placeholder="__('Password')" class="block mt-1 w-full" :error="$errors->has('password')" />


                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
        </div>


        <div class="flex items-center justify-end">
            <x-button variant="primary" type="submit" class="w-full">{{ __('Log in') }}</x-button>
        </div>
    </form>

    <x-blocks.auth.social-login provider="google" />

    <x-blocks.auth.social-login provider="github" />

    @if (Route::has('register'))
        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
            {{ __('Don\'t have an account?') }}
            <x-link :href="route('register')" wire:navigate>{{ __('Sign up') }}</x-link>
        </div>
    @endif
</div>
