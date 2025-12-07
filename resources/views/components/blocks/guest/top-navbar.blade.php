@props(['searchable' => false])

<nav x-data="{ mobileMenuIsOpen: false }" aria-label="top navbar"
    class="sticky top-0 z-30 py-3 border-b backdrop-blur-md bg-surface-alt/50 border-outline dark:border-outline-dark dark:bg-surface-dark-alt/50">
    <div class="flex items-center justify-between mx-auto px-6 max-w-7xl 2xl:max-w-7xl">
        <!-- Brand Logo -->
        <a href="{{ route('home') }}" class="inline-flex">
            <x-app-logo class="w-32" />
            <span class="sr-only">{{ __('Home') }}</span>
        </a>

        <!-- Desktop Menu Items -->
        <ul class="flex items-center gap-4 ml-auto">
            <li class="hidden md:block">
                <x-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">
                    {{ __('Home') }}
                </x-nav-link>
            </li>
            <li class="hidden md:block">
                <x-nav-link href="{{ route('home') }}#features">{{ __('Features') }}</x-nav-link>
            </li>
            <li class="hidden md:block">
                <x-nav-link href="{{ route('pricing') }}">{{ __('Pricing') }}</x-nav-link>
            </li>
            <li class="hidden md:block">
                <x-nav-link href="{{ route('blog') }}">{{ __('Blog') }}</x-nav-link>
            </li>
            <li class="hidden md:block">
                <x-nav-link href="{{ route('docs.show', 'installation') }}">{{ __('Docs') }}</x-nav-link>
            </li>

            <!-- Search Button -->
            @if ($searchable)
                <li>
                    <x-button variant="outline" size="xs" title="Search">
                        <x-icons.magnifying-glass size="sm" />
                    </x-button>
                </li>
            @endif

            <!-- CTA Button -->
            <li>
                @auth
                    <div x-data="{ userDropdownIsOpen: false }" class="relative">
                        @php($user = auth()->user())
                        <x-button variant="ghost" size="sm" aria-haspopup="true" class="p-0!"
                            x-on:click="userDropdownIsOpen = ! userDropdownIsOpen"
                            x-bind:aria-expanded="userDropdownIsOpen">
                            <x-avatar size="md" :img="$user->avatar" :fallback="$user->initials()" :alt="$user->name ?? __('User Avatar')"
                                class="pointer-events-none" />
                        </x-button>
                        <x-blocks.navbar-user-menu />
                    </div>
                @else
                    <x-button variant="primary" size="xs" href="{{ route('register') }}" class="hidden md:block">
                        {{ __('Get Started for Free') }}
                    </x-button>
                @endauth
            </li>
            @if (count(config('languages', [])) > 1 && !request()->routeIs('posts.show'))
                <li>
                    <livewire:language-selector />
                </li>
            @endif
        </ul>

        <!-- Mobile Menu Button -->
        <button type="button" aria-label="mobile menu" aria-controls="mobileMenu"
            x-on:click="mobileMenuIsOpen = !mobileMenuIsOpen" x-bind:aria-expanded="mobileMenuIsOpen"
            class="flex pl-4 md:hidden text-on-surface dark:text-on-surface-dark">
            <x-icons.bars-3 variant="outline" size="lg" stroke-width="2" />
        </button>
        <!-- Mobile Menu Overlay -->
        <div x-trap.noscroll="mobileMenuIsOpen" x-cloak x-show="mobileMenuIsOpen" x-transition
            class="fixed inset-0 z-10 flex flex-col h-svh overflow-y-auto md:hidden 
            rounded-b-radius border-b backdrop-blur-md bg-surface-alt dark:bg-surface-dark 
            border-outline dark:border-outline-dark">

            <!-- Mobile Header -->
            <div
                class="flex items-center justify-between w-full p-6 border-b border-outline/30 dark:border-outline-dark/30">
                <a href="{{ route('home') }}"
                    class="mr-auto focus:outline-none focus-visible:outline-none focus:border-none focus:ring-0">
                    <x-app-logo class="w-28" />
                    <span class="sr-only">{{ __('Home') }}</span>
                </a>
                <button x-on:click="mobileMenuIsOpen = false" aria-label="Close menu">
                    <x-icons.x-mark variant="outline" size="xl" />
                    <span class="sr-only">{{ __('Close Menu') }}</span>
                </button>
            </div>

            <!-- Top CTA -->
            <div class="p-6">
                <x-button variant="primary" size="md" href="{{ route('register') }}" class="w-full">
                    {{ __('Get Started') }} <x-icons.arrow-right size="sm" />
                </x-button>
            </div>

            <!-- Mobile Menu Items -->
            <ul class="flex flex-col gap-4 px-6 pb-28 text-left">
                <li>
                    <a href="{{ route('pricing') }}" class="block text-lg font-semibold hover:text-primary">
                        {{ __('Pricing') }}
                    </a>
                </li>

                <li>
                    <a href="{{ route('blog') }}" class="block text-lg font-semibold hover:text-primary">
                        {{ __('Blog') }}
                    </a>
                </li>

                <li>
                    <a href="{{ route('docs.show', 'installation') }}"
                        class="block text-lg font-semibold hover:text-primary">
                        {{ __('Docs') }}
                    </a>
                </li>

                <li>
                    <a href="{{ route('about-us') }}" class="block text-lg font-semibold hover:text-primary">
                        {{ __('About Us') }}
                    </a>
                </li>

                <li>
                    <a href="{{ route('contact') }}" class="block text-lg font-semibold hover:text-primary">
                        {{ __('Contact Us') }}
                    </a>
                </li>
            </ul>

            <!-- Sticky Footer CTA -->
            <div
                class="fixed inset-x-0 bottom-0 p-6 bg-surface-alt/95 dark:bg-surface-dark/95 backdrop-blur border-t border-outline dark:border-outline-dark">
                <x-button variant="primary" size="md" href="{{ route('login') }}" class="w-full">
                    {{ __('Sign In') }}
                </x-button>
            </div>
        </div>
        <!-- / Mobile Menu Overlay -->
    </div>
</nav>
