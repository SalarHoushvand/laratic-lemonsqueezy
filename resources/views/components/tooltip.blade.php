@props([
    'position' => 'top', // top, bottom, left, right
    'text' => '',
    'id' => 'tooltip-' . uniqid(),
])

@php
    $tooltipPositionClasses = [
        'top' => '-top-9 left-1/2 -translate-x-1/2',
        'bottom' => '-bottom-9 left-1/2 -translate-x-1/2',
        'left' => 'top-1/2 right-full -translate-y-1/2 mr-2',
        'right' => 'top-1/2 left-full -translate-y-1/2 ml-2',
    ];

    $baseTriggerClasses = 'peer';

    $baseTooltipClasses =
        'absolute z-10 whitespace-nowrap rounded-sm bg-surface-dark px-2 py-1 text-center text-xs text-on-surface-dark-strong opacity-0 pointer-events-none transition-all ease-out peer-hover:opacity-100 peer-focus:opacity-100 dark:bg-surface dark:text-on-surface-strong';
@endphp

<div class="relative w-fit">
    <div {{ $attributes->merge(['class' => $baseTriggerClasses]) }} aria-describedby="{{ $id }}">
        {{ $slot }}
    </div>

    <div id="{{ $id }}" class="{{ $baseTooltipClasses }} {{ $tooltipPositionClasses[$position] }}"
        role="tooltip">
        {{ $text }}
    </div>
</div>
