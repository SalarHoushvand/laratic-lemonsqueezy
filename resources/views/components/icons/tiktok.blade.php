<!-- Credit: Bootstrap Icons (https://icons.getbootstrap.com) -->
@props(['size' => 'md', 'ariaHidden' => 'true'])
@php
    $sizes = ['xs' => 'size-3', 'sm' => 'size-4', 'md' => 'size-5', 'lg' => 'size-6', 'xl' => 'size-7'];
    $sizeClass = array_key_exists($size, $sizes) ? $sizes[$size] : $size;
@endphp
<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16" {{ $attributes->class($sizeClass) }} aria-hidden="{{ $ariaHidden }}">
    <path d="M9 0h1.98c.144.715.54 1.617 1.235 2.512C12.895 3.389 13.797 4 15 4v2c-1.753 0-3.07-.814-4-1.829V11a5 5 0 1 1-5-5v2a3 3 0 1 0 3 3z"/>
</svg> 