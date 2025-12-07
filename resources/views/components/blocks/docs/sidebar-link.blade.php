@props(['active'])

@php
    $baseClasses = 'flex items-center gap-2 px-4 py-2 rounded-radius font-medium text-sm underline-offset-2 focus:outline-hidden focus:underline';
    $activeClasses = 'bg-surface-dark/10 pointer-events-none text-on-surface-strong dark:bg-surface/10 dark:text-on-surface-dark-strong sidebar-link-active';
    $inactiveClasses = 'hover:bg-surface-dark/10 text-on-surface hover:text-on-surface-strong dark:text-on-surface-dark dark:hover:bg-surface/10 dark:hover:text-on-surface-dark-strong';
    
    $classes = $baseClasses . ' ' . ($active ?? false ? $activeClasses : $inactiveClasses);
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
