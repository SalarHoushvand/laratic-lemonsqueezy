@props([
    'disabled' => false,
    'variant' => 'text',
    'viewable' => true,
    'error' => false,
])

@if ($variant === 'password')
    <div x-data="{ showPassword: false }" class="relative">
        <input x-bind:type="showPassword ? 'text' : 'password'" @disabled($disabled)
            {{ $attributes->merge(['class' => 'w-full rounded-radius border bg-surface-alt autofill:bg-surface-alt px-2 py-2 text-sm text-on-surface focus:border-outline focus:ring-0 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary disabled:cursor-not-allowed disabled:opacity-75 dark:text-on-surface-dark dark:bg-surface-dark-alt dark:autofill:bg-surface dark:focus:border-outline-dark dark:focus-visible:outline-primary-dark' . ($error ? ' border-danger ' : ' border-outline dark:border-outline-dark ')]) }}>

        @if ($viewable)
            <button type="button" x-on:click="showPassword = !showPassword"
                class="absolute right-2.5 top-1/2 -translate-y-1/2 text-on-surface dark:text-on-surface-dark"
                aria-label="Show password">
                <x-icons.eye x-cloak x-show="!showPassword" variant="outline" size="md" />
                <x-icons.eye-slash x-cloak x-show="showPassword" variant="outline" size="md" />
            </button>
        @endif
    </div>
@elseif ($variant === 'search')
    <div class="relative">
        <x-icons.magnifying-glass 
            class="absolute left-2.5 top-1/2 size-5 -translate-y-1/2 text-on-surface/50 dark:text-on-surface-dark/50" 
        />
        <input type="search" @disabled($disabled)
            {{ $attributes->merge(['class' => 'w-full rounded-radius border bg-surface-alt autofill:bg-surface px-2 py-2 pl-10 text-sm text-on-surface focus:border-outline focus:ring-0 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary disabled:cursor-not-allowed disabled:opacity-75 dark:text-on-surface-dark dark:bg-surface-dark-alt dark:autofill:bg-surface-dark-alt dark:focus:border-outline-dark dark:focus-visible:outline-primary-dark' . ($error ? ' border-danger ' : ' border-outline dark:border-outline-dark ')]) }}>
    </div>
@elseif ($variant === 'date')
    <input type="date" @disabled($disabled)
        {{ $attributes->merge(['class' => 'w-full rounded-radius border bg-surface-alt autofill:bg-surface px-2 py-2 text-sm text-on-surface focus:border-outline focus:ring-0 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary disabled:cursor-not-allowed disabled:opacity-75 dark:text-on-surface-dark dark:bg-surface-dark-alt dark:autofill:bg-surface-dark-alt dark:focus:border-outline-dark dark:focus-visible:outline-primary-dark' . ($error ? ' border-danger ' : ' border-outline dark:border-outline-dark ')]) }}>
@else
    <input @disabled($disabled)
        {{ $attributes->merge(['class' => 'w-full rounded-radius border bg-surface-alt autofill:bg-surface px-2 py-2 text-sm text-on-surface focus:border-outline focus:ring-0 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary disabled:cursor-not-allowed disabled:opacity-75 dark:text-on-surface-dark dark:bg-surface-dark-alt dark:autofill:bg-surface-dark-alt dark:focus:border-outline-dark dark:focus-visible:outline-primary-dark' . ($error ? ' border-danger ' : ' border-outline dark:border-outline-dark ')]) }}>
@endif
    