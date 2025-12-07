@props([
    'title',
    'description',
])

<div class="mb-4">
    <h2 class="heading-5 text-on-surface-strong dark:text-on-surface-dark-strong">
        {{ $title }}
    </h2>
    <p class="text-sm text-on-surface-muted dark:text-on-surface-dark-muted">
        {{ $description }}
    </p>
</div>
