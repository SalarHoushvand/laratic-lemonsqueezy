<!-- Statistics Grid -->
<div {{ $attributes }}>
    <div class="grid grid-cols-1 gap-6 rounded-radius border border-outline p-6 text-center dark:border-outline-dark md:grid-cols-3 md:items-baseline">
        <!-- Global Clients Stat -->
        <div class="flex flex-col items-center justify-center gap-2">
            <p class="text-2xl font-bold text-primary dark:text-primary-dark">
                {{ __('Several Months') }}
            </p>
            <p class="text-lg">
                {{ __('Development Time Saved') }}
            </p>
        </div>

        <!-- Uptime Guarantee Stat -->
        <div class="flex flex-col items-center justify-center gap-2">
            <p class="text-2xl font-bold text-primary dark:text-primary-dark">
                {{ __('+50') }}
            </p>
            <p class="text-lg">
                {{ __('Beautifully designed pages') }}
            </p>
        </div>

        <!-- Support Availability Stat -->
        <div class="flex flex-col items-center justify-center gap-2">
            <p class="text-2xl font-bold text-primary dark:text-primary-dark">
                {{ __('+30') }}
            </p>
            <p class="text-lg">
                {{ __('Blade UI Components') }}
            </p>
        </div>
    </div>
</div>
