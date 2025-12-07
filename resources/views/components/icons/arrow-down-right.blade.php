{{-- Credit: Heroicons (https://heroicons.com) --}}

@props([
    'variant' => 'outline',
    'size' => 'md',
    'ariaHidden' => 'true',
    'strokeWidth' => 1.5,
])

@php
    $sizes = [
        'xs' => 'size-3',
        'sm' => 'size-4',
        'md' => 'size-5',
        'lg' => 'size-6',
        'xl' => 'size-7',
    ];

    $sizeClass = array_key_exists($size, $sizes) ? $sizes[$size] : $size;
@endphp

@switch($variant)
    @case('outline')
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="{{ $strokeWidth }}"
            stroke="currentColor" {{ $attributes->class($sizeClass) }} aria-hidden="{{ $ariaHidden }}">
            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 4.5 15 15m0 0V8.25m0 11.25H8.25" />
        </svg>
    @break

    @case('solid')
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" {{ $attributes->class($sizeClass) }} aria-hidden="{{ $ariaHidden }}">
            <path fill-rule="evenodd" d="M3.97 3.97a.75.75 0 0 1 1.06 0l13.72 13.72V8.25a.75.75 0 0 1 1.5 0V19.5a.75.75 0 0 1-.75.75H8.25a.75.75 0 0 1 0-1.5h9.44L3.97 5.03a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/>
        </svg>
    @break

    @case('mini')
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" {{ $attributes->class($sizeClass) }}
            aria-hidden="{{ $ariaHidden }}">
            <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06l7.22 7.22H6.75a.75.75 0 0 0 0 1.5h7.5a.747.747 0 0 0 .75-.75v-7.5a.75.75 0 0 0-1.5 0v5.69L6.28 5.22Z"/>
        </svg>
    @break

    @case('micro')
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" {{ $attributes->class($sizeClass) }}
            aria-hidden="{{ $ariaHidden }}">
            <path fill-rule="evenodd" d="M4.22 4.22a.75.75 0 0 0 0 1.06l5.22 5.22H5.75a.75.75 0 0 0 0 1.5h5.5a.75.75 0 0 0 .75-.75v-5.5a.75.75 0 0 0-1.5 0v3.69L5.28 4.22a.75.75 0 0 0-1.06 0Z" clip-rule="evenodd"/>
        </svg>
    @break
@endswitch
