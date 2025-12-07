<div>
    <!-- Demo Request Form -->
    <form wire:submit="submit"
        class="mx-auto mt-12 grid max-w-lg grid-cols-1 gap-8 place-content-center md:max-w-2xl md:grid-cols-2"
        aria-labelledby="demo-request-title">
        <!-- Honeypot Field -->
        <input type="text" wire:model="website" autocomplete="off" tabindex="-1" hidden>

        <!-- Personal Information Section -->
        <div class="flex flex-col gap-1">
            <x-input-label for="name" :value="__('Name')" :error="$errors->has('name')" />
            <x-input id="name" type="text" wire:model="name" class="w-full" :error="$errors->has('name')" required
                autocomplete="name" :placeholder="__('Name')" aria-required="true" />
            <x-input-error :messages="$errors->get('name')" />
        </div>

        <div class="flex flex-col gap-1">
            <x-input-label for="email" :value="__('Work Email')" :error="$errors->has('email')" />
            <x-input id="email" type="email" wire:model="email" class="w-full" :error="$errors->has('email')" required
                autocomplete="email" :placeholder="__('Work Email')" aria-required="true" />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <!-- Company Information Section -->
        <div class="flex flex-col gap-1 w-full">
            <x-input-label for="company_size" :value="__('Company Size')" :error="$errors->has('company_size')" />
            <x-select id="company_size" wire:model="company_size" :error="$errors->has('company_size')" required
                aria-required="true">
                <option value="">{{ __('Please Select') }}</option>
                <option value="1-10">1-10</option>
                <option value="11-50">11-50</option>
                <option value="51-200">51-200</option>
                <option value="201-500">201-500</option>
                <option value="501-1000">501-1000</option>
                <option value="1000+">1000+</option>
            </x-select>
            <x-input-error :messages="$errors->get('company_size')" />
        </div>

        <div class="flex flex-col gap-1 w-full">
            <x-input-label for="country" :value="__('Country')" :error="$errors->has('country')" />
            <x-country-combobox id="country" wire:model="country" class="w-full" :error="$errors->has('country')" />
            <x-input-error :messages="$errors->get('country')" />
        </div>

        <!-- Message Section -->
        <div class="flex flex-col gap-1 w-full col-span-1 md:col-span-2" x-data="{
            messageLength: 0,
            maxLength: 300,
            init() {
                this.messageLength = $refs.messageField.value.length;
            }
        }">
            <div class="flex justify-between">
                <x-input-label for="message" :value="__('Message (optional)')" :error="$errors->has('message')" />
                <span class="text-xs"
                    x-bind:class="messageLength >= maxLength ? 'text-danger font-bold' :
                        'text-on-surface/60 dark:text-on-surface-dark/60'"
                    x-text="`${messageLength}/${maxLength}`"></span>
            </div>
            <x-text-area id="message" wire:model="message" class="w-full" rows="4" :placeholder="__('Your message goes right here ...')"
                :error="$errors->has('message')" x-ref="messageField" x-on:input="messageLength = $el.value.length"></x-text-area>
            <x-input-error :messages="$errors->get('message')" />
        </div>

        <!-- Consent Section -->
        <div class="flex flex-col gap-4 w-full col-span-1 md:col-span-2">
            <div class="flex gap-3">
                <x-checkbox id="data_processing_consent" wire:model="data_processing_consent" :error="$errors->has('data_processing_consent')"
                    required aria-required="true" />
                <x-input-label class="!mt-0 inline" for="data_processing_consent">
                    {!! __(
                        'I consent to :app processing my personal data as described in the <a href=":privacy_url" class="text-primary hover:opacity-75 dark:text-primary-dark" target="_blank">Privacy Policy</a>.',
                        [
                            'app' => config('app.name'),
                            'privacy_url' => route('privacy'),
                        ],
                    ) !!}
                </x-input-label>
            </div>
            <x-input-error :messages="$errors->get('data_processing_consent')" />

            <div class="flex gap-3">
                <x-checkbox id="marketing_consent" wire:model="marketing_consent" :error="$errors->has('marketing_consent')" />
                <x-input-label class="!mt-0 inline" for="marketing_consent">
                    {{ __('I agree to receive marketing communications from :app.', ['app' => config('app.name')]) }}
                </x-input-label>
            </div>
            <x-input-error :messages="$errors->get('marketing_consent')" />
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end w-full col-span-1 md:col-span-2">
            <x-button type="submit" variant="primary" class="min-w-32" wire:loading.attr="disabled">
                <x-icons.spinner wire:loading wire:target="submit"
                    class="size-4 animate-spin fill-on-primary dark:fill-on-primary-dark" />
                <span wire:loading.remove>{{ __('Submit') }}</span>
                <span wire:loading wire:target="submit" class="flex items-center gap-2">
                    {{ __('Submitting...') }}
                </span>
            </x-button>
        </div>
    </form>
</div>
