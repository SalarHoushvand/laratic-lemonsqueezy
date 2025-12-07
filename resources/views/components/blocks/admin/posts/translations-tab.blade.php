@props(['post', 'translations' => [], 'availableLanguages' => [], 'isTranslating' => false])

@if ($post && $post->reference_number)
    <!-- Add new translation section -->
    @if (count($availableLanguages) > 0)
        <div class="panel space-y-4">
            <x-input-label for="selectedTranslationLanguage" :value="__('Add New Translation')" />
            @php
                $formattedOptions = collect($availableLanguages)
                    ->map(function ($lang) {
                        return [
                            'value' => $lang['code'],
                            'label' => $lang['name'],
                            'localName' => $lang['local_name'] ?? $lang['name'],
                            'flag' => 'https://flagcdn.com/' . $lang['flag'] . '.svg',
                        ];
                    })
                    ->values()
                    ->toArray();
            @endphp
            <div class="flex flex-col gap-3 xl:flex-row xl:items-end xl:gap-4">
                <div class="flex-1 min-w-0 xl:max-w-md">
                    <x-combobox
                        id="selectedTranslationLanguage"
                        wire:model.live="selectedTranslationLanguage"
                        wire:target="createTranslationWithAi, createManualTranslation, pollTranslationGeneration"
                        :options="$formattedOptions"
                        imageKey="flag"
                        displayKey="label"
                        secondaryDisplayKey="localName"
                        valueKey="value"
                        :placeholder="__('Select a language')" />
                </div>
                <div class="flex flex-col gap-2 md:flex-row md:flex-shrink-0">
                    <x-button type="button" wire:click="createManualTranslation" wire:loading.attr="disabled"
                        wire:target="createManualTranslation" variant="outline"
                        x-bind:disabled="$wire.selectedTranslationLanguage === '' || $wire.isTranslating"
                        class="w-full md:w-auto">
                        <span wire:loading.remove wire:target="createManualTranslation">
                            {{ __('Translate Manually') }}
                        </span>
                        <span wire:loading wire:target="createManualTranslation">
                            {{ __('Creating...') }}
                        </span>
                    </x-button>
                    <x-button type="button" wire:click="createTranslationWithAi" wire:loading.attr="disabled"
                        wire:target="createTranslationWithAi, pollTranslationGeneration"
                        x-bind:disabled="$wire.selectedTranslationLanguage === '' || $wire.isTranslating"
                        class="w-full md:w-auto">
                        <span x-show="!$wire.isTranslating" x-cloak>
                            <x-icons.sparkles variant="micro" size="sm" class="mr-1" />
                        </span>
                        <span x-show="$wire.isTranslating" x-cloak>
                            <x-icons.sparkle-animated variant="micro" size="sm" class="mr-1 fill-current" />
                        </span>
                        <span wire:loading.remove wire:target="createTranslationWithAi, pollTranslationGeneration">
                            {{ $isTranslating ? __('Translating...') : __('AI Translate') }}
                        </span>
                        <span wire:loading wire:target="createTranslationWithAi, pollTranslationGeneration">
                            {{ __('Translating...') }}
                        </span>
                    </x-button>
                </div>
            </div>
            <p class="text-xs text-on-surface/70 dark:text-on-surface-dark/70">
                {{ __('Manual translation creates an empty post with the same cover image. AI translation generates content automatically.') }}
            </p>
        </div>
    @endif

    <!-- Existing translations list -->
    <div>
        <p class="text-sm text-on-surface-muted dark:text-on-surface-dark-muted mb-3">{{ __('Existing Translations') }}</p>
        <div class="space-y-2">
            @if (count($translations) > 0)
                @foreach ($translations as $translation)
                    @php
                        $isCurrent = $post && $post->id === $translation['id'];
                        $languageConfig = config('languages', []);
                        $langData = $languageConfig[$translation['language']] ?? null;
                        $lang = $langData
                            ? ['name' => __($langData['name']), 'flag' => $langData['flag']]
                            : ['name' => strtoupper($translation['language']), 'flag' => $translation['language']];
                    @endphp
                    @if ($isCurrent)
                        <x-button variant="ghost" size="sm" class="w-full justify-start cursor-not-allowed"
                            disabled>
                            <img src="https://flagcdn.com/{{ $lang['flag'] }}.svg" alt="{{ $lang['name'] }}"
                                class="h-3.5 w-5 object-cover mr-2" />
                            <span class="truncate flex items-center gap-1">
                                <x-badge variant="primary" size="xxs">{{ __('Current') }}</x-badge>
                                {{ $lang['name'] }}: {{ $translation['title'] }}
                            </span>
                        </x-button>
                    @else
                        <x-button type="button" href="{{ route('admin.posts.edit', $translation['id']) }}" variant="ghost"
                            size="sm" class="w-full justify-start">
                            <img src="https://flagcdn.com/{{ $lang['flag'] }}.svg" alt="{{ $lang['name'] }}"
                                class="h-3.5 w-5 object-cover mr-2" />
                            <span class="truncate">
                                {{ $lang['name'] }}: {{ $translation['title'] }}
                            </span>
                        </x-button>
                    @endif
                @endforeach
            @else
                <div
                    class="rounded-lg border border-outline dark:border-outline-dark bg-surface-alt dark:bg-surface-dark-alt/50 p-4">
                    <p class="text-sm text-on-surface/70 dark:text-on-surface-dark/70 text-center">
                        {{ __('No translations available.') }}
                    </p>
                </div>
            @endif
        </div>
    </div>
@else
    <!-- No post reference number - show message -->
    <div class="space-y-4">
        <p class="text-sm text-on-surface/70 dark:text-on-surface-dark/70">
            {{ __('You need to create a post first to add translations.') }}
        </p>
    </div>
@endif
