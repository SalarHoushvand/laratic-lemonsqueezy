<!-- Skip to main content link -->
<a class="sr-only" href="#main-content">{{ __('Skip to main content') }}</a>

<!-- Dark overlay -->
<div x-cloak x-show="showSidebar" x-on:click="showSidebar = false" x-transition.opacity
    class="fixed inset-0 z-10 backdrop-blur-xs bg-surface-dark/10 lg:hidden" aria-hidden="true"></div>

<!-- Sidebar Navigation -->
<nav x-cloak x-bind:class="showSidebar ? 'translate-x-0' : '-translate-x-60'"
    class="fixed left-0 top-0 z-20 flex h-dvh w-60 shrink-0 flex-col border-r border-outline bg-surface p-4 transition-transform duration-300 dark:border-outline-dark dark:bg-surface-dark lg:relative lg:h-full lg:w-64 lg:translate-x-0"
    aria-label="sidebar navigation">

    <!-- Mobile close button -->
    <button type="button" x-cloak x-on:click="showSidebar = false"
        class="mb-4 block w-fit whitespace-nowrap rounded-radius p-2 text-center text-sm font-medium tracking-wide text-on-surface hover:bg-primary/10 hover:opacity-75 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-surface-alt active:opacity-100 active:outline-offset-0 disabled:cursor-not-allowed disabled:opacity-75 dark:text-on-surface-dark-strong dark:hover:bg-primary-dark/10 dark:focus-visible:outline-surface-dark-alt lg:hidden">
        <x-icons.x-mark variant="outline" size="md" />
    </button>

    <!-- Brand Logo -->
    <div class="mb-4 flex items-center gap-2">
        <a href="{{ route('dashboard') }}" class="flex items-center">
            <x-app-logo class="w-20" />
        </a>

        @if (auth()->user()->subscribed('default'))
            <x-badge variant="primary" size="xs">
                {{ auth()->user()->currentPlanName() }}
            </x-badge>
        @endif
    </div>

    <!-- Platform Label -->
    <div class="px-1 py-2">
        <div class="text-xs leading-none text-on-surface dark:text-on-surface-dark">
            {{ __('Platform') }}
        </div>
    </div>

    <!-- Navigation Links -->
    <div class="flex h-full flex-col gap-2 overflow-y-auto pb-6">
        <!-- Main Navigation -->
        <ul class="flex flex-col gap-2">
            @if (auth()->user()->hasRole('admin'))
                <li>
                    <x-sidebar-link href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')">
                        <x-icons.chart-bar variant="outline" />
                        <span>{{ __('Admin Dashboard') }}</span>
                    </x-sidebar-link>
                </li>
            @endif

            <li>
                <x-sidebar-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                    <x-icons.home variant="outline" />
                    <span>{{ __('Dashboard') }}</span>
                </x-sidebar-link>
            </li>

            <li>
                <x-sidebar-link href="{{ route('ai.chat') }}" :active="request()->routeIs('ai.chat')">
                    <x-icons.robot variant="outline" />
                    <span>{{ __('AI Chat') }}</span>
                </x-sidebar-link>
            </li>

            <li>
                <x-sidebar-link href="{{ route('ai.simple') }}" :active="request()->routeIs('ai.simple')">
                    <x-icons.sparkles variant="outline" />
                    <span>{{ __('Simple AI Request') }}</span>
                </x-sidebar-link>
            </li>

            <li>
                <x-sidebar-link href="{{ route('products.index') }}" :active="request()->routeIs('products.index')">
                    <x-icons.building-storefront variant="outline" />
                    <span>{{ __('Marketplace') }}</span>
                </x-sidebar-link>
            </li>
        </ul>

        <!-- Bottom Navigation -->
        <ul class="mt-auto flex flex-col gap-2">
            <li>
                <x-sidebar-link href="{{ route('docs.show', 'getting-started') }}" :active="request()->routeIs('docs.show')">
                    <x-icons.book-open-text />
                    <span>{{ __('Documentation') }}</span>
                </x-sidebar-link>
            </li>
        </ul>
    </div>

    <!-- User Dropdown -->
    <x-dropdown align="bottom-14 left-0 lg:bottom-0 lg:left-full lg:ml-2" :width="'w-full'">
        <x-slot:trigger>
            <button type="button" x-bind:class="dropDownIsOpen ? 'bg-surface-dark/10 dark:bg-surface/10' : ''"
                class="flex w-full items-center gap-2 rounded-radius p-2 text-left text-on-surface hover:bg-surface-dark/10 hover:text-on-surface-strong focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary dark:text-on-surface-dark dark:hover:bg-surface/10 dark:hover:text-on-surface-dark-strong dark:focus-visible:outline-primary-dark">
                <x-profile-summary :user="auth()->user()" size="sm" :isLink="false" />
                <x-icons.chevron-right stroke-width="2" size="sm"
                    class="ml-auto shrink-0 -rotate-90 lg:rotate-0" />
            </button>
        </x-slot:trigger>

        <x-slot:content>
            <ul>
                <li class="border-b border-outline dark:border-outline-dark">
                    <div class="flex flex-col px-4 py-2">
                        <span class="text-sm font-medium text-on-surface-strong dark:text-on-surface-dark-strong">
                            {{ auth()->user()->name }}
                        </span>
                        <p class="text-xs text-on-surface dark:text-on-surface-dark">
                            {{ auth()->user()->email }}
                        </p>
                    </div>
                </li>
                <li>
                    <x-dropdown-link href="{{ route('subscription.manage') }}">
                        <x-icons.credit-card variant="mini" />
                        {{ __('Subscription') }}
                    </x-dropdown-link>
                </li>
                <li>
                    <x-dropdown-link href="{{ route('orders.index') }}">
                        <x-icons.shopping-cart variant="mini" />
                        {{ __('Orders') }}
                    </x-dropdown-link>
                </li>
                <li>
                    <x-dropdown-link href="{{ route('settings') }}">
                        <x-icons.cog variant="mini" />
                        {{ __('Settings') }}
                    </x-dropdown-link>
                </li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            <x-icons.arrow-right-start-on-rectangle variant="mini" />
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                </li>
            </ul>
        </x-slot:content>
    </x-dropdown>
</nav>
