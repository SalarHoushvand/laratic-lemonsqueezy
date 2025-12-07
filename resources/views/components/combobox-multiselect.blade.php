@props([
    'options' => [],
    'wireModel' => null,
    'id' => 'combobox-multiselect',
    'name' => 'combobox-multiselect',
    'label' => null,
    'disabled' => false,
    'placeholder' => null,
    'wireTarget' => null,
    'searchable' => true,
    'searchPlaceholder' => null,
    'listId' => null,
    'displayKey' => 'label',
    'secondaryDisplayKey' => null,
    'valueKey' => 'value',
    'imageKey' => null,
    'searchKeys' => null,
    'emptyStateMessage' => null,
    'selectedValues' => [],
])

@php
    // Extract wire:model from attributes if present
    if (!$wireModel && $attributes->has('wire:model')) {
        $wireModel = $attributes->get('wire:model');
    }
    
    // Remove wire:model from attributes so it doesn't get passed to child elements
    $attributes = $attributes->except(['wire:model']);
    
    $placeholder = $placeholder ?? __('Please Select');
    $searchPlaceholder = $searchPlaceholder ?? __('Search');
    $listId = $listId ?? $id . 'List';
    $searchKeys = $searchKeys ?? [$displayKey, $secondaryDisplayKey];
    $searchKeys = array_filter($searchKeys);
    $emptyStateMessage = $emptyStateMessage ?? __('No options available');
    $selectedValues = $selectedValues ?? [];
    
    // Generate a key based on options to force re-initialization when options change
    $optionsKey = md5(json_encode($options));
@endphp

