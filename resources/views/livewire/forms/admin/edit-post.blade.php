<div class="w-full" x-data="{ tab: 'content' }">
    {{-- Poll for translation generation completion status --}}
    @if ($isTranslating)
        <div wire:poll.8s="pollTranslationGeneration" class="hidden" aria-hidden="true"></div>
    @endif

    <form wire:submit="save">
        <div class="flex flex-col gap-6 lg:grid lg:grid-cols-12">
            {{-- Main content area --}}
            <div class="col-span-12 lg:col-span-8">
                {{-- Title input --}}
                <div class="mb-6">
                    <x-input-label for="title" :value="__('Title')" class="sr-only" />
                    <x-input id="title" wire:model="title" type="text" required autofocus
                        class="w-full text-2xl! font-medium! border-t-0! border-x-0! bg-transparent! rounded-none! focus:border-outline! focus:ring-0! focus:outline-0! focus-visible:outline-0! focus-visible:border-b-primary! dark:focus:border-b-primary-dark!"
                        placeholder="{{ __('Enter title here...') }}" />
                    <x-input-error :messages="$errors->get('title')" class="mt-1" />
                </div>

                {{-- Form tabs --}}
                <div class="mb-4">
                    <x-tabs :items="[
                        ['slug' => 'content', 'label' => __('Content'), 'icon' => 'icons.document-text'],
                        ['slug' => 'cover', 'label' => __('Cover'), 'icon' => 'icons.photo'],
                        ['slug' => 'meta', 'label' => __('Meta & SEO')],
                        ['slug' => 'translations', 'label' => __('Translations'), 'icon' => 'icons.language'],
                        ['slug' => 'ai-usage', 'label' => __('AI Usage'), 'icon' => 'icons.sparkles'],
                    ]" model="tab" aria-label="{{ __('Post form tabs') }}"
                        panel-prefix="tabpanel-" />
                </div>

                {{-- Content tab panel --}}
                <div x-show="tab === 'content'" x-cloak id="tabpanel-content" class="space-y-6" role="tabpanel"
                    aria-label="content">
                    <div class="space-y-4">
                        {{-- Description field --}}
                        <div>
                            <x-input-label for="description" :value="__('Description')" />
                            <x-text-area wire:model="description" id="description" class="mt-1 block w-full"
                                rows="3" placeholder="{{ __('Write a short description for the post...') }}" />
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        {{-- Markdown editor (wire:ignore prevents Livewire from interfering with external editor scripts) --}}
                        <div wire:ignore>
                            <x-input-label for="content-editor" :value="__('Content (Markdown)')" class="mb-1" />
                            <input type="hidden" id="contentHidden" wire:model="content" />
                            <x-text-area id="content-editor"
                                class="block w-full min-h-64 text-on-surface dark:text-on-surface-dark *:border-outline *:dark:border-outline-dark :bg-surface-alt *:dark:bg-surface-dark-alt"
                                rows="12"
                                placeholder="{{ __('Write markdown here...') }}">{{ $content }}</x-text-area>
                            <x-input-error :messages="$errors->get('content')" class="mt-2" />
                        </div>
                    </div>
                </div>

                {{-- Cover image tab panel --}}
                <div x-show="tab === 'cover'" x-cloak id="tabpanel-cover" class="space-y-6" role="tabpanel"
                    aria-label="cover">
                    <div class="space-y-3">
                        <x-input-file wire:model="uploadedImage" label="{{ __('Upload Cover Image') }}" :error="$errors->has('uploadedImage')" :error-message="$errors->get('uploadedImage')" />
                        <x-input-label for="image_url" :value="__('Image URL')" />
                        <x-input wire:model.blur="image_url" id="image_url" class="mt-1 block w-full"
                            placeholder="https://..." />
                        <x-input-error :messages="$errors->get('image_url')" class="mt-2" />

                        {{-- Image preview area --}}
                        <div
                            class="rounded-radius border border-dashed border-outline dark:border-outline-dark bg-transparent p-2 text-center">
                            @if (filled($image_url))
                                <div x-data="{ err: false }">
                                    <img x-show="!err" x-on:error="err = true" src="{{ $image_url }}"
                                        alt="{{ $title ? $title . ' image' : __('Image preview') }}"
                                        class="mx-auto w-full h-auto rounded-radius" />
                                    <div x-show="err" class="text-sm text-on-surface dark:text-on-surface-dark">
                                        {{ __('Could not load image. Check the URL.') }}
                                    </div>
                                </div>
                            @else
                                <div class="text-sm text-on-surface dark:text-on-surface-dark">
                                    {{ __('Upload an image or paste a URL above') }}
                                </div>
                                <div class="mt-2 text-xs text-on-surface/70 dark:text-on-surface-dark/70">
                                    {{ __('Or paste an image URL in the input above') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Meta & SEO tab panel --}}
                <div x-show="tab === 'meta'" x-cloak id="tabpanel-meta" class="space-y-6" role="tabpanel"
                    aria-label="meta">
                    <div class="p-4 space-y-3 text-on-surface dark:text-on-surface-dark">
                        <p class="text-sm">
                            {{ __("You're all set here! We'll create necessary SEO and meta tags using the post details.") }}
                        </p>
                        <ul class="list-disc pl-6 text-sm text-on-surface/70 dark:text-on-surface-dark/70 space-y-1">
                            <li>{{ __('Schema.org structured data') }}</li>
                            <li>{{ __('Social meta tags (Twitter Cards)') }}</li>
                            <li>{{ __('Standard meta tags (title, description)') }}</li>
                            <li>{{ __('Canonical URL') }}</li>
                            <li>{{ __('Open Graph tags (og:*)') }}</li>
                        </ul>
                    </div>
                </div>

                {{-- Translations tab panel --}}
                <div x-show="tab === 'translations'" x-cloak id="tabpanel-translations" class="space-y-6"
                    role="tabpanel" aria-label="translations">
                    <x-blocks.admin.posts.translations-tab :post="$post" :translations="$this->translations" :available-languages="$availableLanguages"
                        :is-translating="$isTranslating" />
                </div>

                {{-- AI Usage tab panel --}}
                <x-blocks.admin.posts.ai-usage-tab :livewire="$this" />
            </div>

            {{-- Sidebar with publish controls --}}
            <div class="col-span-12 lg:col-span-4">
                <div class="space-y-6">
                    {{-- Publish settings panel --}}
                    <div class="panel">
                        <div class="flex items-center justify-between gap-2">
                            <div class="flex items-center gap-2">
                                @if ($post->slug)
                                    {{-- Preview button --}}
                                    <x-tooltip :text="__('Preview')" position="top">
                                        <x-button href="{{ route('posts.show', $post->slug) }}" variant="outline"
                                            target="_blank" rel="noopener noreferrer">
                                            <x-icons.eye variant="outline" size="sm" />
                                            <span class="sr-only"> {{ __('Preview') }}</span>
                                        </x-button>
                                    </x-tooltip>
                                @endif
                                {{-- Delete button --}}
                                <x-modal-trigger target="delete-post-{{ $post->id }}">
                                    <x-tooltip :text="__('Delete')" position="top">
                                        <x-button variant="outline" type="button">
                                            <x-icons.trash variant="outline" size="sm" />
                                            <span class="sr-only"> {{ __('Delete') }}</span>
                                        </x-button>
                                    </x-tooltip>
                                </x-modal-trigger>
                            </div>
                            <div class="ml-auto flex flex-col items-center space-y-0.5">
                                <x-button type="submit" class=" min-w-32 opacity-75"
                                    wire:dirty.class="opacity-100!">
                                    <span class="flex items-center gap-1" wire:dirty.remove><x-icons.check variant="mini" size="sm" /></span>
                                    <span class="flex items-center gap-1" wire:dirty.remove>{{ __('Saved') }}</span>
                                    <span wire:dirty>{{ __('Save Changes') }}</span>
                                </x-button>

                            </div>

                        </div>
                        <div class="space-y-4 w-full *:w-full mt-8">
                            {{-- Slug field --}}
                            <div>
                                <x-input-label for="slug" :value="__('Slug')" />
                                <x-input wire:model="slug" id="slug" class="mt-1 block w-full" type="text"
                                    placeholder="{{ __('post-slug-example') }}" />
                                <small class="text-xs text-on-surface-muted dark:text-on-surface-dark-muted">
                                    {{ __('Leave empty to generate automatically') }}
                                </small>
                                <x-input-error :messages="$errors->get('slug')" class="mt-2" />
                            </div>
                            <div class="w-full space-y-1">
                                <x-toggle id="is_active" :withContainer="true" wire:model="is_active"
                                    label="{{ __('Published') }}" label-position="left" class="w-full" />
                                @if (!$post->is_active)
                                    <p class="text-xs text-warning">
                                        {{ __('This post is not published yet.') }}
                                    </p>
                                @endif
                            </div>
                            <x-toggle id="is_promoted" :withContainer="true" wire:model="is_promoted"
                                label="{{ __('Promoted') }}" label-position="left" />
                        </div>
                    </div>
                    {{-- Categories field panel --}}
                    <livewire:admin.posts.categories-select :post="$post" />

                    {{-- Author field panel --}}
                    <div class="panel">
                        <x-input-label for="author" :value="__('Author')" />
                        <x-input wire:model="author" id="author" class="mt-1 block w-full" type="text" />
                        <x-input-error :messages="$errors->get('author')" class="mt-2" />
                    </div>

                </div>
            </div>
        </div>
    </form>

    <!-- Delete post modal: Confirmation dialog for post deletion -->
    <x-modal maxWidth="lg" name="delete-post-{{ $post->id }}">
        <x-slot:header>
            <p class="font-medium text-on-surface-strong dark:text-on-surface-dark-strong">
                {{ __('You are about to delete a post permanently.') }}
            </p>
        </x-slot:header>

        <!-- Modal content: Warning message and post details -->
        <div class="space-y-2 p-4">
            <p class="text-sm font-medium text-on-surface dark:text-on-surface-dark">
                {{ __('Post:') }} <span class="font-semibold">{{ $post->title }}</span>
            </p>
            <p class="text-sm text-on-surface dark:text-on-surface-dark">
                {{ __('Once you delete the post, you can no longer recover it. This action cannot be undone.') }}
            </p>
        </div>

        <x-slot:footer>
            <!-- Cancel button: Closes the modal -->
            <x-button variant="ghost" type="button" x-on:click="modalIsOpen = false" class="w-full md:w-fit">
                {{ __('Cancel') }}
            </x-button>

            <!-- Delete button: Confirms and executes post deletion -->
            <x-button variant="danger" type="button" wire:click="delete" wire:loading.attr="disabled" class="w-full md:w-fit">
                <span wire:loading.remove wire:target="delete">
                    {{ __('Delete Post') }}
                </span>
                <span wire:loading wire:target="delete">
                    {{ __('Deleting...') }}
                </span>
            </x-button>
        </x-slot:footer>
    </x-modal>
</div>
