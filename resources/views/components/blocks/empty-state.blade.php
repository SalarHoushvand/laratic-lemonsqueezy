@props([
    'title' => null,
    'description' => null,
    'icon' => 'folder-open',
])

<div {{ $attributes->merge(['class' => 'flex flex-col gap-2 items-center justify-center']) }}>
    <div
        class="flex items-center justify-center p-2 ">
        <x-dynamic-component :component="'icons.' . $icon" variant="solid" size="xl"
            class="text-on-surface-muted dark:text-on-surface-muted-dark opacity-75" />
    </div>
    @if ($title)
        <p class="text-center text-on-surface dark:text-on-surface-dark">
            {{ __($title) }}
        </p>
    @endif
    @if ($description)
        <p class="text-center text-sm text-on-surface-muted dark:text-on-surface-muted-dark max-w-xs">
            {{ __($description) }}
        </p>
    @endif
    {{ $slot }}
</div>
