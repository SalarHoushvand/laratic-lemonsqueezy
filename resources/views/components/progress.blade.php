@props([
    'value' => 20,
    'min' => 0,
    'max' => 100,
    'label' => null,
    'showPercentage' => false,
    'variant' => 'primary',
])

@php
    $variantClasses = [
        'primary' => 'bg-primary dark:bg-primary-dark',
        'secondary' => 'bg-secondary dark:bg-secondary-dark',
        'success' => 'bg-success dark:bg-success-dark',
        'info' => 'bg-info dark:bg-info-dark',
        'warning' => 'bg-warning dark:bg-warning-dark',
        'danger' => 'bg-danger dark:bg-danger-dark',
    ];

    $barClass = $variantClasses[$variant] ?? $variantClasses['primary'];
@endphp

<div x-data="{ 
    currentVal: {{ $value }},
    minVal: {{ $min }},
    maxVal: {{ $max }},
    calcPercentage(min, max, val) {
        return (((val - min) / (max - min)) * 100).toFixed(0);
    }
}" {{ $attributes->class('w-full') }}>

    @if ($label || $showPercentage)
        <div class="mb-1 flex items-end justify-between gap-2 text-on-surface dark:text-on-surface-dark">
            @if ($label)
                <span>{{ $label }}</span>
            @endif
            
            @if ($showPercentage)
                <span x-text="`${calcPercentage(minVal, maxVal, currentVal)}%`"></span>
            @endif
        </div>
    @endif

    <div class="flex h-2.5 w-full overflow-hidden rounded-radius bg-surface-alt dark:bg-surface-dark-alt" 
        role="progressbar" 
        aria-label="{{ $label ?? 'progress bar' }}" 
        x-bind:aria-valuenow="currentVal" 
        x-bind:aria-valuemin="minVal" 
        x-bind:aria-valuemax="maxVal">
        <div class="h-full rounded-radius {{ $barClass }}" 
            x-bind:style="`width: ${calcPercentage(minVal, maxVal, currentVal)}%`">
        </div>
    </div>

</div>

