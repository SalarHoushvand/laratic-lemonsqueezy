<div class="w-full" x-data="{ tab: 'content' }">
    {{-- Poll for AI generation completion status --}}
    @if ($isGenerating)
        <div wire:poll.8s="pollAiGeneration" class="hidden" aria-hidden="true"></div>
    @endif

    <form wire:submit="save">
        <div class="flex flex-col gap-6 lg:grid lg:grid-cols-12">
            {{-- Main content area --}}
            <div class="col-span-12 lg:col-span-8">
                {{-- Title input --}}
                <div class="mb-4">
                    <x-input-label for="title" :value="__('Title')" class="sr-only" />
                    <x-input id="title" wire:model="title" type="text" required autofocus class="w-full text-2xl! font-medium! border-t-0! border-x-0! bg-transparent! rounded-none! focus:border-outline! focus:ring-0! focus:outline-0! focus-visible:outline-0! focus-visible:border-b-primary! dark:focus:border-b-primary-dark!" placeholder="{{ __('Enter title here...') }}" />
                    @if (App::getLocale() !== 'en')
                        <p class="text-sm text-warning mt-1">
                            {{ __('Your language is set to a non-English language. This post will be created in English. After saving, you can translate it to other languages.') }}
                        </p>
                    @endif
                    <x-input-error :messages="$errors->get('title')" class="mt-1" />
                </div>

                {{-- Form tabs --}}
                <div class="mb-4">
                    <x-tabs :items="[
                        ['slug' => 'content', 'label' => __('Content'), 'icon' => 'icons.document-text'], 
                        ['slug' => 'cover', 'label' => __('Cover'), 'icon' => 'icons.photo'], 
                        ['slug' => 'meta', 'label' => __('Meta & SEO')]]" 
                        model="tab" aria-label="{{ __('Post form tabs') }}" panel-prefix="tabpanel-" />
                </div>

                {{-- Content tab panel --}}
                <div x-show="tab === 'content'" x-cloak id="tabpanel-content" class="space-y-6" role="tabpanel" aria-label="content">
                    <div class="space-y-4">
                        {{-- Description field --}}
                        <div>
                            <x-input-label for="description" :value="__('Description')" />
                            <x-text-area wire:model="description" id="description" class="mt-1 block w-full" rows="3" placeholder="{{ __('Write a short description for the post...') }}" />
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        {{-- Markdown editor (wire:ignore prevents Livewire from interfering with external editor scripts) --}}
                        <div wire:ignore>
                            <x-input-label for="content-editor" :value="__('Content (Markdown)')" class="mb-1" />
                            <input type="hidden" id="contentHidden" wire:model="content" />
                            <x-text-area id="content-editor" class="block w-full min-h-64 text-on-surface dark:text-on-surface-dark *:border-outline *:dark:border-outline-dark :bg-surface-alt *:dark:bg-surface-dark-alt" rows="12" placeholder="{{ __('Write markdown here...') }}">{{ $content }}</x-text-area>
                            <x-input-error :messages="$errors->get('content')" class="mt-2" />
                        </div>
                    </div>
                </div>

                {{-- Cover image tab panel --}}
                <div x-show="tab === 'cover'" x-cloak id="tabpanel-cover" class="space-y-6" role="tabpanel" aria-label="cover">
                    <div class="space-y-3">
                        <x-input-file label="{{ __('Upload Cover Image') }}" target="image_url" :component-id="$this->getId()" name="image_url" :error="$errors->has('image_url')" :error-message="$errors->get('image_url')" />
                        <x-input-label for="image_url" :value="__('Image URL')" />
                        <x-input wire:model.blur="image_url" id="image_url" class="mt-1 block w-full" type="url" placeholder="https://..." />
                        <x-input-error :messages="$errors->get('image_url')" class="mt-2" />

                        {{-- Image preview area --}}
                        <div class="rounded-radius border border-dashed border-outline dark:border-outline-dark bg-transparent p-2 text-center">
                            @if (filled($image_url))
                                <div x-data="{ err: false }">
                                    <img x-show="!err" x-on:error="err = true" src="{{ $image_url }}" alt="{{ $title ? $title . ' image' : __('Image preview') }}" class="mx-auto w-full h-90 rounded-radius object-cover" />
                                    <div x-show="err" class="text-sm text-on-surface dark:text-on-surface-dark">
                                        {{ __('Could not load image. Check the URL.') }}
                                    </div>
                                </div>
                            @else
                                <div class="text-sm text-on-surface dark:text-on-surface-dark">
                                    {{ __('Upload an image with Cloudinary') }}
                                </div>
                                <div class="mt-2 text-xs text-on-surface/70 dark:text-on-surface-dark/70">
                                    {{ __('Or paste an image URL in the input above') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Meta & SEO tab panel --}}
                <div x-show="tab === 'meta'" x-cloak id="tabpanel-meta" class="space-y-6" role="tabpanel" aria-label="meta">
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
            </div>

            {{-- Sidebar with publish controls --}}
            <div class="col-span-12 lg:col-span-4">
                <div class="lg:sticky lg:top-6 space-y-6">
                    {{-- Publish settings panel --}}
                    <div class="panel">
                        <div class="flex items-center justify-between gap-2">
                            <x-button type="submit" class="ml-auto min-w-32 w-full">
                               <x-icons.plus variant="mini" size="sm" /> {{ __('Create Post') }}
                            </x-button>
                        </div>
                        <div class="space-y-4 w-full *:w-full mt-8">
                            {{-- Slug field --}}
                            <div>
                                <x-input-label for="slug" :value="__('Slug')" />
                                <x-input wire:model="slug" id="slug" class="mt-1 block w-full" type="text" placeholder="{{ __('post-slug-example') }}" />
                                <small class="text-xs text-on-surface-muted dark:text-on-surface-dark-muted">
                                    {{ __('Leave empty to generate automatically') }}
                                </small>
                                <x-input-error :messages="$errors->get('slug')" class="mt-2" />
                            </div>
                            <x-toggle id="is_active" :withContainer="true" wire:model="is_active" label="{{ __('Published') }}" label-position="left" />
                            <x-toggle id="is_promoted" :withContainer="true" wire:model="is_promoted" label="{{ __('Promoted') }}" label-position="left" />
                        </div>
                    </div>

                    {{-- Categories field panel --}}
                    <div class="panel">
                        <x-input-label :value="__('Categories')" />
                        <p class="text-sm text-on-surface-muted dark:text-on-surface-dark-muted">
                            {{ __('Save your first draft to assign categories to this post.') }}
                        </p>
                    </div>

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

    {{-- AI Prompt Input (fixed at bottom, appears when showAiPrompt is true) --}}
    <div class="fixed inset-x-0 bottom-6 z-50 mx-auto w-full max-w-5xl px-4" wire:show="showAiPrompt" wire:cloak x-trap="$wire.showAiPrompt" x-on:click.outside="$wire.toggleAiPrompt()" x-on:keydown.escape="$wire.toggleAiPrompt()" x-transition:enter="transition ease-in duration-150" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4">
        <div class="relative w-full">
            <label for="aiPrompt" class="sr-only">{{ __('AI Prompt') }}</label>

            {{-- Sparkle icons (static/animated based on generation state) --}}
            <span x-show="!$wire.isGenerating" x-cloak>
                <x-icons.sparkles variant="micro" size="sm" class="absolute z-1 left-3 top-1/2 size-4 -translate-y-1/2 fill-primary dark:fill-primary-dark" />
            </span>
            <span x-show="$wire.isGenerating" x-cloak>
                <x-icons.sparkle-animated variant="micro" size="sm" class="absolute z-1 left-3 top-1/2 size-4 -translate-y-1/2 fill-primary dark:fill-primary-dark" />
            </span>

            <input id="aiPrompt" type="text" class="w-full bg-surface-alt/75 backdrop-blur-sm border border-outline rounded-radius px-2 py-4 pl-10 pr-32 text-on-surface focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary disabled:cursor-not-allowed disabled:opacity-75 dark:border-outline-dark dark:bg-surface-dark-alt/50 dark:text-on-surface-dark dark:focus-visible:outline-primary-dark shadow-md" name="prompt" placeholder="{{ __('What would you like to write about?') }}" wire:model="aiPrompt" />

            <div class="absolute right-3 top-1/2 -translate-y-1/2 flex items-center gap-2">
                <x-button type="button" size="md" wire:click="generateWithAi" wire:loading.attr="disabled" x-bind:disabled="$wire.isGenerating">
                    <span wire:loading.remove wire:target="generateWithAi, pollAiGeneration">
                        {{ $isGenerating ? __('Generating...') : __('Generate') }}
                    </span>
                    <span wire:loading wire:target="generateWithAi, pollAiGeneration">
                        {{ __('Generating...') }}
                    </span>
                </x-button>
            </div>
        </div>
    </div>

    {{-- Floating AI Orb Button (opens prompt input when clicked) --}}
    <button type="button" wire:click="toggleAiPrompt" wire:show="!showAiPrompt" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-20" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 scale-105" x-transition:leave-end="opacity-0 scale-20" class="fixed bottom-6 right-8 z-40 rounded-full cursor-pointer transition focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary hover:opacity-90" aria-label="AI Prompt">
        <x-icons.ai-orb class="size-24" />
    </button>
</div>
