@props([
    'title' => null,
    'description' => null,
])

<div class="mb-4">
    <h1 class="heading-5 md:heading-4 text-on-surface-strong dark:text-on-surface-dark-strong">
        {{ $title }}
    </h1>
    <p class="text-sm sm:text-base text-on-surface-muted dark:text-on-surface-dark-muted">
        {{ $description }}
    </p>
</div>
