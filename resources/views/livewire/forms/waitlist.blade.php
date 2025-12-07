<div>
    <!-- Waitlist Form -->
    <form 
        wire:submit="submit"
        class="flex flex-col gap-4 items-center"
        aria-labelledby="waitlist-title"
    >
        <!-- Honeypot Field -->
        <input 
            type="text" 
            wire:model="website" 
            autocomplete="off" 
            tabindex="-1" 
            hidden
        >

        <div class="flex flex-col gap-2 items-center md:flex-row text-left">
            <div>
                <x-input 
                    id="waitlist-email"
                    type="email"
                    wire:model="email"
                    class="min-w-72"
                    :error="$errors->has('email')"
                    required
                    autocomplete="email"
                    :placeholder="__('Your Email')"
                    aria-required="true"
                />
                <x-input-error 
                    class="mt-2"
                    :messages="$errors->get('email')"
                />
            </div>
            <x-button 
                type="submit"
                variant="primary"
                class="hidden no-wrap shrink-0 md:block"
                wire:loading.attr="disabled"
            >
                <x-icons.spinner 
                    wire:loading 
                    wire:target="submit"
                    class="size-4 animate-spin fill-on-primary dark:fill-on-primary-dark" 
                />
                <span wire:loading.remove>{{ __('Join Waitlist') }}</span>
                <span 
                    wire:loading 
                    wire:target="submit"
                    class="flex items-center gap-2"
                >
                    {{ __('Submitting...') }}
                </span>
            </x-button>
        </div>

        <div class="flex gap-3">
            <x-checkbox 
                id="data_processing_consent"
                wire:model="data_processing_consent"
                :error="$errors->has('data_processing_consent')"
                required
                aria-required="true"
            />
            <x-input-label 
                class="!mt-0 inline text-xs"
                for="data_processing_consent"
            >
                {!! __('I agree to receive the newsletter and accept the <a href=":privacy_url" class="dark:text-primary-dark hover:opacity-75 text-primary" target="_blank">Privacy Policy</a>.', [
                    'privacy_url' => route('privacy'),
                ]) !!}
            </x-input-label>
        </div>
        <x-input-error :messages="$errors->get('data_processing_consent')" />

        <!-- Mobile Submit Button -->
        <x-button 
            type="submit"
            variant="primary"
            class="md:hidden no-wrap shrink-0"
            wire:loading.attr="disabled"
        >
            <x-icons.spinner 
                wire:loading 
                wire:target="submit"
                class="size-4 animate-spin fill-on-primary dark:fill-on-primary-dark" 
            />
            <span wire:loading.remove>{{ __('Join Waitlist') }}</span>
            <span 
                wire:loading 
                wire:target="submit"
                class="flex items-center gap-2"
            >
                {{ __('Submitting...') }}
            </span>
        </x-button>
    </form>
</div>
