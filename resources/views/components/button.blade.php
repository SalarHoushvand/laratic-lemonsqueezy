@props([
    'variant' => 'primary',
    'size' => 'md',
    'href' => null,
])

@php
    // Base styles applied to all buttons
    $baseClasses = [
        'layout' => 'flex w-fit items-center justify-center whitespace-nowrap gap-2',
        'typography' => 'text-center tracking-wide no-underline',
        'shape' => 'rounded-radius',
        'interaction' => 'cursor-pointer hover:opacity-75',
        'focus' => 'focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2',
        'active' => 'active:opacity-100 active:outline-offset-0',
        'disabled' => 'disabled:opacity-75 disabled:cursor-not-allowed',
    ];

    // Size variations
    $sizes = [
        'xs' => 'px-2 py-1 text-xs',
        'sm' => 'px-3 py-1.5 text-sm',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-6 py-2.5 text-base',
    ];

    // Variant styles
    $variants = [
        'primary' => [
            'base' => 'border bg-primary border-primary text-on-primary',
            'dark' => 'dark:bg-primary-dark dark:text-on-primary-dark dark:border-primary-dark',
            'focus' => 'focus-visible:outline-primary dark:focus-visible:outline-primary-dark',
        ],

        'secondary' => [
            'base' => 'whitespace-nowrap border border-secondary bg-secondary text-on-secondary',
            'dark' => 'dark:border-secondary-dark dark:bg-secondary-dark dark:text-on-secondary-dark',
            'focus' => 'focus-visible:outline-primary dark:focus-visible:outline-primary-dark',
        ],
        'alternative' => [
            'base' => 'whitespace-nowrap border border-surface-alt bg-surface-alt text-on-surface-strong',
            'dark' => 'dark:border-surface-dark-alt dark:bg-surface-dark-alt dark:text-on-surface-dark-strong',
            'focus' => 'focus-visible:outline-surface-alt dark:focus-visible:outline-surface-dark-alt',
        ],
        'inverse' => [
            'base' => 'whitespace-nowrap border border-surface-dark bg-surface-dark text-on-surface-dark',
            'dark' => 'dark:border-surface dark:bg-surface dark:text-on-surface',
            'focus' => 'focus-visible:outline-surface-dark dark:focus-visible:outline-surface',
        ],
        'outline' => [
            'base' => 'whitespace-nowrap border border-on-surface bg-transparent text-on-surface font-medium',
            'dark' => 'dark:border-on-surface-dark dark:text-on-surface-dark',
            'focus' => 'focus-visible:outline-on-surface dark:focus-visible:outline-on-surface-dark',
        ],
        'outline-primary' => [
            'base' => 'whitespace-nowrap border border-primary bg-transparent text-primary font-medium',
            'dark' => 'dark:border-primary-dark dark:text-primary-dark',
            'focus' => 'focus-visible:outline-primary dark:focus-visible:outline-primary-dark',
        ],
        'outline-secondary' => [
            'base' => 'whitespace-nowrap border border-secondary bg-transparent text-secondary font-medium',
            'dark' => 'dark:border-secondary-dark dark:text-secondary-dark',
            'focus' => 'focus-visible:outline-secondary dark:focus-visible:outline-secondary-dark',
        ],
        'ghost' => [
            'base' => 'whitespace-nowrap bg-transparent text-on-surface font-medium',
            'dark' => 'dark:text-on-surface-dark',
            'focus' => 'focus-visible:outline-on-surface dark:focus-visible:outline-on-surface-dark',
        ],
        'info' => [
            'base' => 'border bg-info border-info text-on-info',
            'focus' => 'focus-visible:outline-info',
        ],
        'outline-info' => [
            'base' => 'whitespace-nowrap border border-info bg-transparent text-info font-medium',
            'dark' => 'dark:border-info-dark dark:text-info-dark',
            'focus' => 'focus-visible:outline-info dark:focus-visible:outline-info-dark',
        ],
        'danger' => [
            'base' => 'border bg-danger border-danger text-on-danger',
            'focus' => 'focus-visible:outline-danger',
        ],
        'outline-danger' => [
            'base' => 'whitespace-nowrap border border-danger bg-transparent text-danger font-medium',
            'dark' => 'dark:border-danger-dark dark:text-danger-dark',
            'focus' => 'focus-visible:outline-danger dark:focus-visible:outline-danger-dark',
        ],
        'success' => [
            'base' => 'border bg-success border-success text-on-success',
            'focus' => 'focus-visible:outline-success',
        ],
        'outline-success' => [
            'base' => 'whitespace-nowrap border border-success bg-transparent text-success font-medium',
            'dark' => 'dark:border-success-dark dark:text-success-dark',
            'focus' => 'focus-visible:outline-success dark:focus-visible:outline-success-dark',
        ],
        'warning' => [
            'base' => 'border bg-warning border-warning text-on-warning',
            'focus' => 'focus-visible:outline-warning',
        ],
        'outline-warning' => [
            'base' => 'whitespace-nowrap border border-warning bg-transparent text-warning font-medium',
            'dark' => 'dark:border-warning-dark dark:text-warning-dark',
            'focus' => 'focus-visible:outline-warning dark:focus-visible:outline-warning-dark',
        ],
    ];

    // Combine classes
    $variantClasses = collect($variants[$variant] ?? $variants['primary'])->implode(' ');
    $baseClassesString = collect($baseClasses)->implode(' ');
    $sizeClasses = $sizes[$size] ?? $sizes['md'];

    $classes = "{$baseClassesString} {$variantClasses} {$sizeClasses}";
@endphp

@if ($href)
    <a {{ $attributes->merge(['href' => $href, 'class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
