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
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9h16.5m-16.5 6.75h16.5" />
        </svg>
    @break

    @case('solid')
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" {{ $attributes->class($sizeClass) }} aria-hidden="{{ $ariaHidden }}">
            <path fill-rule="evenodd" d="M3 9a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 9Zm0 6.75a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd"/>
        </svg>
    @break

    @case('mini')
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" {{ $attributes->class($sizeClass) }}
            aria-hidden="{{ $ariaHidden }}">
            <path fill-rule="evenodd" d="M2 6.75A.75.75 0 0 1 2.75 6h14.5a.75.75 0 0 1 0 1.5H2.75A.75.75 0 0 1 2 6.75Zm0 6.5a.75.75 0 0 1 .75-.75h14.5a.75.75 0 0 1 0 1.5H2.75a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd"/>
        </svg>
    @break

    @case('micro')
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" {{ $attributes->class($sizeClass) }}
            aria-hidden="{{ $ariaHidden }}">
            <path fill-rule="evenodd" d="M2 4.75A.75.75 0 0 1 2.75 4h10.5a.75.75 0 0 1 0 1.5H2.75A.75.75 0 0 1 2 4.75Zm0 6.5a.75.75 0 0 1 .75-.75h10.5a.75.75 0 0 1 0 1.5H2.75a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd"/>
        </svg>
    @break
@endswitch
