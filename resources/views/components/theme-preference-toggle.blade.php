<div 
    x-data="{
        theme: localStorage.theme || 'system',
        updateTheme(newTheme) {
            this.theme = newTheme;

            if (newTheme === 'dark') {
                document.documentElement.classList.add('dark');
            } else if (newTheme === 'light') {
                document.documentElement.classList.remove('dark');
            } else {
                // System theme
                window.matchMedia('(prefers-color-scheme: dark)').matches
                    ? document.documentElement.classList.add('dark')
                    : document.documentElement.classList.remove('dark');
            }

            localStorage.theme = newTheme;
        }
    }" 
    {{ $attributes }}
>
    <div class="flex items-center gap-2 w-fit -ml-1">
        <x-tooltip 
            text="{{ __('Dark Mode') }}" 
            position="top"
        >
            <button 
                x-on:click="updateTheme('dark')" 
                class="rounded-full p-1" 
                x-bind:class="theme === 'dark' ? 'bg-primary text-on-primary dark:bg-primary-dark dark:text-on-primary-dark' : null"
            >
                <x-icons.moon 
                    variant="solid" 
                    size="sm" 
                />
                <span class="sr-only">{{ __('Dark Mode') }}</span>
            </button>
        </x-tooltip>

        <x-tooltip 
            text="{{ __('Light Mode') }}" 
            position="top"
        >
            <button 
                x-on:click="updateTheme('light')" 
                class="rounded-full p-1" 
                x-bind:class="theme === 'light' ? 'bg-primary text-on-primary dark:bg-primary-dark dark:text-on-primary-dark' : null"
            >
                <x-icons.sun 
                    variant="solid" 
                    size="sm" 
                />
                <span class="sr-only">{{ __('Light Mode') }}</span>
            </button>
        </x-tooltip>

        <x-tooltip 
            text="{{ __('System Preference') }}" 
            position="top"
        >
            <button 
                x-on:click="updateTheme('system')" 
                class="rounded-full p-1" 
                x-bind:class="theme === 'system' ? 'bg-primary text-on-primary dark:bg-primary-dark dark:text-on-primary-dark' : null"
            >
                <x-icons.computer-desktop 
                    variant="solid" 
                    size="sm" 
                />
                <span class="sr-only">{{ __('System Preference') }}</span>
            </button>
        </x-tooltip>
    </div>
</div>
