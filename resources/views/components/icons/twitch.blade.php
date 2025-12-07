<!-- Credit: Bootstrap Icons (https://icons.getbootstrap.com) -->
@props(['size' => 'md', 'ariaHidden' => 'true'])
@php
    $sizes = ['xs' => 'size-3', 'sm' => 'size-4', 'md' => 'size-5', 'lg' => 'size-6', 'xl' => 'size-7'];
    $sizeClass = array_key_exists($size, $sizes) ? $sizes[$size] : $size;
@endphp
<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16" {{ $attributes->class($sizeClass) }}
    aria-hidden="{{ $ariaHidden }}">
    <path
        d="M3.857 0 1 2.857v10.286h3.429V16l2.857-2.857H9.57L14.714 8V0H3.857zm9.714 7.429-2.285 2.285H9l-2 2v-2H4.429V1.143h9.142z" />
    <path d="M11.857 3.143h-1.143V6.57h1.143zm-3.143 0H7.571V6.57h1.143z" />
</svg>
