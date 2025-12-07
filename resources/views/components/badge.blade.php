@props([
    'variant' => 'default',
    'size' => 'xs'
])

@php
    $baseClasses = 'w-fit inline-flex items-center gap-2 rounded-radius font-medium whitespace-nowrap';

    $sizes = [
        'xxs' => 'px-1 py-0.5 text-[10px]',
        'xs' => 'px-1 py-0.5 text-xs',
        'sm' => 'px-1.5 py-0.5 text-sm',
        'md' => 'px-2 py-1 text-sm',
        'lg' => 'px-2.5 py-1.5 text-base',
    ];

    // Parse variant to extract style and color
    // Supports: 'primary', 'outline-primary', 'solid-primary', etc.
    $style = 'solid';
    $color = $variant;

    if (str_starts_with($variant, 'outline-')) {
        $style = 'outline';
        $color = substr($variant, 8); // Remove 'outline-' prefix
    } elseif (str_starts_with($variant, 'solid-')) {
        $style = 'solid';
        $color = substr($variant, 6); // Remove 'solid-' prefix
    }

    $variants = [
        'solid' => [
            'default' => 'border border-outline bg-surface-alt text-on-surface dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark',
            'primary' => 'border border-primary bg-primary text-on-primary dark:border-primary-dark dark:bg-primary-dark dark:text-on-primary-dark',
            'secondary' => 'border border-secondary bg-secondary text-on-secondary dark:border-secondary-dark dark:bg-secondary-dark dark:text-on-secondary-dark',
            'info' => 'border border-info bg-info text-on-info dark:border-info dark:bg-info dark:text-on-info',
            'success' => 'border border-success bg-success text-on-success dark:border-success dark:bg-success dark:text-on-success',
            'warning' => 'border border-warning bg-warning text-on-warning dark:border-warning dark:bg-warning dark:text-on-warning',
            'danger' => 'border border-danger bg-danger text-on-danger dark:border-danger dark:bg-danger dark:text-on-danger',
        ],
        'outline' => [
            'default' => 'border border-outline text-on-surface dark:border-outline-dark dark:text-on-surface-dark',
            'primary' => 'border border-primary bg-primary/10 dark:bg-primary-dark/10 text-primary dark:border-primary-dark dark:text-primary-dark',
            'secondary' => 'border border-secondary bg-secondary/10 dark:bg-secondary-dark/10 text-secondary dark:border-secondary-dark dark:text-secondary-dark',
            'info' => 'border border-info bg-info/10 text-info dark:border-info dark:text-info',
            'success' => 'border border-success bg-success/10 text-success dark:border-success dark:text-success',
            'warning' => 'border border-warning bg-warning/10 text-warning dark:border-warning dark:text-warning',
            'danger' => 'border border-danger bg-danger/10 text-danger dark:border-danger dark:text-danger',
        ],
    ];

    $classes = $baseClasses . ' ' . 
               ($sizes[$size]) . ' ' . 
               ($variants[$style][$color] ?? $variants[$style]['default']);
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</span>
