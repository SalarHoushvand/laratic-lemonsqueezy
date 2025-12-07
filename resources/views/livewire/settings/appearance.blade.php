<section x-data="{
    theme: localStorage.theme || 'system',
    updateTheme(newTheme) {
        this.theme = newTheme;
        localStorage.theme = newTheme;

        if (newTheme === 'dark') {
            document.documentElement.classList.add('dark');
        } else if (newTheme === 'light') {
            document.documentElement.classList.remove('dark');
        } else {
            // System theme
            window.matchMedia('(prefers-color-scheme: dark)').matches ?
                document.documentElement.classList.add('dark') :
                document.documentElement.classList.remove('dark');
        }
    }
}" class="space-y-6">
    <x-typography.settings-header :title="__('Appearance')" :description="__('Update the appearance settings for your account')" />

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Light Theme Card -->
        <label
            class="group cursor-pointer overflow-clip border rounded-radius transition-all duration-300 hover:shadow-md"
            x-bind:class="theme === 'light' ? 'border-primary dark:border-primary-dark' : 'border-outline dark:border-outline-dark'"
            role="radio" aria-checked="false" x-bind:aria-checked="theme === 'light'">
            <input type="radio" id="theme_light" name="theme" value="light" class="sr-only" x-model="theme"
                x-on:change="updateTheme('light')">

            <!-- Header -->
            <div class="flex items-center justify-between gap-2 p-3 bg-surface-alt dark:bg-surface-dark-alt">
                <div class="flex items-center gap-2">
                    <!-- Checkmark / Circle -->
                    <x-icons.check-circle x-show="theme === 'light'" variant="micro" size="md"
                        class="text-primary dark:text-primary-dark" />
                    <div x-show="theme !== 'light'"
                        class="size-5 rounded-full border-2 border-outline dark:border-outline-dark"></div>
                    <span class="text-sm font-semibold text-on-surface dark:text-on-surface-dark">
                        {{ __('Light') }}
                    </span>
                </div>
                <x-icons.sun variant="micro" size="sm" class="text-on-surface dark:text-on-surface-dark opacity-70" />
            </div>

            <!-- Preview -->
            <div class="h-24 bg-surface border-t border-outline dark:border-outline-dark p-3">
                <div class="flex h-full gap-2">
                    <div class="w-1/3 bg-surface-dark/10 rounded-radius p-2 space-y-1.5">
                        <div class="h-1 w-full bg-on-surface/30 rounded"></div>
                        <div class="h-1 w-full bg-on-surface/30 rounded"></div>
                        <div class="h-1 w-2/3 bg-on-surface/30 rounded"></div>
                    </div>
                    <div class="w-2/3 bg-surface-dark/10  rounded-radius"></div>
                </div>
            </div>
        </label>

        <!-- Dark Theme Card -->
        <label
            class="group cursor-pointer overflow-clip border rounded-radius transition-all duration-300 hover:shadow-md"
            x-bind:class="theme === 'dark' ? 'border-primary dark:border-primary-dark' : 'border-outline dark:border-outline-dark'"
            role="radio" aria-checked="false" x-bind:aria-checked="theme === 'dark'">
            <input type="radio" id="theme_dark" name="theme" value="dark" class="sr-only" x-model="theme"
                x-on:change="updateTheme('dark')">

            <!-- Header -->
            <div class="flex items-center justify-between gap-2 p-3 bg-surface-alt dark:bg-surface-dark-alt">
                <div class="flex items-center gap-2">
                    <!-- Checkmark / Circle -->
                    <x-icons.check-circle x-show="theme === 'dark'" variant="micro" size="md"
                        class="text-primary dark:text-primary-dark" />
                    <div x-show="theme !== 'dark'"
                        class="size-5 rounded-full border-2 border-outline dark:border-outline-dark"></div>
                    <span class="text-sm font-semibold text-on-surface dark:text-on-surface-dark">
                        {{ __('Dark') }}
                    </span>
                </div>
                <x-icons.moon variant="micro" size="sm" class="text-on-surface dark:text-on-surface-dark opacity-70" />
            </div>

            <!-- Preview -->
            <div class="h-24 bg-zinc-900 border-t border-outline dark:border-outline-dark p-3">
                <div class="flex h-full gap-2">
                    <div class="w-1/3 bg-surface/10 rounded-radius p-2 space-y-1.5">
                        <div class="h-1 w-full bg-on-surface-dark/30 rounded"></div>
                        <div class="h-1 w-full bg-on-surface-dark/30 rounded"></div>
                        <div class="h-1 w-2/3 bg-on-surface-dark/30 rounded"></div>
                    </div>
                    <div class="w-2/3 bg-surface/10 rounded-radius"></div>
                </div>
            </div>
        </label>

        <!-- System Theme Card -->
        <label
            class="group cursor-pointer overflow-clip border rounded-radius transition-all duration-300 hover:shadow-md"
            x-bind:class="theme === 'system' ? 'border-primary dark:border-primary-dark' : 'border-outline dark:border-outline-dark'"
            role="radio" aria-checked="false" x-bind:aria-checked="theme === 'system'">
            <input type="radio" id="theme_system" name="theme" value="system" class="sr-only" x-model="theme"
                x-on:change="updateTheme('system')">

            <!-- Header -->
            <div class="flex items-center justify-between gap-2 p-3 bg-surface-alt dark:bg-surface-dark-alt">
                <div class="flex items-center gap-2">
                    <!-- Checkmark / Circle -->
                    <x-icons.check-circle x-show="theme === 'system'" variant="micro" size="md"
                        class="text-primary dark:text-primary-dark" />

                    <div x-show="theme !== 'system'"
                        class="size-5 rounded-full border-2 border-outline dark:border-outline-dark"></div>
                    <span class="text-sm font-semibold text-on-surface dark:text-on-surface-dark">
                        {{ __('System') }}
                    </span>
                </div>
                <x-icons.computer-desktop variant="micro" size="sm" class="text-on-surface dark:text-on-surface-dark opacity-70" />
            </div>

            <!-- Preview (Split) -->
            <div class="h-24 border-t border-outline dark:border-outline-dark flex">
                <!-- Light Half -->
                <div class="w-1/2 bg-surface p-2">
                    <div class="bg-surface rounded-radius h-full p-1.5 space-y-1">
                        <div class="h-0.5 w-full bg-on-surface/30 rounded"></div>
                        <div class="h-0.5 w-3/4 bg-on-surface/30 rounded"></div>
                    </div>
                </div>
                <!-- Dark Half -->
                <div class="w-1/2 bg-surface-dark p-2">
                    <div class="bg-surface-dark rounded-radius h-full p-1.5 space-y-1">
                        <div class="h-0.5 w-full bg-on-surface-dark/30 rounded"></div>
                        <div class="h-0.5 w-3/4 bg-on-surface-dark/30 rounded"></div>
                    </div>
                </div>
            </div>
        </label>
    </div>
</section>
