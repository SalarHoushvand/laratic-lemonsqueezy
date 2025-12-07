@props([
    'id' => null,
    'expanded' => false, // initial state
])

@php
    $id = $id ?? 'accordion-' . \Illuminate\Support\Str::random(8);
@endphp

<div x-data="{ isExpanded: @js((bool) $expanded) }"
    {{ $attributes->class('overflow-hidden rounded-radius w-full border bg-surface-alt/40 dark:bg-surface-dark/50') }}
    x-bind:class="isExpanded
        ?
        'border-primary dark:border-primary-dark' :
        'border-outline dark:border-outline-dark'">
    <button id="controls-{{ $id }}" type="button"
        class="flex w-full items-center justify-between gap-2 bg-surface-alt p-4 text-left underline-offset-2 hover:bg-surface-alt/75 focus-visible:bg-surface-alt/75 focus-visible:underline focus-visible:outline-hidden dark:bg-surface-dark-alt/50 dark:hover:bg-surface-dark-alt/75 dark:focus-visible:bg-surface-dark/75"
        aria-controls="{{ $id }}" x-on:click="isExpanded = ! isExpanded"
        x-bind:class="isExpanded
            ?
            'text-on-surface-strong dark:text-on-surface-dark-strong font-bold' :
            'text-on-surface dark:text-on-surface-dark font-medium'"
        x-bind:aria-expanded="isExpanded">
        {{ $header ?? ($title ?? '') }}

        <x-icons.chevron-down size="md" stroke-width="2" class="shrink-0 transition"
            x-bind:class="isExpanded ? 'rotate-180' : ''" />
    </button>

    <div x-cloak x-show="isExpanded" id="{{ $id }}" role="region"
        aria-labelledby="controls-{{ $id }}" x-collapse>
        <div class="p-4 text-sm text-on-surface-muted dark:text-on-surface-dark-muted">
            {{ $content ?? $slot }}
        </div>
    </div>
</div>
