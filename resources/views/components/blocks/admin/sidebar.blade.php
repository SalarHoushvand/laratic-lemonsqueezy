<!-- Skip to main content link -->
<a class="sr-only" href="#main-content">{{ __('Skip to main content') }}</a>

<!-- Dark overlay -->
<div x-cloak x-show="showSidebar" x-on:click="showSidebar = false" x-transition.opacity
    class="fixed inset-0 z-10 bg-surface-dark/10 backdrop-blur-xs lg:hidden" aria-hidden="true"></div>

<!-- Sidebar Navigation -->
<nav x-cloak x-bind:class="showSidebar ? 'translate-x-0' : '-translate-x-72'"
    class="fixed left-0 top-0 z-20 flex h-dvh w-60 shrink-0 flex-col border-r border-outline bg-surface p-4 transition-transform duration-300 lg:relative lg:h-full lg:w-64 lg:translate-x-0 dark:border-outline-dark dark:bg-surface-dark"
    aria-label="sidebar navigation">

    <!-- Mobile close button -->
    <button x-cloak x-on:click="showSidebar = false"
        class="block lg:hidden whitespace-nowrap w-fit mb-4 rounded-radius p-2 text-sm font-medium tracking-wide text-on-surface text-center hover:bg-primary/10 hover:opacity-75 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-surface-alt active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:hover:bg-primary-dark/10 dark:text-on-surface-dark-strong dark:focus-visible:outline-surface-dark-alt">
        <x-icons.x-mark variant="outline" size="md" />
    </button>

    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="mb-4 flex items-center space-x-2 lg:ml-0">
        <x-app-logo class="w-20" />
        <x-badge variant="primary">
            Admin
        </x-badge>
    </a>

    <!-- Platform Label -->
    <div class="px-1 py-2">
        <div class="text-xs leading-none text-on-surface dark:text-on-surface-dark">{{ __('Platform') }}</div>
    </div>

    <!-- Navigation Links -->
    <div class="flex flex-col gap-2 overflow-y-auto pb-6 h-full">
        <!-- Main Navigation -->
        <ul class="flex flex-col gap-2">
            <li>
                <x-sidebar-link href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')">
                    <x-icons.chart-bar variant="outline" />
                    <span>{{ __('Dashboard') }}</span>
                </x-sidebar-link>
            </li>

            <li>
                <x-sidebar-link href="{{ route('admin.users') }}" :active="request()->routeIs('admin.users')">
                    <x-icons.user-group variant="outline" />
                    <span>{{ __('Users') }}</span>
                </x-sidebar-link>
            </li>

            <li>
                <x-sidebar-link href="{{ route('admin.orders') }}" :active="request()->routeIs('admin.orders')">
                    <x-icons.shopping-cart variant="outline" />
                    <span>{{ __('Orders') }}</span>
                </x-sidebar-link>
            </li>

            <li>
                <x-sidebar-link href="{{ route('admin.ai-usage') }}" :active="request()->routeIs('admin.ai-usage')">
                    <x-icons.sparkles variant="outline" />
                    <span>{{ __('AI Usage') }}</span>
                </x-sidebar-link>
            </li>

            <li>
                <x-sidebar-link href="{{ route('admin.files.upload') }}" :active="request()->routeIs('admin.files.upload')">
                    <x-icons.paper-clip variant="outline" />
                    <span>{{ __('Upload Files') }}</span>
                </x-sidebar-link>
            </li>

            <li>
                <x-sidebar-link href="{{ route('admin.plans-products') }}" :active="request()->routeIs('admin.plans-products')">
                    <x-icons.credit-card variant="outline" />
                    <span>{{ __('Plans & Products') }}</span>
                </x-sidebar-link>
            </li>

            <!-- Collapsible Posts Item -->
            <li>
                <div x-data="{ isExpanded: {{ request()->routeIs('admin.posts.*') ? 'true' : 'false' }} }" class="flex flex-col">
                    <button type="button"
                        x-on:click="isExpanded = ! isExpanded"
                        id="posts-btn"
                        aria-controls="posts"
                        x-bind:aria-expanded="isExpanded ? 'true' : 'false'"
                        class="flex items-center gap-4 px-4 py-2 rounded-radius text-sm font-medium underline-offset-2 focus:outline-hidden focus:underline cursor-pointer"
                        x-bind:class="isExpanded
                            ? 'bg-surface-dark/5 text-on-surface-strong dark:bg-surface/5 dark:text-on-surface-dark-strong'
                            : 'text-on-surface hover:bg-surface-dark/10 hover:text-on-surface-strong dark:text-on-surface-dark dark:hover:bg-surface/10 dark:hover:text-on-surface-dark-strong'">
                        <x-icons.newspaper variant="outline" class="shrink-0" />
                        <span class="mr-auto text-left">{{ __('Posts') }}</span>
                        <x-icons.chevron-down variant="mini" size="md"
                            class="shrink-0 transition ml-auto"
                            x-bind:class="isExpanded ? 'rotate-180' : ''" />
                    </button>

                    <ul x-cloak x-collapse x-show="isExpanded" aria-labelledby="posts-btn" id="posts" class="mt-2 space-y-1">
                        <li>
                            <x-sidebar-link href="{{ route('admin.posts.index') }}" :active="request()->routeIs('admin.posts.index')">
                                <span>{{ __('Posts') }}</span>
                            </x-sidebar-link>
                        </li>
                        <li>
                            <x-sidebar-link href="{{ route('admin.posts.create') }}" :active="request()->routeIs('admin.posts.create')">
                                <span>{{ __('Create Post') }}</span>
                            </x-sidebar-link>
                        </li>
                        <li>
                            <x-sidebar-link
                                href="{{ request()->routeIs('admin.posts.edit') && request()->route('post') ? route('admin.posts.edit', request()->route('post')) : route('admin.posts.index') }}"
                                :active="request()->routeIs('admin.posts.edit')">
                                <span>{{ __('Edit Post') }}</span>
                            </x-sidebar-link>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>

        <!-- Bottom Navigation -->
        <ul class="flex flex-col gap-2 mt-auto">
            <li>
                <x-sidebar-link href="https://github.com" target="_blank">
                    <x-icons.folder-git-2 />
                    <span>{{ __('Repository') }}</span>
                </x-sidebar-link>
            </li>
            <li>
                <x-sidebar-link href="{{ route('docs.show', 'getting-started') }}">
                    <x-icons.book-open-text />
                    <span>{{ __('Documentation') }}</span>
                </x-sidebar-link>
            </li>
        </ul>
    </div>

    <!-- User Dropdown -->
    <x-dropdown align="bottom-14 left-0 lg:left-full lg:ml-2 lg:bottom-0">
        <x-slot:trigger>
            <button type="button" x-bind:class="dropDownIsOpen ? 'bg-surface-dark/10 dark:bg-surface/10' : ''"
                class="flex w-full items-center gap-2 rounded-radius p-2 text-left text-on-surface hover:bg-surface-dark/10 hover:text-on-surface-strong focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary dark:text-on-surface-dark dark:hover:bg-surface/10 dark:hover:text-on-surface-dark-strong dark:focus-visible:outline-primary-dark">
                <div class="flex items-center gap-3">
                    <x-profile-summary :user="auth()->user()" size="sm" :isLink="false" />
                </div>
                <x-icons.chevron-right strokeWidth="2" size="sm" class="ml-auto shrink-0 -rotate-90 lg:rotate-0" />
            </button>
        </x-slot:trigger>

        <x-slot:content>
            <ul>
                <li class="border-b border-outline dark:border-outline-dark">
                    <div class="flex flex-col px-4 py-2">
                        <span
                            class="text-sm font-medium text-on-surface-strong dark:text-on-surface-dark-strong">{{ auth()->user()->name }}</span>
                        <p class="text-xs text-on-surface dark:text-on-surface-dark">{{ auth()->user()->email }}</p>
                    </div>
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
