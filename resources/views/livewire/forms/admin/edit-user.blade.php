<div class="w-full">
    <form wire:submit="save" class="h-full panel">

        @if ($user->hasRole('blocked'))
            <x-alert class="mb-4" showIcon="true" variant="warning"
                text="{{ __('This user is blocked and cannot access the system.') }}" />
        @endif


        <div class="mb-6">
            <div class="flex items-center gap-4 w-fit">
                <x-input-file name="avatar" target="avatar" :componentId="$this->getId()" :errorMessage="$errors->get('avatar')">
                    <div class="group relative inline-block cursor-pointer">
                        <x-avatar :img="$avatar ?: $user->avatar" :name="$user->name" size="xl"/>
                        <div
                            class="absolute inset-0 flex items-center justify-center rounded-full bg-black/50 opacity-0 transition-opacity group-hover:opacity-100">
                            <x-icons.camera variant="solid" size="lg" class="text-white" />
                        </div>
                    </div>
                </x-input-file>
                @if ($avatar || $user->avatar)
                    <x-button type="button" variant="outline" size="sm" wire:click="removeAvatar"
                        wire:loading.attr="disabled">
                        <x-icons.spinner wire:loading wire:target="removeAvatar"
                            class="size-4 animate-spin fill-on-primary dark:fill-on-primary-dark" />
                        <span wire:loading.remove>{{ __('Remove Avatar') }}</span>
                        <span wire:loading wire:target="removeAvatar">{{ __('Removing...') }}</span>
                    </x-button>
                @endif
            </div>
            <x-input-error :messages="$errors->get('avatar')" class="mt-2" />
        </div>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-input wire:model="name" id="name" class="mt-1 block w-full" type="text" required autofocus />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-input wire:model="email" id="email" class="mt-1 block w-full" type="email" required />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="phone" :value="__('Phone')" />
                <x-input wire:model="phone" id="phone" :placeholder="__('(999) 999-9999')" x-mask="(999) 999-9999"
                    class="mt-1 block w-full" type="text" />
                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            </div>
        </div>

        <h2 class="heading-5 mb-4 mt-10 text-on-surface-strong dark:text-on-surface-dark-strong">
            {{ __('Address') }}
        </h2>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <div class="flex w-full flex-col gap-1">
                <x-input-label for="country" :value="__('Country')" :error="$errors->has('country')" />
                <x-country-combobox wire:model="country" id="country" width="w-full" :error="$errors->has('country')"
                    :selected="$country" />
                <x-input-error :messages="$errors->get('country')" />
            </div>

            <div class="col-span-2">
                <x-input-label for="street" :value="__('Street')" />
                <x-input wire:model="street" id="street" class="mt-1 block w-full" type="text" />
                <x-input-error :messages="$errors->get('street')" class="mt-2" />
            </div>
        </div>

        <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-3">
            <div>
                <x-input-label for="city" :value="__('City')" />
                <x-input wire:model="city" id="city" class="mt-1 block w-full" type="text" />
                <x-input-error :messages="$errors->get('city')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="state" :value="__('State')" />
                <x-input wire:model="state" id="state" class="mt-1 block w-full" type="text" />
                <x-input-error :messages="$errors->get('state')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="zip" :value="__('Zip Code')" />
                <x-input wire:model="zip" id="zip" class="mt-1 block w-full" type="text" />
                <x-input-error :messages="$errors->get('zip')" class="mt-2" />
            </div>
        </div>

        <div class="mt-6 ml-auto flex w-full items-center justify-end">
            <x-button type="submit" class="w-full md:w-44">
                {{ __('Save') }}
            </x-button>
        </div>
    </form>
</div>
