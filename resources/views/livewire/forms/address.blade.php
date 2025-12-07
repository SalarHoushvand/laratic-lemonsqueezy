<div>
    <form wire:submit="submit" class="h-full" aria-labelledby="address-form-title">
        <!-- Street - Full Width -->
        <div class="flex w-full flex-col gap-1">
            <x-input-label for="street" :value="__('Street')" :error="$errors->has('street')" />
            <x-input id="street" type="text" wire:model="street" class="w-full" :error="$errors->has('street')"
                autocomplete="street-address" :placeholder="__('Street address')" />
            <x-input-error :messages="$errors->get('street')" />
        </div>

        <!-- City and Country - Equal Width -->
        <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-2">
            <div class="flex flex-col gap-1">
                <x-input-label for="city" :value="__('City')" :error="$errors->has('city')" />
                <x-input id="city" type="text" wire:model="city" class="w-full" :error="$errors->has('city')"
                    autocomplete="address-level2" :placeholder="__('City')" />
                <x-input-error :messages="$errors->get('city')" />
            </div>

            <div class="flex w-full flex-col gap-1">
                <x-input-label for="country" :value="__('Country')" :error="$errors->has('country')" />
                <x-country-combobox id="country" wire:model="country" class="w-full" :error="$errors->has('country')" required
                    aria-required="true" />
                <x-input-error :messages="$errors->get('country')" />
            </div>
        </div>

        <!-- State and Zip - Equal Width -->
        <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-2">
            <div class="flex flex-col gap-1">
                <x-input-label for="state" :value="__('State')" :error="$errors->has('state')" />
                <x-input id="state" type="text" wire:model="state" class="w-full" :error="$errors->has('state')"
                    autocomplete="address-level1" :placeholder="__('State/Province')" />
                <x-input-error :messages="$errors->get('state')" />
            </div>

            <div class="flex flex-col gap-1">
                <x-input-label for="zip" :value="__('Zip Code')" :error="$errors->has('zip')" />
                <x-input id="zip" type="text" wire:model="zip" class="w-full" :error="$errors->has('zip')"
                    autocomplete="postal-code" :placeholder="__('Zip/Postal code')" />
                <x-input-error :messages="$errors->get('zip')" />
            </div>
        </div>

        <!-- Timezone Field -->
        <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-2">
            <div class="mt-4 flex flex-col gap-1">
                <x-input-label for="timezone" :value="__('Timezone')" :error="$errors->has('timezone')" />
                <x-select id="timezone" wire:model="timezone" class="w-full" :error="$errors->has('timezone')">
                    <option value="">{{ __('Select a timezone') }}</option>
                    @foreach ($this->timezones as $region => $cities)
                        <optgroup label="{{ $region }}">
                            @foreach ($cities as $city => $tz)
                                <option value="{{ $tz }}" @selected($tz === $timezone)>
                                    {{ str_replace('_', ' ', $city) }}
                                </option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </x-select>
                <x-input-error :messages="$errors->get('timezone')" />
            </div>
        </div>

        <div class="mt-6 flex w-full items-center ">
            <x-button type="submit" variant="primary" class="min-w-32" wire:loading.attr="disabled">
                <x-icons.spinner wire:loading wire:target="submit"
                    class="size-4 animate-spin fill-on-primary dark:fill-on-primary-dark" />
                <span wire:loading.remove>{{ __('Save') }}</span>
                <span wire:loading wire:target="submit">
                    {{ __('Saving...') }}
                </span>
            </x-button>
        </div>
    </form>
</div>
