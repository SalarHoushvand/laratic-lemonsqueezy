@props(['breadcrumbs' => null, 'hasBanner' => true])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scheme-light dark:scheme-dark font-body" data-theme="{{ config('app.theme') }}">

<head>
    @include('partials.head')
    @stack('head')
    {{-- highlight.js is bundled locally via Vite in resources/js/app.js --}}
    @vite(['resources/js/docs.js'])
</head>

<body x-data x-cloak data-copy-title="{{ __('Copy') }}" data-copy-aria="{{ __('Copy') }}"
    data-copy-sr="{{ __('Copy the response to clipboard') }}"
    class="relative flex h-dvh flex-col overscroll-none bg-surface dark:bg-surface-dark text-on-surface dark:text-on-surface-dark overflow-hidden">


    @if ($hasBanner)
        {{-- Banner Goes Here --}}
    @endif

    {{-- Main docs shell: sidebar + content, fills remaining viewport --}}
    <div class="flex flex-1 min-h-0 overflow-hidden">
        <x-blocks.docs.sidebar :breadcrumbs="$breadcrumbs">
            <div role="main"
                class="
                    max-w-3xl
                    min-w-0
                    p-2 md:p-6
                    docs-content
                    prose
                    prose-sm
                    sm:prose-base
                    dark:prose-invert
                    leading-relaxed
                    break-words
                    prose-table:block
                    prose-table:max-w-full
                    prose-table:overflow-x-auto
                    prose-table:w-max
                    prose-table:min-w-full
                    prose-pre:text-sm
                    prose-pre:p-2
                    font-body
                    prose-pre:bg-surface-dark-alt
                    prose-pre:rounded-radius
                    prose-pre:border-none
                    prose-headings:font-title
                    prose-headings:font-medium
                    prose-headings:text-on-surface-strong
                    prose-headings:dark:text-on-surface-dark-strong
                    prose-pre:shadow-none
                    prose-code:bg-transparent!
                    prose-img:rounded-radius
                    prose-img:border-outline
                    prose-img:border
                    prose-img:dark:border-outline-dark
                ">
                {{ $slot }}
            </div>

            {{-- On this page / quick reference --}}
            <div
                class="h-[80svh] absolute right-0 top-16 z-0 hidden w-64 shrink-0 flex-col gap-2 overflow-y-auto p-8 pl-0 text-sm xl:flex">
                <p class="mb-4 font-bold text-onSurfaceStrong dark:text-onSurfaceDarkStrong">
                    {{ __('On this page') }}
                </p>
                <div id="quickRefContainer"></div>
            </div>
        </x-blocks.docs.sidebar>
    </div>

    <x-notification />
    <!-- Scripts -->
    @include('partials.scripts')
    @stack('scripts')
</body>

</html>
