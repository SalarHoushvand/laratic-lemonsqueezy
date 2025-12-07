@props(['items'])

<!-- breadcrumbs -->
<nav class="hidden md:inline-block text-sm font-medium text-on-surface dark:text-on-surface-dark" aria-label="breadcrumb">
    <ol class="flex flex-wrap items-center gap-1">
        @foreach($items as $index => $item)
            <li class="flex items-center gap-1">
                @if($index !== array_key_last($items))
                    <a href="{{ $item['url'] }}" class="hover:text-on-surface-strong dark:hover:text-on-surface-dark-strong">
                        {{ __($item['label']) }}
                    </a>
                    <x-icons.chevron-right variant="outline" size="sm" />
                @else
                    <span class="font-bold text-on-surface-strong dark:text-on-surface-dark-strong" aria-current="page">
                        {{ __($item['label']) }}
                    </span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>