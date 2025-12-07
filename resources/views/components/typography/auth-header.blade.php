@props([
    'title',
    'description',
])

<div class="flex w-full flex-col gap-2 text-center">
    <h1 class="text-xl font-medium text-on-surface-strong dark:text-on-surface-dark-strong">{{ $title }}</h1>
    @isset ($description)
        <p class="text-center text-sm text-on-surface-muted dark:text-on-surface-dark-muted text-pretty">{{ $description }}</p>
    @endisset
</div>
