@props([
    'variant' => 'default',
    'label' => 'notification'
])

@php
    $baseClasses = 'flex size-3 items-center justify-center rounded-full';
    
    $variants = [
        'default' => [
            'outer' => 'bg-on-surface dark:bg-on-surface-dark',
            'inner' => 'bg-on-surface dark:bg-on-surface-dark'
        ],
        'primary' => [
            'outer' => 'bg-primary dark:bg-primary-dark',
            'inner' => 'bg-primary dark:bg-primary-dark'
        ],
        'secondary' => [
            'outer' => 'bg-secondary dark:bg-secondary-dark',
            'inner' => 'bg-secondary dark:bg-secondary-dark'
        ],
        'info' => [
            'outer' => 'bg-info dark:bg-info',
            'inner' => 'bg-info dark:bg-info'
        ],
        'success' => [
            'outer' => 'bg-success dark:bg-success',
            'inner' => 'bg-success dark:bg-success'
        ],
        'warning' => [
            'outer' => 'bg-warning dark:bg-warning',
            'inner' => 'bg-warning dark:bg-warning'
        ],
        'danger' => [
            'outer' => 'bg-danger dark:bg-danger',
            'inner' => 'bg-danger dark:bg-danger'
        ],
    ];
    
    $outerClasses = $baseClasses . ' ' . ($variants[$variant]['outer'] ?? $variants['default']['outer']);
    $innerClasses = 'size-3 animate-ping rounded-full motion-reduce:animate-none ' . ($variants[$variant]['inner'] ?? $variants['default']['inner']);
@endphp

<span {{ $attributes->merge(['class' => $outerClasses]) }} aria-label="{{ $label }}">
    <span class="{{ $innerClasses }}"></span>
</span>
