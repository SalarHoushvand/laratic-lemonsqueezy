@props(['active' => false])

@php
    $baseClasses = 'text-sm underline-offset-2 focus:outline-hidden focus:underline';
    
    $stateClasses = [
        'default' => 'text-on-surface hover:text-primary dark:text-on-surface-dark dark:hover:text-primary-dark',
        'active' => 'font-bold text-on-surface-strong hover:text-primary dark:text-on-surface-dark-strong dark:hover:text-primary-dark'
    ];

    $classes = $baseClasses . ' ' . ($active ? $stateClasses['active'] : $stateClasses['default']);
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
    @if ($active)
        <span class="sr-only">{{ __('Current Page') }}</span>
    @endif
</a>
