@props([
    'id' => 'combobox-' . Str::random(8),
    'name' => null,
    'label' => null,
    'options' => [],

    'placeholder' => null,
    'disabled' => false,
    'searchable' => true,

    'displayKey' => 'label',
    'secondaryDisplayKey' => null,
    'valueKey' => 'value',
    'imageKey' => null,
])

@php
    $placeholder = $placeholder ?? __('Please select');
    $listId = $id . '-list';

    // Detect Livewire model (wire:model / wire:model.live / etc.)
    $wireModel = $attributes->wire('model')->value();

    // Root attributes: classes etc. but strip wire:model* from output
    $rootAttrs = $attributes
        ->class('w-full flex flex-col gap-1')
        ->except([
            'wire:model',
            'wire:model.defer',
            'wire:model.live',
            'wire:model.lazy',
            'wire:model.blur',
        ]);

    // wire:* attributes (except model) go on the button (loading, target, etc.)
    $wireAttrs = $attributes
        ->whereStartsWith('wire:')
        ->except([
            'wire:model',
            'wire:model.defer',
            'wire:model.live',
            'wire:model.lazy',
        ]);
@endphp

<div
    {{ $rootAttrs }}
    x-data="{
        open: false,
        search: '',
        allOptions: @js($options),

        // Livewire entangled value if present; otherwise plain local value
        value: @if ($wireModel)
            @entangle($attributes->wire('model'))
        @else
            null
        @endif,

        get options() {
            if (!this.search) return this.allOptions;
            const q = this.search.toLowerCase();

            return this.allOptions.filter(option => {
                const main = String(option.{{ $displayKey }} ?? '').toLowerCase();
                @if ($secondaryDisplayKey)
                    const secondary = String(option.{{ $secondaryDisplayKey }} ?? '').toLowerCase();
                    return main.includes(q) || secondary.includes(q);
                @else
                    return main.includes(q);
                @endif
            });
        },

        get selectedOption() {
            return this.allOptions.find(option => option.{{ $valueKey }} === this.value) || null;
        },

        select(option) {
            this.value = option.{{ $valueKey }};
            this.open = false;
            this.search = '';
        },

        labelText() {
            if (!this.selectedOption) {
                return '{{ addslashes($placeholder) }}';
            }

            let text = this.selectedOption.{{ $displayKey }} ?? '';

            @if ($secondaryDisplayKey)
                if (
                    this.selectedOption.{{ $secondaryDisplayKey }} &&
                    this.selectedOption.{{ $secondaryDisplayKey }} !== this.selectedOption.{{ $displayKey }}
                ) {
                    text += ' (' + this.selectedOption.{{ $secondaryDisplayKey }} + ')';
                }
            @endif

            return text || '{{ addslashes($placeholder) }}';
        },
    }"
    x-on:keydown.escape.window="open = false"
