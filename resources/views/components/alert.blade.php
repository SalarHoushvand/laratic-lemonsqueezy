@props([
    'variant' => 'info',
    'isDismissible' => false,
    'showIcon' => false,
    'title' => null,
    'text' => null,
    'button' => null,
    'href' => null,
])

@php
    // Variant styles
    $variants = [
        'info' => [
            'border' => 'border-info',
            'bg' => 'bg-info/10',
            'iconBg' => 'bg-info/15',
            'iconColor' => 'text-info',
            'titleColor' => 'text-info',
        ],
        'success' => [
            'border' => 'border-success',
            'bg' => 'bg-success/10',
            'iconBg' => 'bg-success/15',
            'iconColor' => 'text-success',
            'titleColor' => 'text-success',
        ],
        'warning' => [
            'border' => 'border-warning',
            'bg' => 'bg-warning/10',
            'iconBg' => 'bg-warning/15',
            'iconColor' => 'text-warning',
            'titleColor' => 'text-warning',
        ],
        'danger' => [
            'border' => 'border-danger',
            'bg' => 'bg-danger/10',
            'iconBg' => 'bg-danger/15',
            'iconColor' => 'text-danger',
            'titleColor' => 'text-danger',
        ],
    ];

    $variantStyles = $variants[$variant] ?? $variants['info'];

    // Default icons for each variant
    $defaultIcons = [
        'info' => 'information-circle',
        'success' => 'check-circle',
        'warning' => 'exclamation-triangle',
        'danger' => 'x-circle',
    ];

    $iconName = $showIcon ? $defaultIcons[$variant] ?? 'information-circle' : null;

    // Base classes for the alert container
    $baseClasses = "relative w-full overflow-hidden rounded-radius border {$variantStyles['border']} bg-surface text-on-surface dark:bg-surface-dark dark:text-on-surface-dark";
@endphp

<div @if ($isDismissible) x-data="{ alertIsVisible: true }"
        x-show="alertIsVisible"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-90" @endif
    {{ $attributes->except(['wire:click', 'wire:target', 'wire:loading', 'wire:confirm'])->merge(['class' => $baseClasses, 'role' => 'alert']) }}>
    <div class="flex w-full items-center gap-2 {{ $variantStyles['bg'] }} p-4">
        @if ($iconName)
            <div class="{{ $variantStyles['iconBg'] }} {{ $variantStyles['iconColor'] }} rounded-full p-1 shrink-0"
                aria-hidden="true">
                <x-dynamic-component :component="'icons.' . $iconName" variant="mini" />
            </div>
        @endif

        <div class="flex flex-col gap-2 {{ $iconName ? 'ml-2' : '' }} flex-1">
            <div>
                @if ($title)
                    <p class="text-sm font-semibold {{ $variantStyles['titleColor'] }}">{{ $title }}</p>
                @endif
                @if ($text)
                    <p class="text-xs font-medium sm:text-sm">{{ $text }}</p>
                @endif
                @if (!$text)
                    {{ $slot }}
                @endif
            </div>

            @if ($button)
                <div class="flex items-center gap-4">
                    @if ($href)
                        <a href="{{ $href }}"
                            class="whitespace-nowrap text-center text-sm font-semibold tracking-wide {{ $variantStyles['titleColor'] }} transition hover:opacity-75 active:opacity-100">
                            {{ $button }}
                        </a>
                    @else
                        <button type="button"
                            {{ $attributes->only(['wire:click', 'wire:target', 'wire:loading', 'wire:confirm']) }}
                            class="whitespace-nowrap text-center text-sm font-semibold tracking-wide {{ $variantStyles['titleColor'] }} transition hover:opacity-75 active:opacity-100">
                            {{ $button }}
                        </button>
                    @endif
                    @if ($isDismissible)
                        <button type="button" x-on:click="alertIsVisible = false"
                            class="whitespace-nowrap text-center text-sm font-medium tracking-wide text-on-surface transition hover:opacity-75 dark:text-on-surface-dark active:opacity-100">
                            {{ __('Dismiss') }}
                        </button>
                    @endif
                </div>
            @endif
        </div>

        @if ($isDismissible && !$button)
            <button type="button" x-on:click="alertIsVisible = false" class="ml-auto shrink-0"
                aria-label="{{ __('Dismiss alert') }}">
                <x-icons.x-mark class="size-4 shrink-0" />
            </button>
        @endif
    </div>
</div>
