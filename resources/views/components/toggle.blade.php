@props([
    'id' => null,
    'label' => null,
    'labelPosition' => 'right', // right | left | none
    'size' => 'md', // sm | md | lg | xl
    'checked' => null,
    'disabled' => null,
    'ariaLabel' => null,
    'withContainer' => false,
])

@php
    /**
     * Toggle Switch Component
     *
     * A customizable toggle switch component with support for multiple sizes,
     * label positions, Livewire integration, and optional container styling.
     */

    // Ensure we have a unique id if none provided
    $id = $id ?: 'toggle-' . uniqid();

    /**
     * Size configuration mapping for track dimensions, thumb size, translation, and label text.
     *
     * @var array<string, array{track: string, thumb: string, translate: string, labelText: string}>
     */
    $sizeMap = [
        'sm' => [
            'track' => 'h-5 w-9',
            'thumb' => 'after:h-4 after:w-4',
            'translate' => 'peer-checked:after:translate-x-4',
            'labelText' => 'text-xs',
        ],
        'md' => [
            'track' => 'h-6 w-11',
            'thumb' => 'after:h-5 after:w-5',
            'translate' => 'peer-checked:after:translate-x-5',
            'labelText' => 'text-sm',
        ],
        'lg' => [
            'track' => 'h-7 w-12',
            'thumb' => 'after:h-6 after:w-6',
            'translate' => 'peer-checked:after:translate-x-5',
            'labelText' => 'text-base',
        ],
        'xl' => [
            'track' => 'h-8 w-14',
            'thumb' => 'after:h-7 after:w-7',
            'translate' => 'peer-checked:after:translate-x-6',
            'labelText' => 'text-lg',
        ],
    ];

    $sizeConfig = $sizeMap[$size] ?? $sizeMap['md'];

    // Track background differs when using a container (Penguin UI style)
    $trackBg = $withContainer ? 'bg-surface dark:bg-surface-dark' : 'bg-surface-alt dark:bg-surface-dark-alt';

    // Base track classes with all states and transitions
    $baseTrack = implode(' ', [
        'relative rounded-full border border-outline',
        $trackBg,
        'after:absolute after:bottom-0 after:left-[0.0625rem] after:top-0 after:my-auto',
        'after:rounded-full after:bg-on-surface after:transition-all after:content-[\'\']',
        'peer-checked:bg-primary peer-checked:after:bg-on-primary',
        'peer-focus:outline-2 peer-focus:outline-offset-2 peer-focus:outline-outline-strong',
        'peer-focus:peer-checked:outline-primary peer-active:outline-offset-0',
        'peer-disabled:cursor-not-allowed peer-disabled:opacity-70',
        'dark:border-outline-dark dark:after:bg-on-surface-dark',
        'dark:peer-checked:bg-primary-dark dark:peer-checked:after:bg-on-primary-dark',
        'dark:peer-focus:outline-outline-dark-strong dark:peer-focus:peer-checked:outline-primary-dark',
    ]);

    $trackClasses = trim(
        implode(' ', [$sizeConfig['track'], $sizeConfig['thumb'], $sizeConfig['translate'], $baseTrack]),
    );

    // Base label classes with all states
    $labelBase = implode(' ', [
        'tracking-wide font-medium text-on-surface',
        'peer-checked:text-on-surface-strong',
        'peer-disabled:cursor-not-allowed peer-disabled:opacity-70',
        'dark:text-on-surface-dark dark:peer-checked:text-on-surface-dark-strong',
    ]);

    $labelClasses = trim(implode(' ', [$sizeConfig['labelText'] ?? '', $labelBase]));

    // Container padding mapping for different sizes
    $containerPadding = [
        'sm' => 'px-4 py-1.5',
        'md' => 'px-4 py-2',
        'lg' => 'px-4 py-2.5',
        'xl' => 'px-5 py-3',
    ];

    $containerBase = implode(' ', [
        'inline-flex min-w-52 items-center justify-between gap-3',
        'rounded-radius border border-outline bg-surface-alt',
        'dark:border-outline-dark dark:bg-surface-dark-alt',
    ]);

    $wrapperBase = $withContainer
        ? trim($containerBase . ' ' . ($containerPadding[$size] ?? $containerPadding['md']))
        : 'inline-flex items-center gap-3 w-fit';

    // Merge wrapper attributes, excluding Livewire and input-specific attributes
    $wrapperAttrs = $attributes
        ->except([
            'wire:model',
            'wire:model.defer',
            'wire:model.lazy',
            'wire:model.live',
            'id',
            'name',
            'checked',
            'disabled',
        ])
        ->merge(['class' => $wrapperBase]);

    // Ensure accessibility: if label is hidden, provide aria-label on input
    $resolvedAriaLabel = $ariaLabel ?: ($labelPosition === 'none' ? $label ?? __('Toggle') : null);
@endphp

<label {{ $wrapperAttrs }}>
    @if ($label && $labelPosition === 'left')
        <span class="{{ $labelClasses }}">{{ $label }}</span>
    @endif

    <input id="{{ $id }}" type="checkbox" role="switch" @checked($checked)
        @disabled($disabled) @if ($resolvedAriaLabel) aria-label="{{ $resolvedAriaLabel }}" @endif
        {{ $attributes->only(['name'])->merge(['class' => 'peer sr-only size-0 ']) }}
        {{ $attributes->whereStartsWith('wire:model') }} />

    <div class="{{ $trackClasses }}" aria-hidden="true"></div>

    @if ($label && $labelPosition === 'right')
        <span class="{{ $labelClasses }}">{{ $label }}</span>
    @endif
</label>
