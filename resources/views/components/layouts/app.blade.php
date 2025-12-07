@props(['sidebar' => true, 'padding' => true, 'subscribeBanner' => true])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scheme-light dark:scheme-dark font-body" data-theme="{{ config('app.theme') }}">

<head>
    @include('partials.head')
    @stack('head')
    @lemonJS
    @livewireStyles
</head>

<body x-data x-cloak
    class="relative flex h-dvh flex-col bg-surface dark:bg-surface-dark-alt text-on-surface dark:text-on-surface-dark overflow-hidden">

    <!-- Skip to main content link -->
    <a class="sr-only" href="#main-content">{{ __('Skip to main content') }}</a>

    {{-- Global subscribe banner – does NOT change viewport height --}}
    @if (!auth()->user()->subscribed()
        && !request()->routeIs(['plans.start', 'plans.show', 'subscription.pending'])
        && $subscribeBanner)
        <x-blocks.plans.subscribe-banner class="shrink-0" />
    @endif

    <div x-data="{ showSidebar: false }"
         class="relative flex flex-1 min-h-0 w-full overflow-hidden flex-col lg:flex-row bg-surface dark:bg-surface-dark-alt">

        @if ($sidebar)
            <x-blocks.app.sidebar />
        @endif

        <!-- Main Content Shell -->
        <div id="main-content"
             class="flex h-full w-full flex-col bg-surface dark:bg-surface-dark">

            @if ($sidebar)
                <!-- Mobile Header -->
                <div
                    class="lg:hidden px-8 py-2 flex items-center justify-between z-5 shrink-0 sticky top-0 bg-surface-alt dark:bg-surface-dark-alt border-b border-outline dark:border-outline-dark">
                    <button x-cloak x-on:click="showSidebar = ! showSidebar"
                        class="whitespace-nowrap rounded-radius p-2 text-sm font-medium tracking-wide text-on-surface text-center hover:bg-primary/10 hover:opacity-75 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-surface-alt active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:hover:bg-primary-dark/10 dark:text-on-surface-dark-strong dark:focus-visible:outline-surface-dark-alt">
                        <x-icons.bars-3 x-cloak variant="outline" stroke-width="2" size="lg" />
                    </button>

                    <!-- Mobile Dropdown -->
                    <x-dropdown align="right">
                        <x-slot:trigger>
                            <button
                                class="rounded-radius cursor-pointer bg-transparent hover:bg-surface-alt dark:hover:bg-surface/10 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary dark:focus-visible:outline-primary-dark"
                                aria-controls="userMenu">
                                <div class="flex items-center p-0.5">
                                    <span
                                        class="flex size-8 text-sm font-medium items-center justify-center overflow-hidden rounded-radius border border-outline bg-surface-alt tracking-wider text-on-surface/80 dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark/80">
                                        {{ auth()->user()->initials() }}
                                    </span>
                                    <div class="p-1 text-on-surface-strong dark:text-on-surface-dark-strong">
                                        <x-icons.chevron-down variant="micro" size="sm" />
                                    </div>
                                </div>
                            </button>
                        </x-slot:trigger>

                        <x-slot:content>
                            <ul>
                                <li class="border-b border-outline dark:border-outline-dark">
                                    <div class="flex flex-col px-4 py-2">
                                        <span
                                            class="text-sm font-medium text-on-surface-strong dark:text-on-surface-dark-strong">
                                            {{ auth()->user()->name }}
                                        </span>
                                        <p class="text-xs text-on-surface dark:text-on-surface-dark">
                                            {{ auth()->user()->email }}
                                        </p>
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
                </div>
            @endif

            <!-- Scrollable content area -->
            <div class="flex-1 min-h-0 overflow-y-auto overscroll-contain">
                <div class="flex flex-col h-full">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>

    <x-notification />
    @include('partials.scripts')
    @stack('scripts')
    @livewireScripts
</body>

</html>
