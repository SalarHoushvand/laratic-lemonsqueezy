@props(['hasBanner' => true])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scheme-light dark:scheme-dark scroll-smooth font-body" data-theme="{{ config('app.theme') }}">

<head>
    @include('partials.head')
    @stack('head')
    @lemonJS
    @livewireStyles
</head>

<body x-cloak x-data
    class="relative min-h-svh overscroll-none bg-surface dark:bg-surface-dark text-on-surface dark:text-on-surface-dark overflow-x-hidden">

    @if ($hasBanner)
        {{-- Banner Goes Here --}}
    @endif

    <!-- Top Navigation -->
    <x-blocks.guest.top-navbar />

    <!-- Main Content Wrapper -->

    <main role="main">
        {{ $slot }}
    </main>


    <!-- Footer -->
    <x-blocks.guest.footer />

    <!-- Display toast notifications -->
    <x-notification />

    <x-blocks.cookie-banner />

    <!-- Scripts -->
    @include('partials.scripts')
    @stack('scripts')
    @livewireScripts
</body>

</html>
