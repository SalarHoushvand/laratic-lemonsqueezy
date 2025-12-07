<div class="space-y-6 min-h-64 max-h-96 overflow-y-auto px-6 pb-6" x-data="{ activeTab: 'existing', activeLang: '{{ $this->defaultLang }}' }" x-on:tags-updated.window="activeTab = 'existing'">
    {{-- Main Tabs --}}
    <div class="mb-4">
        <x-tabs :items="[
            ['slug' => 'existing', 'label' => __('Existing Categories'), 'icon' => 'icons.list-bullet'], 
            ['slug' => 'create', 'label' => __('Create / Edit'), 'icon' => 'icons.plus']]" 
            model="activeTab" aria-label="{{ __('Category management tabs') }}" panel-prefix="category-tab-" />
    </div>

    {{-- Existing Categories Tab Panel --}}
    <div x-show="activeTab === 'existing'" x-cloak id="category-tab-existing" class="space-y-6" role="tabpanel" aria-label="{{ __('Existing Categories') }}">

        @if (count($this->categories) > 0)
            <div class="mb-3">
                <x-input variant="search" wire:model.live.debounce.300ms="search" placeholder="{{ __('Search categories...') }}" class="w-full text-xs" />
            </div>
        @endif
        <div class="max-h-32 overflow-y-auto flex flex-wrap gap-2">
            @forelse ($this->categories as $category)
                <x-badge variant="outline-default" size="sm">
                    <div class="flex justify-between items-center gap-4">
                        <span class="text-sm">{{ $category['label'] }}</span>
                        <div class="flex">
                            <x-button size="xs" variant="ghost" wire:click="edit({{ $category['id'] }})" x-on:click="activeTab = 'create'" class="p-1!"><x-icons.pencil variant="micro" size="sm" /></x-button>
                            <x-button x-data="{ clickNumber: 0 }" size="xs" type="button" variant="ghost" x-on:click.away="clickNumber = 0" class="p-1!" x-on:click="clickNumber++; clickNumber > 1 ? $wire.delete({{ $category['id'] }}) : null"><x-icons.trash variant="micro" size="sm" class="hover:text-danger transition-all duration-100" x-bind:class="clickNumber > 0 ? 'scale-150 text-danger' : ''" /></x-button>
                        </div>
                    </div>
                </x-badge>
            @empty
                <div class="text-sm text-on-surface-muted dark:text-on-surface-dark-muted text-center mx-auto py-4">
                    <span>{{ empty($search) ? __('No categories yet.') : __('No categories found.') }}</span>
                    <x-button size="xs" type="button" variant="outline" class="mt-3" x-on:click="activeTab = 'create'">
                        <span>{{ __('Create a new category') }}</span>
                    </x-button>
                </div>
            @endforelse
        </div>

    </div>

    {{-- Create/Edit Form Tab Panel --}}
    <div x-show="activeTab === 'create'" x-cloak id="category-tab-create" class="space-y-6" role="tabpanel" aria-label="{{ __('Create / Edit Category') }}">
        <div class="space-y-5">

            {{-- English (Master) name input --}}
            <div>
                <div class="flex items-center gap-2 mb-1.5">
                    <img src="{{ 'https://flagcdn.com/' . ($this->langs['en']['flag'] ?? 'gb') . '.svg' }}" alt="English (Master)" class="h-4 w-6 object-cover" aria-hidden="true">
                    <x-input-label for="category_name_en" :value="'English (Master)'" />
                </div>
                <x-input id="category_name_en" type="text" class="mt-1 block w-full" wire:model.defer="translations.en" placeholder="{{ __('English name') }}" required />
            </div>

            @if ($this->otherLangs->isNotEmpty())
                <div>
                    <x-tabs :items="$this->otherLangs->map(fn($lang, $code) => ['slug' => $code, 'label' => __($lang['name'])])->values()->all()" model="activeLang" aria-label="{{ __('Language tabs') }}" panel-prefix="category-lang-" />
                    @foreach ($this->otherLangs as $code => $lang)
                        <div x-show="activeLang === '{{ $code }}'" x-cloak id="category-lang-{{ $code }}" class="mt-3" role="tabpanel" aria-label="{{ __($lang['name']) }}">
                            <div class="flex items-center gap-2 mb-1.5">
                                <img class="h-4 w-6 object-cover" src="{{ 'https://flagcdn.com/' . $lang['flag'] . '.svg' }}" alt="" aria-hidden="true">
                                <x-input-label :for="'category_name_' . $code" :value="__($lang['name']) . ' (' . $lang['local_name'] . ')'" />
                            </div>
                            <x-input id="category_name_{{ $code }}" type="text" class="mt-1 block w-full" wire:model.defer="translations.{{ $code }}" placeholder="{{ __('Enter name in :lang', ['lang' => __($lang['name'])]) }}" />
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="flex items-center gap-2">
                <x-button wire:click="save" class="w-full md:w-fit">{{ $editingId ? __('Update') : __('Create') }}</x-button>
                @if ($editingId)
                    <x-button variant="outline" wire:click="cancelEdit" x-on:click="activeTab = 'existing'" class="w-full md:w-fit">{{ __('Cancel') }}</x-button>
                @endif
            </div>
        </div>
    </div>
</div>
