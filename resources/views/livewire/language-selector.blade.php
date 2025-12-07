{{-- Prepare available locales and current locale data --}}
@php
    $currentLocale = app()->getLocale();
    $languages = config('languages', []);
    $availableLocales = collect($languages)
        ->map(function ($lang, $code) {
            return [
                'label' => __($lang['name']),
                'name' => __($lang['name']),
                'local_name' => $lang['local_name'] ?? $lang['name'],
                'url' => $code,
                'ISO' => $lang['flag'],
            ];
        })
        ->toArray();
    // Fallback to current locale, then English, then first available locale
    $currentLocaleData =
        $availableLocales[$currentLocale] ?? ($availableLocales['en'] ?? collect($availableLocales)->first());
@endphp

<div x-data="{ isOpen: false, openedWithKeyboard: false }" class="relative flex w-fit max-w-xs flex-col gap-1"
    x-on:keydown.esc.window="isOpen = false, openedWithKeyboard = false">
    {{-- Screen reader label --}}
    <span class="sr-only">{{ __('Language') }}</span>

    <div class="relative">
        {{-- Language selector trigger button --}}
        <x-button variant="ghost" class="p-0!" size="xs" type="button" role="combobox" aria-haspopup="listbox"
            aria-controls="languageList" aria-label="{{ __('language selection') }}" x-on:click="isOpen = !isOpen"
            x-on:keydown.down.prevent="openedWithKeyboard = true" x-on:keydown.enter.prevent="openedWithKeyboard = true"
            x-on:keydown.space.prevent="openedWithKeyboard = true" x-bind:aria-expanded="isOpen || openedWithKeyboard">
            <span class="sr-only">{{ __('current language:') }}
                {{ $currentLocaleData['label'] ?? __('English') }}</span>
            <img src="{{ 'https://flagcdn.com/' . ($currentLocaleData['ISO'] ?? 'gb') . '.svg' }}" alt=""
                class="h-4 w-6 object-cover" aria-hidden="true">
        </x-button>

        {{-- Language dropdown menu --}}
        <ul x-cloak x-show="isOpen || openedWithKeyboard" id="languageList"
            class="absolute right-0 top-6 z-10 flex w-full min-w-32 max-h-56 flex-col items-center overflow-hidden overflow-y-auto rounded-radius border border-outline bg-surface-alt py-1.5 dark:border-outline-dark dark:bg-surface-dark-alt"
            role="listbox" aria-label="{{ __('language selection') }}"
            x-on:click.outside="isOpen = false, openedWithKeyboard = false"
            x-on:keydown.down.prevent="$focus.wrap().next()" x-on:keydown.up.prevent="$focus.wrap().previous()"
            x-transition x-trap="openedWithKeyboard">
            @foreach ($availableLocales as $locale)
                <li class="combobox-option inline-flex w-full items-center justify-between gap-6 bg-surface-alt text-sm text-on-surface hover:bg-surface-dark-alt/5 hover:text-on-surface-strong focus-visible:bg-surface-dark-alt/5 focus-visible:text-on-surface-strong focus-visible:outline-hidden dark:bg-surface-dark-alt dark:text-on-surface-dark dark:hover:bg-surface-alt/5 dark:hover:text-on-surface-dark-strong dark:focus-visible:bg-surface-alt/10 dark:focus-visible:text-on-surface-dark-strong"
                    role="option">
                    <button class="w-full px-3 py-1 cursor-pointer" wire:click="switchLocale('{{ $locale['url'] }}')" wire:loading.attr="disabled" wire:target="switchLocale">
                        <div class="flex items-center gap-3">
                            <img class="h-3.5 w-5 object-cover"
                                src="{{ 'https://flagcdn.com/' . $locale['ISO'] . '.svg' }}" alt=""
                                aria-hidden="true">
                            <div class="flex flex-col text-left">
                                <span class="text-xs font-medium">{{ $locale['label'] }}</span>
                                <span class="text-xs text-on-surface-muted dark:text-on-surface-dark-muted">{{ $locale['local_name'] }}</span>
                            </div>
                        </div>
                    </button>
                </li>
            @endforeach
        </ul>
    </div>
</div>
