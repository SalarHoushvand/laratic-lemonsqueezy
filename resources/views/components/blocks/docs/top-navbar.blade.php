@props(['breadcrumbs' => null])

<!-- Top Navigation Bar -->
<nav class="sticky top-0 z-10 flex items-center justify-between border-b border-outline bg-surface-alt px-4 py-2.5 dark:border-outline-dark dark:bg-surface-dark-alt"
    aria-label="{{ __('Top Navigation Bar') }}">
    <!-- Sidebar Toggle Button (Mobile) -->
    <button type="button" x-on:click="sidebarIsOpen = true"
        class="inline-block text-on-surface dark:text-on-surface-dark md:hidden">
        <x-icons.bars-3 variant="outline" size="lg" stroke-width="2" />
        <span class="sr-only">{{ __('Toggle Sidebar') }}</span>
    </button>

    @if ($breadcrumbs)
        <!-- Breadcrumbs -->
        <x-breadcrumb :items="$breadcrumbs" />
    @endif

    <div class="flex items-center ml-auto gap-4">
        <!-- Language Selector -->
        <livewire:language-selector />
        <!-- Profile Menu -->
        <div x-data="{ userDropdownIsOpen: false }" x-on:keydown.esc.window="userDropdownIsOpen = false" class="relative">
            @auth
                @php($user = auth()->user())
                <x-button variant="ghost" size="sm" title="{{ __('User Menu') }}" aria-haspopup="true" class="p-0!"
                    x-on:click="userDropdownIsOpen = ! userDropdownIsOpen" x-bind:aria-expanded="userDropdownIsOpen">
                    <x-avatar size="md" :img="$user->avatar" :fallback="$user->initials()" :alt="$user->name ?? __('User Avatar')"
                        class="pointer-events-none" />
                </x-button>
            @else
                <x-button variant="ghost" size="xs" class="hidden md:block" href="{{ route('login') }}">
                    {{ __('Sign In') }}
                </x-button>
                <x-button variant="ghost" size="xs" class="block md:hidden" href="{{ route('login') }}">
                    {{ __('Sign In') }}
                </x-button>
            @endauth
            <!-- User Menu Dropdown -->
            <x-blocks.navbar-user-menu />
        </div>


    </div>
</nav>
