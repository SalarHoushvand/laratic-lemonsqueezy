@props([
    'items' => [],
    'model' => 'selectedTab',
    'ariaLabel' => 'tab options',
    'panelPrefix' => 'tabpanel-',
])

@php
    $container = 'relative flex gap-2 overflow-x-auto after:content-[""] after:absolute after:left-0 after:right-0 after:bottom-0 after:h-px after:bg-outline dark:after:bg-outline-dark';

    $tabBase = 'relative z-1 whitespace-nowrap flex h-min items-center gap-2 px-4 py-2 text-xs md:text-sm focus:outline-none cursor-pointer';

    $underlineBase = 'before:content-[""] before:absolute before:left-0 before:bottom-0 before:h-[1.5px] before:w-full before:origin-left before:transition-transform before:duration-300 before:ease-out';

    $tabSelected = 'font-bold text-primary dark:text-primary-dark before:bg-primary dark:before:bg-primary-dark before:scale-x-100';

    $tabUnselected = 'font-medium text-on-surface dark:text-on-surface-dark hover:text-on-surface-strong dark:hover:text-on-surface-dark-strong before:bg-primary dark:before:bg-primary-dark before:scale-x-0';
@endphp

<div
    x-on:keydown.right.prevent="$focus.wrap().next()"
    x-on:keydown.left.prevent="$focus.wrap().previous()"
    role="tablist"
    aria-label="{{ $ariaLabel }}"
    {{ $attributes->merge(['class' => $container]) }}
>
    @foreach ($items as $item)
        @php
            $slug = $item['slug'] ?? null;
            $label = $item['label'] ?? null;
            $icon = $item['icon'] ?? null;
        @endphp

        @continue(!$slug || !$label)

        <button
            type="button"
            role="tab"
            class="{{ $tabBase }} {{ $underlineBase }}"
            aria-controls="{{ $panelPrefix . $slug }}"
            x-on:click="{{ $model }} = '{{ $slug }}'"
            x-bind:aria-selected="{{ $model }} === '{{ $slug }}'"
            x-bind:tabindex="{{ $model }} === '{{ $slug }}' ? '0' : '-1'"
            x-bind:class="{{ $model }} === '{{ $slug }}' ? '{{ $tabSelected }}' : '{{ $tabUnselected }}'"
        >
            @if ($icon)
                <span class="hidden md:inline-flex">
                    <x-dynamic-component :component="$icon" variant="micro" size="sm" />
                </span>
            @endif

            {{ $label }}
        </button>
    @endforeach
</div>
