@props(['active'])

@php
    $classes =
        $active ?? false
            ? 'flex items-center gap-2 px-4 py-2 rounded-radius bg-surface-dark/10 font-medium text-xs md:text-sm pointer-events-none text-on-surface-strong underline-offset-2 focus:outline-hidden focus:underline dark:bg-surface/10 dark:text-on-surface-dark-strong'
            : 'flex items-center gap-2 px-4 py-2 rounded-radius hover:bg-surface-dark/10 font-medium text-xs md:text-sm text-on-surface underline-offset-2 hover:text-on-surface-strong focus:outline-hidden focus:underline dark:text-on-surface-dark dark:hover:bg-surface/10 dark:hover:text-on-surface-dark-strong';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
