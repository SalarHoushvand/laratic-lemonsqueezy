@props(['title', 'description', 'dividerDots' => true, 'size' => 'h1'])

<div {{ $attributes->merge(['class' => 'flex flex-col justify-center items-center gap-2 md:gap-4']) }}>
    @isset ($title)
        @if ($size === 'h1')
            <h1 class="heading-2 text-center max-w-md">
                {{ __($title) }}
            </h1>
        @elseif ($size === 'h2')
            <h2 class="heading-3 text-center max-w-md">
                {{ __($title) }}
            </h2>
        @elseif ($size === 'h3')
            <h3 class="heading-3 text-center max-w-md">
                {{ __($title) }}
            </h3>
        @endif
    @endisset
    @if ($dividerDots && isset($description))
        <div class="flex items-center justify-center gap-2">
            <div class="size-2 bg-primary dark:bg-primary-dark rounded-full"></div>
            <div class="size-2 bg-primary dark:bg-primary-dark rounded-full"></div>
            <div class="size-2 bg-primary dark:bg-primary-dark rounded-full"></div>
            <div class="size-2 bg-primary dark:bg-primary-dark rounded-full"></div>
            <div class="size-2 bg-primary dark:bg-primary-dark rounded-full"></div>
        </div>
    @endif
    @isset ($description)
        <p class="text-sm md:text-base text-center max-w-md text-on-surface-muted dark:text-on-surface-dark-muted text-pretty">
            {{ __($description) }}
        </p>
    @endisset
</div>
