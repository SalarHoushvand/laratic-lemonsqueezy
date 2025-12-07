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
    $id = $id ?: ('checkbox-' . uniqid());
    $descriptionId = $description ? $id . '-description' : null;
    
    $checkboxBg = $withContainer ? 'bg-surface dark:bg-surface-dark' : 'bg-surface-alt dark:bg-surface-dark-alt';
    
    $checkboxClasses = "before:content[''] peer relative size-4 appearance-none overflow-hidden rounded-sm border border-outline {$checkboxBg} before:absolute before:inset-0 checked:border-primary checked:before:bg-primary focus:outline-2 focus:outline-offset-2 focus:outline-outline-strong checked:focus:outline-primary active:outline-offset-0 disabled:cursor-not-allowed dark:border-outline-dark dark:checked:border-primary-dark dark:checked:before:bg-primary-dark dark:focus:outline-outline-dark-strong dark:checked:focus:outline-primary-dark";
    
    if ($withContainer) {
        $wrapperClasses = 'inline-flex min-w-52 items-center justify-between gap-3 rounded-radius border border-outline bg-surface-alt px-4 py-2 text-sm font-medium text-on-surface dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark has-checked:text-on-surface-strong dark:has-checked:text-on-surface-dark-strong has-disabled:opacity-75 has-disabled:cursor-not-allowed';
    } else {
        $wrapperClasses = 'flex items-center gap-2 text-sm font-medium text-on-surface dark:text-on-surface-dark has-checked:text-on-surface-strong dark:has-checked:text-on-surface-dark-strong has-disabled:opacity-75 has-disabled:cursor-not-allowed';
    }
@endphp

@if ($description)
    {{-- Checkbox with description --}}
    <div class="flex flex-col items-start">
        <label for="{{ $id }}" class="{{ $wrapperClasses }}">
            <span class="relative flex items-center">
                <input
                    id="{{ $id }}"
                    type="checkbox"
                    @checked($checked)
                    @disabled($disabled)
                    aria-describedby="{{ $descriptionId }}"
                    class="{{ $checkboxClasses }}"
                    {{ $attributes->only(['name', 'wire:model', 'wire:model.live', 'wire:model.defer']) }}
                />
                <x-icons.check variant="micro" size="sm" class="absolute hidden left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 text-on-primary peer-checked:block dark:text-on-primary-dark" />
            </span>
            <span>{{ $label }}</span>
        </label>
        <span id="{{ $descriptionId }}" class="ml-6 text-sm text-on-surface-muted dark:text-on-surface-muted-dark">{{ $description }}</span>
    </div>
@else
    {{-- Standard checkbox or with container --}}
    <label for="{{ $id }}" class="{{ $wrapperClasses }}">
        @if ($label && ($withContainer || $labelPosition === 'left'))
            <span>{{ $label }}</span>
        @endif

        <span class="relative flex items-center">
            <input
                id="{{ $id }}"
                type="checkbox"
                @checked($checked)
                @disabled($disabled)
                class="{{ $checkboxClasses }}"
                {{ $attributes->only(['name', 'wire:model', 'wire:model.live', 'wire:model.defer']) }}
            />
            <x-icons.check variant="micro" size="sm" class="absolute hidden peer-checked:block left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 text-on-primary dark:text-on-primary-dark" />
        </span>

        @if ($label && !$withContainer && $labelPosition === 'right')
            <span>{{ $label }}</span>
        @endif
    </label>
@endif