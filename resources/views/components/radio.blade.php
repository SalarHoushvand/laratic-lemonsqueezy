@props([
    'id' => null,
    'label' => null,
    'description' => null,
    'labelPosition' => 'right',
    'checked' => false,
    'disabled' => null,
    'withContainer' => false,
])

@php
    $id = $id ?: ('radio-' . uniqid());
    $descriptionId = $description ? $id . '-description' : null;
    
    $radioBg = $withContainer ? 'bg-surface dark:bg-surface-dark' : 'bg-surface-alt dark:bg-surface-dark-alt';
    
    $radioClasses = "before:content[''] peer relative h-4 w-4 appearance-none rounded-full border border-outline {$radioBg} before:invisible before:absolute before:left-1/2 before:top-1/2 before:h-1.5 before:w-1.5 before:-translate-x-1/2 before:-translate-y-1/2 before:rounded-full before:bg-on-primary checked:border-primary checked:bg-primary checked:before:visible focus:outline focus:outline-2 focus:outline-offset-2 focus:outline-outline-strong checked:focus:outline-primary active:outline-offset-0 disabled:cursor-not-allowed dark:border-outline-dark dark:before:bg-on-primary-dark dark:checked:border-primary-dark dark:checked:bg-primary-dark dark:focus:outline-outline-dark-strong dark:checked:focus:outline-primary-dark";
    
    if ($withContainer) {
        $wrapperClasses = 'inline-flex min-w-52 items-center justify-between gap-3 rounded-radius border border-outline bg-surface-alt px-4 py-2 text-sm font-medium text-on-surface dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark has-checked:text-on-surface-strong dark:has-checked:text-on-surface-dark-strong has-disabled:opacity-75 has-disabled:cursor-not-allowed';
    } else {
        $wrapperClasses = 'flex items-center gap-2 text-sm font-medium text-on-surface dark:text-on-surface-dark has-checked:text-on-surface-strong dark:has-checked:text-on-surface-dark-strong has-disabled:opacity-75 has-disabled:cursor-not-allowed';
    }
@endphp

@if ($description)
    {{-- Radio with description --}}
    <div class="flex flex-col gap-1">
        <label for="{{ $id }}" class="{{ $wrapperClasses }}">
            <input
                id="{{ $id }}"
                type="radio"
                @checked($checked)
                @disabled($disabled)
                aria-describedby="{{ $descriptionId }}"
                class="{{ $radioClasses }}"
                {{ $attributes->only(['name', 'value', 'wire:model', 'wire:model.live', 'wire:model.defer']) }}
            />
            <span>{{ $label }}</span>
        </label>
        <span id="{{ $descriptionId }}" class="ml-6 text-sm text-on-surface-muted dark:text-on-surface-dark-muted">{{ $description }}</span>
    </div>
@else
    {{-- Standard radio or with container --}}
    <label for="{{ $id }}" class="{{ $wrapperClasses }}">
        @if ($label && ($withContainer || $labelPosition === 'left'))
            <span>{{ $label }}</span>
        @endif

        <input
            id="{{ $id }}"
            type="radio"
            @checked($checked)
            @disabled($disabled)
            class="{{ $radioClasses }}"
            {{ $attributes->only(['name', 'value', 'wire:model', 'wire:model.live', 'wire:model.defer']) }}
        />

        @if ($label && !$withContainer && $labelPosition === 'right')
            <span>{{ $label }}</span>
        @endif
    </label>
@endif
