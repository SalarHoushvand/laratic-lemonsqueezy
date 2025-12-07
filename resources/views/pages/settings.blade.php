@push('head')
    <title>{{ config('app.name', 'Laravel') }} - {{ __('Settings') }}</title>
    <meta name="description" content="{{ __('Manage your profile and account settings') }}">
@endpush

<x-layouts.app>
    <div x-data="{ selectedItem: 'profile' }" class="flex flex-col p-8">
        <!-- Header -->
        <x-typography.admin-page-header :title="__('Settings')" :description="__('Manage your profile and account settings')" />


        <!-- Tabs Navigation -->
        <div class="mt-4 mb-6">
            <x-tabs :items="[
                ['slug' => 'profile', 'label' => __('Profile'), 'icon' => 'icons.user'],
                ['slug' => 'address', 'label' => __('Address'), 'icon' => 'icons.map-pin'],
                ['slug' => 'password', 'label' => __('Password'), 'icon' => 'icons.key'],
                ['slug' => 'two-factor', 'label' => __('Two-Factor Auth'), 'icon' => 'icons.shield-check'],
                ['slug' => 'appearance', 'label' => __('Appearance'), 'icon' => 'icons.computer-desktop'],
            ]" model="selectedItem" aria-label="{{ __('Settings tabs') }}"
                panel-prefix="settings-tab-" />
        </div>

        <!-- Content Area -->
        <div class="p-4">
            <!-- Profile Section -->
            <div x-cloak x-show="selectedItem === 'profile'" id="settings-tab-profile" class="w-full max-w-xl"
                role="tabpanel" aria-label="{{ __('Profile') }}">
                <livewire:settings.profile />
            </div>

            <!-- Address Section -->
            <div x-cloak x-show="selectedItem === 'address'" id="settings-tab-address" class="w-full max-w-xl"
                role="tabpanel" aria-label="{{ __('Address') }}">
                <livewire:settings.address />
            </div>

            <!-- Password Section -->
            <div x-cloak x-show="selectedItem === 'password'" id="settings-tab-password" class="w-full max-w-xl"
                role="tabpanel" aria-label="{{ __('Password') }}">
                <livewire:settings.password />
            </div>

            <!-- Two-Factor Authentication Section -->
            <div x-cloak x-show="selectedItem === 'two-factor'" id="settings-tab-two-factor" class="w-full max-w-xl"
                role="tabpanel" aria-label="{{ __('Two-Factor Auth') }}">
                <livewire:settings.two-factor />
            </div>

            <!-- Appearance Section -->
            <div x-cloak x-show="selectedItem === 'appearance'" id="settings-tab-appearance" class="w-full max-w-xl"
                role="tabpanel" aria-label="{{ __('Appearance') }}">
                <livewire:settings.appearance />
            </div>

            <!-- Delete Account Section -->
            <div x-show="selectedItem === 'profile'" class="mt-12 w-full max-w-xl">
                <livewire:settings.delete-user-form />
            </div>
        </div>
    </div>
</x-layouts.app>
