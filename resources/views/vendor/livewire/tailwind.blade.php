@php
if (! isset($scrollTo)) {
    $scrollTo = 'body';
}

$scrollIntoViewJsSnippet = ($scrollTo !== false)
    ? <<<JS
       (\$el.closest('{$scrollTo}') || document.querySelector('{$scrollTo}')).scrollIntoView()
    JS
    : '';
@endphp

<div>
    @if ($paginator->hasPages())
        <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between">
            <!-- Mobile Pagination -->
            <div class="flex flex-1 justify-between sm:hidden">
                @if ($paginator->onFirstPage())
                    <span class="bg-surface-alt border border-outline cursor-default dark:bg-surface-dark dark:border-outline-dark dark:text-on-surface-dark-strong font-medium inline-flex items-center leading-5 px-4 py-2 relative rounded-radius text-on-surface-strong text-sm">
                        {!! __('pagination.previous') !!}
                    </span>
                @else
                    <button wire:click="previousPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" class="active:bg-surface active:outline-offset-0 active:text-on-surface bg-surface-alt border border-outline dark:active:bg-surface-dark dark:bg-surface-dark dark:border-outline-dark dark:focus-visible:outline-primary-dark dark:text-on-surface-dark dark:hover:text-on-surface-dark-strong focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary font-medium hover:text-on-surface-strong inline-flex items-center leading-5 px-4 py-2 relative rounded-radius text-on-surface text-sm transition">
                        {!! __('pagination.previous') !!}
                    </button>
                @endif

                @if ($paginator->hasMorePages())
                    <button wire:click="nextPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" class="active:bg-surface active:outline-offset-0 active:text-on-surface bg-surface-alt border border-outline dark:active:bg-surface-dark dark:bg-surface-dark dark:border-outline-dark dark:focus-visible:outline-primary-dark dark:text-on-surface-dark dark:hover:text-on-surface-dark-strong focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary font-medium hover:text-on-surface-strong inline-flex items-center leading-5 ml-3 px-4 py-2 relative rounded-radius text-on-surface text-sm transition">
                        {!! __('pagination.next') !!}
                    </button>
                @else
                    <span class="bg-surface-alt border border-outline cursor-default dark:bg-surface-dark dark:border-outline-dark dark:text-on-surface-dark-strong font-medium inline-flex items-center leading-5 ml-3 px-4 py-2 relative rounded-radius text-on-surface-strong text-sm">
                        {!! __('pagination.next') !!}
                    </span>
                @endif
            </div>

            <!-- Desktop Pagination -->
            <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
                <div>
                    <p class="dark:text-on-surface-dark leading-5 text-on-surface text-sm">
                        {!! __('Showing') !!}
                        <span class="font-medium">{{ $paginator->firstItem() }}</span>
                        {!! __('to') !!}
                        <span class="font-medium">{{ $paginator->lastItem() }}</span>
                        {!! __('of') !!}
                        <span class="font-medium">{{ $paginator->total() }}</span>
                        {!! __('results') !!}
                    </p>
                </div>

                <div>
                    <span class="relative z-0 inline-flex rounded-radius rtl:flex-row-reverse">
                        {{-- Previous Page Link --}}
                        @if ($paginator->onFirstPage())
                            <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                                <span class="bg-surface-alt border border-outline cursor-default dark:bg-surface-dark dark:border-outline-dark dark:text-on-surface-dark-strong font-medium inline-flex items-center leading-5 px-2 py-2 relative rounded-l-radius text-on-surface-strong text-sm" aria-hidden="true">
                                    <svg class="size-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </span>
                        @else
                            <button wire:click="previousPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" class="active:bg-surface active:outline-offset-0 active:text-on-surface bg-surface-alt border border-outline dark:active:bg-surface-dark dark:bg-surface-dark dark:border-outline-dark dark:focus-visible:outline-primary-dark dark:text-on-surface-dark dark:hover:text-on-surface-dark-strong focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary font-medium hover:text-on-surface-strong inline-flex items-center leading-5 px-2 py-2 relative rounded-l-radius text-on-surface text-sm transition z-10" aria-label="{{ __('pagination.previous') }}">
                                <svg class="size-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($elements as $element)
                            {{-- "Three Dots" Separator --}}
                            @if (is_string($element))
                                <span aria-disabled="true">
                                    <span class="bg-surface-alt border border-outline cursor-default dark:bg-surface-dark dark:border-outline-dark dark:text-on-surface-dark-strong font-medium inline-flex items-center leading-5 -ml-px px-4 py-2 relative text-on-surface-strong text-sm">{{ $element }}</span>
                                </span>
                            @endif

                            {{-- Array Of Links --}}
                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    <span wire:key="paginator-{{ $paginator->getPageName() }}-page{{ $page }}">
                                        @if ($page == $paginator->currentPage())
                                            <span aria-current="page">
                                                <span class="bg-primary border border-primary cursor-default dark:bg-primary-dark dark:border-primary-dark dark:text-on-primary-dark font-medium inline-flex items-center leading-5 -ml-px px-4 py-2 relative text-on-primary text-sm">{{ $page }}</span>
                                            </span>
                                        @else
                                            <button wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" class="active:bg-surface active:outline-offset-0 active:text-on-surface bg-surface-alt border border-outline dark:active:bg-surface-dark dark:bg-surface-dark dark:border-outline-dark dark:focus-visible:outline-primary-dark dark:text-on-surface-dark dark:hover:text-on-surface-dark-strong focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary font-medium hover:text-on-surface-strong inline-flex items-center leading-5 -ml-px px-4 py-2 relative text-on-surface text-sm transition z-10">
                                                {{ $page }}
                                            </button>
                                        @endif
                                    </span>
                                @endforeach
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($paginator->hasMorePages())
                            <button wire:click="nextPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" class="active:bg-surface active:outline-offset-0 active:text-on-surface bg-surface-alt border border-outline dark:active:bg-surface-dark dark:bg-surface-dark dark:border-outline-dark dark:focus-visible:outline-primary-dark dark:text-on-surface-dark dark:hover:text-on-surface-dark-strong focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary font-medium hover:text-on-surface-strong inline-flex items-center leading-5 -ml-px px-2 py-2 relative rounded-r-radius text-on-surface text-sm transition z-10" aria-label="{{ __('pagination.next') }}">
                                <svg class="size-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        @else
                            <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                                <span class="bg-surface-alt border border-outline cursor-default dark:bg-surface-dark dark:border-outline-dark dark:text-on-surface-dark-strong font-medium inline-flex items-center leading-5 -ml-px px-2 py-2 relative rounded-r-radius text-on-surface-strong text-sm" aria-hidden="true">
                                    <svg class="size-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </span>
                        @endif
                    </span>
                </div>
            </div>
        </nav>
    @endif
</div>