<div
    wire:key="combobox-{{ $id }}-{{ $optionsKey }}"
    x-data="{
        allOptions: @js($options),
        options: [],
        initialSelected: @js($selectedValues),
        isOpen: false,
        openedWithKeyboard: false,
        selectedOptions: [],
        isSelected(option) {
            return this.selectedOptions.some((item) => item.{{ $valueKey }} === option.{{ $valueKey }});
        },
        toggleOption(option) {
            const index = this.selectedOptions.findIndex((item) => item.{{ $valueKey }} === option.{{ $valueKey }});
            if (index > -1) {
                this.selectedOptions.splice(index, 1);
            } else {
                this.selectedOptions.push(option);
            }
            @if ($wireModel)
                $wire.set('{{ $wireModel }}', this.selectedOptions.map((item) => item.{{ $valueKey }}));
            @endif
        },
        removeOption(option) {
            const index = this.selectedOptions.findIndex((item) => item.{{ $valueKey }} === option.{{ $valueKey }});
            if (index > -1) {
                this.selectedOptions.splice(index, 1);
                @if ($wireModel)
                    $wire.set('{{ $wireModel }}', this.selectedOptions.map((item) => item.{{ $valueKey }}));
                @endif
            }
        },
        getFilteredOptions(query) {
            if (!query || query === '') {
                this.options = this.allOptions;
                this.$refs.noResultsMessage.classList.add('hidden');
                return;
            }
            this.options = this.allOptions.filter((option) => {
                @if (!empty($searchKeys))
                    return @foreach ($searchKeys as $key)
                        @if (!$loop->first) || @endif option.{{ $key }}?.toLowerCase().includes(query.toLowerCase())
                    @endforeach;
                @else
                    return option.{{ $displayKey }}?.toLowerCase().includes(query.toLowerCase());
                @endif
            });
            if (this.options.length === 0) {
                this.$refs.noResultsMessage.classList.remove('hidden');
            } else {
                this.$refs.noResultsMessage.classList.add('hidden');
            }
        },
        highlightFirstMatchingOption(pressedKey) {
            if (this.$refs.searchField && document.activeElement === this.$refs.searchField) {
                return;
            }
            const option = this.options.find((item) => {
                @if (!empty($searchKeys))
                    return @foreach ($searchKeys as $key)
                        @if (!$loop->first) || @endif item.{{ $key }}?.toLowerCase().startsWith(pressedKey.toLowerCase())
                    @endforeach;
                @else
                    return item.{{ $displayKey }}?.toLowerCase().startsWith(pressedKey.toLowerCase());
                @endif
            });
            if (option) {
                const index = this.options.indexOf(option);
                const allOptions = document.querySelectorAll('.combobox-option');
                if (allOptions[index]) {
                    allOptions[index].focus();
                }
            }
        },
        handleKeydownOnOptions(event) {
            if (
                (event.keyCode >= 65 && event.keyCode <= 90) ||
                (event.keyCode >= 48 && event.keyCode <= 57) ||
                event.keyCode === 8
            ) {
                if (this.$refs.searchField) {
                    this.$refs.searchField.focus();
                }
            }
        },
        getDisplayText(option) {
            let text = option.{{ $displayKey }};
            @if ($secondaryDisplayKey)
                if (
                    option.{{ $secondaryDisplayKey }} &&
                    option.{{ $secondaryDisplayKey }} !== option.{{ $displayKey }}
                ) {
                    text += ' (' + option.{{ $secondaryDisplayKey }} + ')';
                }
            @endif
            return text;
        },
    }"
    class="w-full flex flex-col gap-1"
    x-on:keydown="handleKeydownOnOptions($event); highlightFirstMatchingOption($event.key)"
    x-on:keydown.esc.window="isOpen = false, openedWithKeyboard = false"
    x-init="
        options = allOptions;
        if (initialSelected && Array.isArray(initialSelected) && initialSelected.length > 0) {
            selectedOptions = allOptions.filter((option) => initialSelected.includes(option.{{ $valueKey }}));
        }
        @if ($wireModel)
            $watch('$wire.{{ $wireModel }}', (values) => {
                if (values && Array.isArray(values)) {
                    selectedOptions = allOptions.filter((option) => values.includes(option.{{ $valueKey }}));
                } else {
                    selectedOptions = [];
                }
            });
            if ($wire.{{ $wireModel }} && Array.isArray($wire.{{ $wireModel }})) {
                selectedOptions = allOptions.filter((option) => $wire.{{ $wireModel }}.includes(option.{{ $valueKey }}));
            }
        @endif
    ">
    @if ($label)
        <label
            for="{{ $id }}"
            class="w-fit pl-0.5 text-sm text-on-surface dark:text-on-surface-dark">
            {{ $label }}
        </label>
    @endif

    <div class="relative">
        <button
            type="button"
            role="combobox"
            id="{{ $id }}"
            name="{{ $name }}"
            class="inline-flex w-full items-center justify-between gap-2 whitespace-nowrap rounded-radius border border-outline bg-surface-alt px-4 py-2 text-sm font-medium capitalize tracking-wide text-on-surface transition focus-visible:outline-2 focus-visible:outline-offset-2 cursor-pointer focus-visible:outline-primary disabled:cursor-not-allowed disabled:opacity-75 dark:border-outline-dark dark:bg-surface-dark-alt/50 dark:text-on-surface-dark dark:focus-visible:outline-primary-dark"
            aria-haspopup="listbox"
            aria-controls="{{ $listId }}"
            x-on:click="isOpen = !isOpen"
            x-on:keydown.down.prevent="openedWithKeyboard = true"
            x-on:keydown.enter.prevent="openedWithKeyboard = true"
            x-on:keydown.space.prevent="openedWithKeyboard = true"
            x-bind:aria-label="selectedOptions.length > 0 ? selectedOptions.length + ' {{ __('selected') }}' : '{{ $placeholder }}'"
            x-bind:aria-expanded="isOpen || openedWithKeyboard"
            x-bind:disabled="{{ $disabled ? 'true' : 'false' }}"
            @if ($wireTarget)
                wire:loading.attr="disabled"
                wire:target="{{ $wireTarget }}"
            @endif>
            <div class="flex min-w-0 flex-1 flex-wrap items-center gap-1.5">
                @isset($buttonContent)
                    {{ $buttonContent }}
                @else
                    <template x-if="selectedOptions.length === 0">
                        <span class="text-sm font-normal text-on-surface/60 dark:text-on-surface-dark/60" x-text="'{{ $placeholder }}'"></span>
                    </template>
                    <template x-for="option in selectedOptions" x-bind:key="option.{{ $valueKey }}">
                        <x-badge variant="outline-primary" size="xs" class="cursor-pointer">
                            <span x-text="getDisplayText(option)" class="truncate max-w-[120px]"></span>
                            <x-icons.x-mark variant="micro" x-on:click.stop="removeOption(option)" size="sm" strokeWidth="2" />
                        </x-badge>
                    </template>
                @endisset
            </div>
            <x-icons.chevron-down size="size-3.5" strokeWidth="2" class="shrink-0" />
        </button>

        <template x-for="option in selectedOptions" x-bind:key="'selected-input-' + option.{{ $valueKey }}">
            <input type="hidden" name="{{ $name }}[]" x-bind:value="option.{{ $valueKey }}">
        </template>

        <ul
            x-cloak
            x-show="isOpen || openedWithKeyboard"
            id="{{ $listId }}"
            class="absolute left-0 top-11 z-10 flex max-h-44 w-full flex-col overflow-hidden overflow-y-auto rounded-radius border border-outline bg-surface-alt dark:border-outline-dark dark:bg-surface-dark-alt"
            role="listbox"
            x-on:click.outside="isOpen = false, openedWithKeyboard = false"
            x-on:keydown.down.prevent="$focus.wrap().next()"
            x-on:keydown.up.prevent="$focus.wrap().previous()"
            x-transition
            x-trap="openedWithKeyboard">
            @if ($searchable)
                <div
                    x-show="allOptions.length > 0"
                    class="sticky top-0 z-10 bg-surface-alt px-1.5 pt-1.5 pb-1.5 dark:bg-surface-dark-alt">
                    <x-icons.magnifying-glass
                        size="md"
                        class="absolute left-4 top-1/2 size-5 -translate-y-1/2 text-on-surface/50 dark:text-on-surface-dark/50" />
                    <x-input
                        variant="search"
                        class="w-full rounded-none! border-x-0! border-t-0! focus:outline-none! focus-visible:border-primary focus-visible:outline-none!"
                        name="searchField"
                        aria-label="{{ __('Search') }}"
                        x-on:input="getFilteredOptions($el.value)"
                        x-ref="searchField"
                        placeholder="{{ $searchPlaceholder }}" />
                </div>
            @endif

            <li
                class="hidden px-4 py-2 text-sm text-on-surface dark:text-on-surface-dark"
                x-ref="noResultsMessage">
                <span>{{ __('No matches found') }}</span>
            </li>

            <li
                x-show="allOptions.length === 0"
                class="px-4 py-8 text-center text-sm text-on-surface/60 dark:text-on-surface-dark/60">
                <span>{{ $emptyStateMessage }}</span>
            </li>

            <template x-for="(item, index) in options" x-bind:key="item.{{ $valueKey }}">
                <li
                    class="combobox-option inline-flex items-center justify-between gap-6 bg-surface-alt px-4 py-2 text-sm text-on-surface hover:bg-surface-dark-alt/5 hover:text-on-surface-strong focus-visible:bg-surface-dark-alt/5 focus-visible:text-on-surface-strong focus-visible:outline-hidden dark:bg-surface-dark-alt dark:text-on-surface-dark dark:hover:bg-surface-alt/5 dark:hover:text-on-surface-dark-strong dark:focus-visible:bg-surface-alt/10 dark:focus-visible:text-on-surface-dark-strong"
                    role="option"
                    x-on:click="toggleOption(item)"
                    x-on:keydown.enter="toggleOption(item)"
                    x-bind:id="'option-' + index"
                    tabindex="0">
                    @isset($optionContent)
                        {{ $optionContent }}
                    @else
                        <div class="flex min-w-0 flex-1 items-center gap-2">
                            @if ($imageKey)
                                <template x-if="item.{{ $imageKey }}">
                                    <img
                                        x-bind:src="item.{{ $imageKey }}"
                                        x-bind:alt="item.{{ $displayKey }}"
                                        class="h-4.5 w-6 shrink-0 object-cover" />
                                </template>
                            @endif
                            <div class="flex min-w-0 flex-1 flex-col">
                                <span
                                    class="truncate"
                                    x-bind:class="isSelected(item) ? 'font-bold' : null"
                                    x-text="item.{{ $displayKey }}"></span>
                                @if ($secondaryDisplayKey)
                                    <span class="truncate text-xs" x-text="item.{{ $secondaryDisplayKey }}"></span>
                                @endif
                            </div>
                        </div>
                        <x-icons.check
                            size="md"
                            x-cloak
                            x-show="isSelected(item)"
                            strokeWidth="2" />
                    @endisset
                </li>
            </template>
        </ul>
    </div>
</div>
