<!-- Statistics Grid -->
<div {{ $attributes }}>
    <div class="grid grid-cols-1 gap-6 rounded-radius border border-outline p-6 text-center dark:border-outline-dark md:grid-cols-3 md:items-baseline">
        <!-- Global Clients Stat -->
        <div class="flex flex-col items-center justify-center gap-2">
            <p class="text-2xl font-bold text-primary dark:text-primary-dark">
                {{ __('200+') }}
            </p>
            <p class="text-lg">
                {{ __('Clients Empowered Globally') }}
            </p>
        </div>

        <!-- Uptime Guarantee Stat -->
        <div class="flex flex-col items-center justify-center gap-2">
            <p class="text-2xl font-bold text-primary dark:text-primary-dark">
                {{ __('99.99%') }}
            </p>
            <p class="text-lg">
                {{ __('Uptime Guarantee') }}
            </p>
        </div>

        <!-- Support Availability Stat -->
        <div class="flex flex-col items-center justify-center gap-2">
            <p class="text-2xl font-bold text-primary dark:text-primary-dark">
                {{ __('24/7') }}
            </p>
            <p class="text-lg">
                {{ __('Customer Support Availability') }}
            </p>
        </div>
    </div>
</div>
