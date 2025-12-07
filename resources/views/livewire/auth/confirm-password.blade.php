@push('head')
    <title>{{ __('Confirm password') }} - {{ config('app.name') }}</title>
    <meta name="description" content="{{ __('Confirm your password on :app.', ['app' => config('app.name')]) }}">
@endpush

<div class="flex flex-col gap-6">
    <x-typography.auth-header
        :title="__('Confirm password')"
        :description="__('This is a secure area of the application. Please confirm your password before continuing.')"
    />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="confirmPassword" class="flex flex-col gap-6">
        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" :error="$errors->has('password')" />
            <x-input id="password" wire:model="password" :label="__('Password')" type="password" required
                autocomplete="new-password" :placeholder="__('Password')" class="mt-1" :error="$errors->has('password')" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <x-button variant="primary" type="submit" class="w-full">{{ __('Confirm') }}</x-button>
    </form>
</div>
