<div>
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}

    <!-- Newsletter Form -->
    <form wire:submit="submit" class="flex flex-col gap-4 max-w-sm mx-auto" aria-labelledby="newsletter-title">
        <!-- Honeypot Field -->
        <input type="text" wire:model="website" autocomplete="off" tabindex="-1" hidden>

        <!-- Email Field -->
        <div class="flex flex-col gap-1">
            <x-input-label for="email" :value="__('Email')" :error="$errors->has('email')" class="sr-only" />
            <x-input id="email" type="email" wire:model="email" class="w-full" :error="$errors->has('email')" required
                autocomplete="email" :placeholder="__('Email')" aria-required="true" />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <!-- Consent Section -->
        <div class="flex flex-col gap-4 w-full">
            <div class="flex items-start text-left gap-3">
                <x-checkbox id="data_processing_consent" wire:model="data_processing_consent" :error="$errors->has('data_processing_consent')" required
                    aria-required="true" />
                <x-input-label class="!mt-0 inline text-xs" for="data_processing_consent">
                    {!! __(
                        'I agree to receive the newsletter and accept the <a href=":privacy_url" class="text-primary hover:opacity-75 dark:text-primary-dark" target="_blank">Privacy Policy</a>.',
                        [
                            'privacy_url' => route('privacy'),
                        ],
                    ) !!}
                </x-input-label>
            </div>
            <x-input-error :messages="$errors->get('data_processing_consent')" />
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end w-full">
            <x-button type="submit" variant="primary" wire:loading.attr="disabled">
                <x-icons.spinner wire:loading wire:target="submit"
                    class="size-4 animate-spin fill-on-primary dark:fill-on-primary-dark" />
                <span wire:loading.remove>{{ __('Sign Up') }}</span>
                <span wire:loading wire:target="submit" class="flex items-center gap-2">
                    {{ __('Submitting...') }}
                </span>
            </x-button>
        </div>
    </form>
</div>
