@props(['width' => 'w-full md:max-w-xs', 'error' => false, 'icon' => null, 'chevron' => true, 'rightIcon' => null])

<div class="{{ $width }} relative flex w-full flex-col gap-1 text-on-surface dark:text-on-surface-dark ">
    @if ($icon)
        <div class="absolute pointer-events-none left-3 shrink-0 top-1/2 -translate-y-1/2">
            <x-dynamic-component :component="'icons.' . $icon" variant="mini" size="sm"
                class="text-on-surface-muted dark:text-on-surface-dark-muted" />
        </div>
    @endif
    @if ($chevron || $rightIcon)
        @if ($chevron)
            <x-icons.chevron-down size="size-3.5" strokeWidth="2"
                class="absolute pointer-events-none right-4 shrink-0 top-1/2 -translate-y-1/2" />
        @endif
        @if ($rightIcon)
            <x-dynamic-component :component="'icons.' . $rightIcon" variant="mini" size="md"
                class="absolute pointer-events-none right-4 shrink-0 top-1/2 -translate-y-1/2" />
        @endif
    @endif
    <select {!! $attributes->merge([
        'class' =>
            'w-full appearance-none rounded-radius border bg-surface-alt py-2 text-sm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary disabled:cursor-not-allowed disabled:opacity-75 dark:text-on-surface-dark dark:bg-surface-dark-alt dark:focus-visible:outline-primary-dark cursor-pointer' .
            ($error ? ' border-danger ' : ' border-outline dark:border-outline-dark ') .
            ($icon ? ' pl-9 ' : ' pl-2 ') .
            ($chevron ? ' pr-2 ' : ' pr-2 '),
    ]) !!}>
        {{ $slot }}
    </select>
</div>
