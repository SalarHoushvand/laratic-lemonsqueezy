@props([
    'variant' => 'primary',
    'size' => 'md',
    'href' => null,
])

@php
    // Base styles applied to all buttons
    $baseClasses = [
        'layout' => 'inline-flex justify-center items-center aspect-square whitespace-nowrap rounded-full',
        'typography' => 'text-center tracking-wide font-medium',
        'interaction' => 'transition hover:opacity-75',
        'focus' => 'focus-visible:outline-2 focus-visible:outline-offset-2',
        'active' => 'active:opacity-100 active:outline-offset-0',
        'disabled' => 'disabled:opacity-75 disabled:cursor-not-allowed',
    ];

    // Size variations - text size and icon size
    $sizes = [
        'sm' => [
            'text' => 'text-xs',
            'icon' => 'size-4',
            'padding' => 'p-2',
        ],
        'md' => [
            'text' => 'text-sm',
            'icon' => 'size-5',
            'padding' => 'p-2',
        ],
        'lg' => [
            'text' => 'text-base',
            'icon' => 'size-7',
            'padding' => 'p-2',
        ],
        'xl' => [
            'text' => 'text-lg',
            'icon' => 'size-8',
            'padding' => 'p-2',
        ],
        '2xl' => [
            'text' => 'text-2xl',
            'icon' => 'size-10',
            'padding' => 'p-2',
        ],
        '3xl' => [
            'text' => 'text-3xl',
            'icon' => 'size-12',
            'padding' => 'p-2',
        ],
    ];

    // Variant styles
    $variants = [
        'primary' => [
            'base' => 'border border-primary bg-primary text-on-primary',
            'dark' => 'dark:border-primary-dark dark:bg-primary-dark dark:text-on-primary-dark',
            'focus' => 'focus-visible:outline-primary dark:focus-visible:outline-primary-dark',
        ],
        'secondary' => [
            'base' => 'border border-secondary bg-secondary text-on-secondary',
            'dark' => 'dark:border-secondary-dark dark:bg-secondary-dark dark:text-on-secondary-dark',
            'focus' => 'focus-visible:outline-secondary dark:focus-visible:outline-secondary-dark',
        ],
        'alternate' => [
            'base' => 'border border-surface-alt bg-surface-alt text-on-surface-strong',
            'dark' => 'dark:border-surface-dark-alt dark:bg-surface-dark-alt dark:text-on-surface-dark-strong',
            'focus' => 'focus-visible:outline-surface-alt dark:focus-visible:outline-surface-dark-alt',
        ],
        'inverse' => [
            'base' => 'border border-surface-dark bg-surface-dark text-on-surface-dark',
            'dark' => 'dark:border-surface dark:bg-surface dark:text-on-surface',
            'focus' => 'focus-visible:outline-surface-dark dark:focus-visible:outline-surface',
        ],
        'info' => [
            'base' => 'border border-info bg-info text-on-info',
            'focus' => 'focus-visible:outline-info',
        ],
        'danger' => [
            'base' => 'border border-danger bg-danger text-on-danger',
            'focus' => 'focus-visible:outline-danger',
        ],
        'warning' => [
            'base' => 'border border-warning bg-warning text-on-warning',
            'focus' => 'focus-visible:outline-warning',
        ],
        'success' => [
            'base' => 'border border-success bg-success text-on-success',
            'focus' => 'focus-visible:outline-success',
        ],
    ];

    // Combine classes
    $variantClasses = collect($variants[$variant] ?? $variants['primary'])->implode(' ');
    $baseClassesString = collect($baseClasses)->implode(' ');
    $sizeData = $sizes[$size] ?? $sizes['md'];
    $sizeClasses = "{$sizeData['text']} {$sizeData['padding']}";

    $classes = "{$baseClassesString} {$variantClasses} {$sizeClasses}";
@endphp

@if ($href)
    <a {{ $attributes->merge(['href' => $href, 'class' => $classes]) }}>
        <svg
            aria-hidden="true"
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            class="{{ $sizeData['icon'] }} fill-current">
            <path
                fill-rule="evenodd"
                d="M12 3.75a.75.75 0 01.75.75v6.75h6.75a.75.75 0 010 1.5h-6.75v6.75a.75.75 0 01-1.5 0v-6.75H4.5a.75.75 0 010-1.5h6.75V4.5a.75.75 0 01.75-.75z"
                clip-rule="evenodd" />
        </svg>
    </a>
@else
    <button {{ $attributes->merge(['class' => $classes, 'type' => 'button']) }}>
        <svg
            aria-hidden="true"
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            class="{{ $sizeData['icon'] }} fill-current">
            <path
                fill-rule="evenodd"
                d="M12 3.75a.75.75 0 01.75.75v6.75h6.75a.75.75 0 010 1.5h-6.75v6.75a.75.75 0 01-1.5 0v-6.75H4.5a.75.75 0 010-1.5h6.75V4.5a.75.75 0 01.75-.75z"
                clip-rule="evenodd" />
        </svg>
    </button>
@endif