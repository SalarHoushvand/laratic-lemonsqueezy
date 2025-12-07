@props([
    'size' => 'md', // xs | sm | md | lg | xl | 2xl
    'variant' => 'default', // default | primary | secondary | info | success | warning | danger | inverse (optional)
    'img' => null, // URL or null
    'alt' => 'Avatar',
    'isCircle' => true,
    'fallback' => null, // Fallback text (e.g., initials) to show if image fails to load
])

@php
    $sizes = [
        'xs' => 'size-6',
        'sm' => 'size-8',
        'md' => 'size-10',
        'lg' => 'size-14',
        'xl' => 'size-20',
        '2xl' => 'size-24',
    ];

    // Base wrappers
    $base = 'flex items-center justify-center overflow-hidden ' . ($isCircle ? 'rounded-full' : 'rounded-radius');
    $boxSize = $sizes[$size] ?? $sizes['md'];

    // Variant styles (Penguin UI tokens)
    $variants = [
        'default' =>
            'border border-outline bg-surface-alt text-on-surface dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark',
        'inverse' =>
            'border border-outline-dark bg-surface-dark-alt text-on-surface-dark dark:border-outline dark:bg-surface-alt dark:text-on-surface',
        'primary' =>
            'border border-primary bg-primary text-on-primary dark:border-primary-dark dark:bg-primary-dark dark:text-on-primary-dark',
        'secondary' =>
            'border border-secondary bg-secondary text-on-secondary dark:border-secondary-dark dark:bg-secondary-dark dark:text-on-secondary-dark',
        'info' => 'border border-info bg-info text-on-info',
        'success' => 'border border-success bg-success text-on-success',
        'warning' => 'border border-warning bg-warning text-on-warning',
        'danger' => 'border border-danger bg-danger text-on-danger',
    ];

    $variantClasses = $variants[$variant] ?? $variants['default'];
@endphp

@if ($img)
    {{-- Image avatar with error handling --}}
    <div class="relative shrink-0">
        <img {{ $attributes->class([$boxSize, $isCircle ? 'rounded-full' : 'rounded-radius', 'object-cover']) }}
            src="{{ $img }}" alt="{{ $alt }}"
            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';" />
        {{-- Fallback shown when image fails to load --}}
        <span style="display: none;" {{ $attributes->class([$base, $boxSize, $variantClasses]) }}>
            @if ($fallback)
                {{ $fallback }}
            @elseif (trim($slot))
                {{ $slot }}
            @else
                <x-icons.user size="{{ $size }}" variant="solid" class="size-full mt-3" />
            @endif
        </span>
    </div>
@else
    {{-- Fallback: colored circle with default icon or custom slot --}}
    <span {{ $attributes->class([$base, $boxSize, $variantClasses]) }}>
        @if ($fallback)
            {{ $fallback }}
        @elseif (trim($slot))
            {{ $slot }}
        @else
            <x-icons.user size="{{ $size }}" variant="solid" class="size-full mt-3" />
        @endif
    </span>
@endif
