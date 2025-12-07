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
            <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
        </svg>
    @break

    @case('solid')
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" {{ $attributes->class($sizeClass) }} aria-hidden="{{ $ariaHidden }}">
            <path fill-rule="evenodd" d="M16.72 7.72a.75.75 0 0 1 1.06 0l3.75 3.75a.75.75 0 0 1 0 1.06l-3.75 3.75a.75.75 0 1 1-1.06-1.06l2.47-2.47H3a.75.75 0 0 1 0-1.5h16.19l-2.47-2.47a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/>
        </svg>
    @break

    @case('mini')
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" {{ $attributes->class($sizeClass) }}
            aria-hidden="{{ $ariaHidden }}">
            <path fill-rule="evenodd" d="M2 10a.75.75 0 0 1 .75-.75h12.59l-2.1-1.95a.75.75 0 1 1 1.02-1.1l3.5 3.25a.75.75 0 0 1 0 1.1l-3.5 3.25a.75.75 0 1 1-1.02-1.1l2.1-1.95H2.75A.75.75 0 0 1 2 10Z" clip-rule="evenodd"/>
        </svg>
    @break

    @case('micro')
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" {{ $attributes->class($sizeClass) }}
            aria-hidden="{{ $ariaHidden }}">
            <path fill-rule="evenodd" d="M2 8c0 .414.336.75.75.75h8.69l-1.22 1.22a.75.75 0 1 0 1.06 1.06l2.5-2.5a.75.75 0 0 0 0-1.06l-2.5-2.5a.75.75 0 1 0-1.06 1.06l1.22 1.22H2.75A.75.75 0 0 0 2 8Z" clip-rule="evenodd"/>
        </svg>
    @break
@endswitch
