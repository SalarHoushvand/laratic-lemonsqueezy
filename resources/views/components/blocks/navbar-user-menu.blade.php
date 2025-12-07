<div x-cloak x-show="userDropdownIsOpen" x-on:click.outside="userDropdownIsOpen = false"
    x-on:keydown.down.prevent="$focus.wrap().next()" x-on:keydown.up.prevent="$focus.wrap().previous()" x-transition
    x-trap="userDropdownIsOpen"
    class="absolute right-0 top-11 z-20 h-fit w-48 divide-y divide-outline rounded-radius border border-outline bg-surface dark:divide-outline-dark dark:border-outline-dark dark:bg-surface-dark"
    role="menu">
    <!-- Dashboard Section -->
    <div class="flex flex-col py-1.5">
        <a href="{{ route('dashboard') }}"
            class="flex items-center gap-2 px-2 py-1.5 text-sm font-medium text-on-surface underline-offset-2 hover:bg-primary/5 hover:text-on-surface-strong focus-visible:underline focus:outline-hidden dark:text-on-surface-dark dark:hover:bg-primary-dark/5 dark:hover:text-on-surface-dark-strong"
            role="menuitem">
            <x-icons.home variant="solid" size="md" />
            <span>{{ __('Dashboard') }}</span>
        </a>
    </div>

    @auth
        @if (auth()->user()->hasRole('admin'))
            <div class="flex flex-col py-1.5">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-2 px-2 py-1.5 text-sm font-medium text-on-surface underline-offset-2 hover:bg-primary/5 hover:text-on-surface-strong focus-visible:underline focus:outline-hidden dark:text-on-surface-dark dark:hover:bg-primary-dark/5 dark:hover:text-on-surface-dark-strong"
                    role="menuitem">
                    <x-icons.chart-bar variant="solid" size="md" />
                    <span>{{ __('Admin Dashboard') }}</span>
                </a>
            </div>
        @endif
    @endauth

    <!-- Settings Section -->
    <div class="flex flex-col py-1.5">
        <a href="{{ route('settings') }}"
            class="flex items-center gap-2 px-2 py-1.5 text-sm font-medium text-on-surface underline-offset-2 hover:bg-primary/5 hover:text-on-surface-strong focus-visible:underline focus:outline-hidden dark:text-on-surface-dark dark:hover:bg-primary-dark/5 dark:hover:text-on-surface-dark-strong"
            role="menuitem">
            <x-icons.cog-6-tooth variant="solid" size="md" />
            <span>{{ __('Settings') }}</span>
        </a>

        <a href="{{ route('subscription.manage') }}"
            class="flex items-center gap-2 px-2 py-1.5 text-sm font-medium text-on-surface underline-offset-2 hover:bg-primary/5 hover:text-on-surface-strong focus-visible:underline focus:outline-hidden dark:text-on-surface-dark dark:hover:bg-primary-dark/5 dark:hover:text-on-surface-dark-strong"
            role="menuitem">
            <x-icons.credit-card variant="solid" size="md" />
            <span>{{ __('Subscription') }}</span>
        </a>
    </div>

    <!-- Theme Section -->
    <div class="flex flex-col gap-2 py-1.5 px-2"
        x-data="{
            theme: localStorage.theme || 'system',
            init() {
                this.applyTheme();

                const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
                mediaQuery.addEventListener('change', (event) => {
                    if (this.theme === 'system') {
                        event.matches
                            ? document.documentElement.classList.add('dark')
                            : document.documentElement.classList.remove('dark');
                    }
                });
            },
            applyTheme() {
                if (this.theme === 'dark') {
                    document.documentElement.classList.add('dark');
                } else if (this.theme === 'light') {
                    document.documentElement.classList.remove('dark');
                } else {
                    window.matchMedia('(prefers-color-scheme: dark)').matches
                        ? document.documentElement.classList.add('dark')
                        : document.documentElement.classList.remove('dark');
                }
            },
            updateTheme(newTheme) {
                this.theme = newTheme;
                localStorage.theme = newTheme;
                this.applyTheme();
            }
        }">
        <p class="text-xs font-semibold uppercase tracking-wide text-on-surface-muted dark:text-on-surface-dark-muted">
            {{ __('Theme') }}
        </p>

        <div class="flex flex-col gap-1">
            <button type="button"
                class="flex items-center justify-between gap-2 rounded-radius px-2 py-1 text-sm font-medium transition hover:bg-primary/5 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary/40 dark:hover:bg-primary-dark/5 dark:focus-visible:ring-primary-dark/40"
                x-bind:class="theme === 'light'
                    ? 'bg-primary/5 text-on-surface-strong dark:bg-primary-dark/5 dark:text-on-surface-dark-strong'
                    : 'text-on-surface dark:text-on-surface-dark'"
                role="menuitemradio" x-bind:aria-checked="theme === 'light'" x-on:click="updateTheme('light')">
                <div class="flex items-center gap-2">
                    <x-icons.sun variant="micro" size="sm" />
                    <span>{{ __('Light') }}</span>
                </div>
                <x-icons.check class="text-primary dark:text-primary-dark" variant="micro" size="sm"
                    x-cloak x-show="theme === 'light'" />
            </button>

            <button type="button"
                class="flex items-center justify-between gap-2 rounded-radius px-2 py-1 text-sm font-medium transition hover:bg-primary/5 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary/40 dark:hover:bg-primary-dark/5 dark:focus-visible:ring-primary-dark/40"
                x-bind:class="theme === 'dark'
                    ? 'bg-primary/5 text-on-surface-strong dark:bg-primary-dark/5 dark:text-on-surface-dark-strong'
                    : 'text-on-surface dark:text-on-surface-dark'"
                role="menuitemradio" x-bind:aria-checked="theme === 'dark'" x-on:click="updateTheme('dark')">
                <div class="flex items-center gap-2">
                    <x-icons.moon variant="micro" size="sm" />
                    <span>{{ __('Dark') }}</span>
                </div>
                <x-icons.check class="text-primary dark:text-primary-dark" variant="micro" size="sm"
                    x-cloak x-show="theme === 'dark'" />
            </button>

            <button type="button"
                class="flex items-center justify-between gap-2 rounded-radius px-2 py-1 text-sm font-medium transition hover:bg-primary/5 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary/40 dark:hover:bg-primary-dark/5 dark:focus-visible:ring-primary-dark/40"
                x-bind:class="theme === 'system'
                    ? 'bg-primary/5 text-on-surface-strong dark:bg-primary-dark/5 dark:text-on-surface-dark-strong'
                    : 'text-on-surface dark:text-on-surface-dark'"
                role="menuitemradio" x-bind:aria-checked="theme === 'system'" x-on:click="updateTheme('system')">
                <div class="flex items-center gap-2">
                    <x-icons.computer-desktop variant="micro" size="sm" />
                    <span>{{ __('System') }}</span>
                </div>
                <x-icons.check class="text-primary dark:text-primary-dark" variant="micro" size="sm"
                    x-cloak x-show="theme === 'system'" />
            </button>
        </div>
    </div>

    <!-- Logout Section -->
    <div class="flex flex-col py-1.5">
        <form method="POST" action="{{ route('logout') }}"
            class="flex items-center gap-2 px-2 py-1.5 text-sm font-medium text-on-surface underline-offset-2 hover:bg-primary/5 hover:text-on-surface-strong focus-visible:underline focus:outline-hidden dark:text-on-surface-dark dark:hover:bg-primary-dark/5 dark:hover:text-on-surface-dark-strong">
            @csrf
            <button type="submit" class="flex items-center gap-2" role="menuitem">
                <x-icons.arrow-right-start-on-rectangle variant="solid" size="md" />
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</div>