>
    @if ($label)
        <label
            for="{{ $id }}"
            class="w-fit pl-0.5 text-sm text-on-surface dark:text-on-surface-dark"
        >
            {{ $label }}
        </label>
    @endif

    <div class="relative">
        {{-- Hidden input for normal forms (non-Livewire still works) --}}
        @if ($name)
            <input
                type="hidden"
                name="{{ $name }}"
                x-model="value"
            >
        @endif

        <button
            type="button"
            role="combobox"
            id="{{ $id }}"
            aria-controls="{{ $listId }}"
            x-on:click="open = !open"
            x-bind:aria-expanded="open"
            x-bind:aria-label="labelText()"
            x-bind:disabled="{{ $disabled ? 'true' : 'false' }}"

            {{ $wireAttrs }}

            class="inline-flex w-full items-center justify-between gap-2 whitespace-nowrap rounded-radius border border-outline bg-surface-alt px-4 py-2 text-sm font-medium capitalize tracking-wide text-on-surface transition hover:opacity-75 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary disabled:cursor-not-allowed disabled:opacity-75 dark:border-outline-dark dark:bg-surface-dark-alt/50 dark:text-on-surface-dark dark:focus-visible:outline-primary-dark"
        >
            <div class="flex min-w-0 flex-1 items-center gap-2">
                @if ($imageKey)
                    <template x-if="selectedOption && selectedOption.{{ $imageKey }}">
                        <img
                            x-bind:src="selectedOption.{{ $imageKey }}"
                            x-bind:alt="labelText()"
                            class="h-3.5 w-5 shrink-0 object-cover"
                        />
                    </template>
                @endif

                <span class="truncate text-sm font-normal" x-text="labelText()"></span>
            </div>

            <x-icons.chevron-down size="size-3.5" strokeWidth="2" class="shrink-0" />
        </button>

        <ul
            x-cloak
            x-show="open"
            x-transition
            x-on:click.outside="open = false"
            id="{{ $listId }}"
            role="listbox"
            class="absolute left-0 top-11 z-10 flex max-h-44 w-full flex-col overflow-hidden overflow-y-auto rounded-radius border border-outline bg-surface-alt dark:border-outline-dark dark:bg-surface-dark-alt md:max-h-64"
        >
            @if ($searchable)
                <div class="sticky top-0 z-10 bg-surface-alt text-on-surface-muted px-1.5 pt-1.5 pb-1.5 dark:bg-surface-dark-alt dark:text-on-surface-dark-muted">
                    <x-icons.magnifying-glass
                        size="md"
                        class="absolute left-4 top-1/2 size-5 -translate-y-1/2 text-on-surface/50 dark:text-on-surface-dark/50"
                    />
                    <input
                        type="text"
                        x-model="search"
                        placeholder="{{ $searchPlaceholder ?? __('Search') }}"
                        class="w-full rounded-none border-x-0 border-t-0 bg-transparent pl-9 pr-3 py-2 text-sm focus:outline-none focus-visible:outline-none"
                    />
                </div>
            @endif

            <template x-if="options.length === 0">
                <li class="px-4 py-2 text-sm text-on-surface dark:text-on-surface-dark">
                    {{ __('No matches found') }}
                </li>
            </template>

            <template x-for="(item, index) in options" x-bind:key="item.{{ $valueKey }}">
                <li
                    role="option"
                    tabindex="0"
                    x-on:click="select(item)"
                    x-on:keydown.enter.prevent="select(item)"
                    class="inline-flex items-center justify-between cursor-pointer gap-6 bg-surface-alt px-4 py-2 text-sm text-on-surface hover:bg-surface-dark-alt/5 hover:text-on-surface-strong focus-visible:bg-surface-dark-alt/5 focus-visible:text-on-surface-strong focus-visible:outline-hidden dark:bg-surface-dark-alt dark:text-on-surface-dark dark:hover:bg-surface-alt/5 dark:hover:text-on-surface-dark-strong dark:focus-visible:bg-surface-alt/10 dark:focus-visible:text-on-surface-dark-strong"
                >
                    <div class="flex min-w-0 flex-1 items-center gap-2">
                        @if ($imageKey)
                            <template x-if="item.{{ $imageKey }}">
                                <img
                                    x-bind:src="item.{{ $imageKey }}"
                                    x-bind:alt="item.{{ $displayKey }}"
                                    class="h-4.5 w-6 shrink-0 object-cover"
                                />
                            </template>
                        @endif

                        <div class="flex min-w-0 flex-1 flex-col">
                            <span
                                class="truncate"
                                x-bind:class="selectedOption && selectedOption.{{ $valueKey }} === item.{{ $valueKey }} ? 'font-bold' : null"
                                x-text="item.{{ $displayKey }}"
                            ></span>

                            @if ($secondaryDisplayKey)
                                <span class="truncate text-xs" x-text="item.{{ $secondaryDisplayKey }}"></span>
                            @endif
                        </div>
                    </div>

                    <x-icons.check
                        size="md"
                        strokeWidth="2"
                        x-show="selectedOption && selectedOption.{{ $valueKey }} === item.{{ $valueKey }}"
                    />
                </li>
            </template>
        </ul>
    </div>
</div>
