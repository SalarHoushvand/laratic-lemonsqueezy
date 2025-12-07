@props([
    'maxWidth' => '2xl',
    'show' => false,
    'name' => null,
    'backdropBlur' => 'sm',
    'backdropOpacity' => 'sm',
])

@php
    $maxWidthClass = match ($maxWidth) {
        'sm' => 'sm:max-w-sm',
        'md' => 'sm:max-w-md',
        'lg' => 'sm:max-w-lg',
        'xl' => 'sm:max-w-xl',
        '2xl' => 'sm:max-w-2xl',
        '3xl' => 'sm:max-w-3xl',
        '4xl' => 'sm:max-w-4xl',
        default => 'sm:max-w-2xl',
    };

    $backdropBlurClass = match ($backdropBlur) {
        'none' => 'backdrop-blur-none',
        'sm' => 'backdrop-blur-sm',
        'md' => 'backdrop-blur-md',
        'lg' => 'backdrop-blur-lg',
        'xl' => 'backdrop-blur-xl',
        '2xl' => 'backdrop-blur-2xl',
        '3xl' => 'backdrop-blur-3xl',
        default => 'backdrop-blur-sm',
    };

    $backdropOpacityClass = match ($backdropOpacity) {
        'none' => 'bg-surface-dark/0',
        'sm' => 'bg-surface-dark/20',
        'md' => 'bg-surface-dark/40',
        'lg' => 'bg-surface-dark/60',
        'xl' => 'bg-surface-dark/80',
        '2xl' => 'bg-surface-dark/90',
        '3xl' => 'bg-surface-dark/95',
        default => 'bg-surface-dark/20',
    };
@endphp

<div x-data="{ modalIsOpen: @js($show) }" @if ($name) data-modal-name="{{ $name }}" x-on:open-modal.window="if ($event.detail.name === '{{ $name }}') { modalIsOpen = true }" @endif x-on:close-modal.window="modalIsOpen = false">
    @isset($trigger)
        {{ $trigger }}
    @endisset

    <div x-cloak x-show="modalIsOpen" x-transition.opacity.duration.200ms x-trap.inert.noscroll="modalIsOpen" x-on:keydown.esc.window="modalIsOpen = false" x-on:click.self="modalIsOpen = false" class="fixed inset-0 z-99 flex items-start justify-center {{ $backdropOpacityClass }} p-4 pb-8 {{ $backdropBlurClass }} sm:items-center lg:p-8" role="dialog" aria-modal="true">
        <div x-show="modalIsOpen" x-transition:enter="transition ease-out duration-200 delay-100 motion-reduce:transition-opacity" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0" class="flex {{ $maxWidthClass }} w-full overflow-hidden flex-col verflow-hidden rounded-radius border border-outline bg-surface text-on-surface dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark">
            <div class="flex items-center justify-between border-b border-outline bg-surface-alt/60 p-4 dark:border-outline-dark dark:bg-surface-dark">
                @isset($header)
                    {{ $header }}
                @endisset

                <button x-on:click="modalIsOpen = false" class="ml-auto" aria-label="{{ __('Close modal') }}">
                    <x-icons.x-mark />
                </button>
            </div>

            <div class="bg-surface dark:bg-surface-dark/75 py-4">
                {{ $slot }}
            </div>

            @isset($footer)
                <div class="flex flex-col-reverse gap-2 border-t border-outline bg-surface-alt/60 p-4 dark:border-outline-dark dark:bg-surface-dark sm:flex-row sm:items-center sm:justify-end">
                    {{ $footer }}
                </div>
            @endisset
        </div>
    </div>
</div>
