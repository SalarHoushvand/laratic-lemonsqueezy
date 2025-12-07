<div id="chat-container"
    class="relative h-full"
    @if ($streamingId) wire:poll.250ms="pullChunks" @endif
    data-i18n='{{ json_encode([
        'copyTitle' => __('Copy'),
        'copyAria' => __('Copy'),
        'copySr' => __('Copy the response to clipboard'),
    ]) }}'>

    <div class="flex flex-col h-full w-full min-h-0">
        @if ($streamingId)
            <!-- Top glow -->
            <div
                class="pointer-events-none select-none absolute inset-x-0 -top-2.5 h-6 bg-gradient-to-r from-primary/25 via-primary/90 to-primary/25 dark:from-primary-dark/25 dark:via-primary-dark/75 dark:to-primary-dark/25 blur-xl z-1 animate-pulse">
            </div>
        @endif

        {{-- EMPTY STATE (no scroll) --}}
        @if (count($messages) === 0)
            <div class="flex-1 flex items-end px-8 pt-8">
                <div
                    class="mx-auto w-full max-w-full sm:max-w-2xl md:max-w-3xl lg:max-w-5xl flex flex-col items-center gap-4 mb-4 text-on-surface dark:text-on-surface-dark">

                    <x-icons.ai-orb size="size-20 md:size-24" />

                    <p class="text-center text-2xl font-thin">
                        {{ __('How can I help you today?') }}
                    </p>
                </div>
            </div>
        @else
            {{-- SCROLLER (only when we actually have messages) --}}
            <div id="chatScroll" class="flex-1 min-h-0 overflow-y-auto px-8 pt-8 pb-8">
                <div
                    class="mx-auto flex flex-col gap-3 max-w-full sm:max-w-2xl md:max-w-3xl lg:max-w-5xl w-full">

                    {{-- Chat bubbles --}}
                    @foreach ($messages as $message)
                        @if ($message['role'] === 'user')
                            {{-- USER MESSAGE --}}
                            <div class="flex justify-end">
                                <div
                                    class="w-fit max-w-full sm:max-w-3xl rounded-2xl rounded-tr-none dark:bg-surface-dark-alt py-2 px-4 text-on-surface dark:text-on-surface-dark border border-outline dark:border-outline-dark">
                                    <div x-data
                                        class="markdown-content prose prose-sm sm:prose-base dark:prose-invert max-w-none leading-relaxed break-words prose-pre:text-sm prose-pre:p-2 prose-pre:bg-surface-dark-alt prose-pre:rounded-radius prose-pre:border-none prose-pre:shadow-none prose-code:bg-transparent!"
                                        x-html="renderMarkdown(@js($message['content']))">
                                    </div>
                                </div>
                            </div>
                        @else
                            {{-- ASSISTANT MESSAGE --}}
                            <div class="flex justify-start">
                                <div
                                    class="w-fit pl-1 md:pl-2 max-w-full sm:max-w-3xl text-on-surface dark:text-on-surface-dark">
                                    <div class="mb-2 flex items-center gap-2">
                                        <x-avatar variant="primary" size="sm" class="p-3">
                                            <x-icons.robot variant="solid" size="md" class="shrink-0" />
                                        </x-avatar>
                                        <span class="text-sm font-bold">{{ __('AI Assistant') }}</span>
                                    </div>

                                    @php
                                        $isStreamingThis =
                                            isset($message['id']) &&
                                            $streamingId === $message['id'] &&
                                            trim((string) ($message['content'] ?? '')) === '';
                                    @endphp

                                    @if ($isStreamingThis)
                                        {{-- Streaming indicator --}}
                                        <div class="flex items-center gap-1 pt-2 pl-8">
                                            <span
                                                class="size-1.5 rounded-full bg-on-surface motion-safe:animate-[bounce_1s_ease-in-out_infinite] dark:bg-on-surface-dark"></span>
                                            <span
                                                class="size-1.5 rounded-full bg-on-surface motion-safe:animate-[bounce_0.5s_ease-in-out_infinite] dark:bg-on-surface-dark"></span>
                                            <span
                                                class="size-1.5 rounded-full bg-on-surface motion-safe:animate-[bounce_1s_ease-in-out_infinite] dark:bg-on-surface-dark"></span>
                                        </div>
                                    @else
                                        <div x-data
                                            class="markdown-content prose prose-sm sm:prose-base dark:prose-invert max-w-none leading-relaxed break-words prose-pre:text-sm prose-pre:p-2 prose-pre:bg-surface-dark-alt prose-pre:rounded-radius prose-pre:border-none prose-pre:shadow-none prose-code:bg-transparent!"
                                            x-html="renderMarkdown(@js($message['content']))">
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @endforeach

                </div>
            </div>
        @endif

        <!-- COMPOSER -->
        <div
            class="pointer-events-auto sticky bottom-0 inset-x-0 pb-4 z-1 bg-surface dark:bg-surface-dark px-8">

            <div x-data="{ text: '' }"
                class="mx-auto w-full max-w-full sm:max-w-2xl md:max-w-3xl lg:max-w-5xl rounded-radius border border-outline bg-surface-alt text-on-surface dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark has-focus:border-primary dark:has-focus:border-primary-dark">

                <div class="relative p-2">
                    <p class="peer scroll-on max-h-44 w-full overflow-y-auto px-2 py-1 focus:outline-hidden break-words"
                        role="textbox" aria-label="{{ __('Message to AI') }}" x-ref="editable" contenteditable
                        x-on:input="text = $el.innerText"
                        x-on:paste.prevent="document.execCommand('insertText', false, $event.clipboardData.getData('text/plain'))">
                    </p>

                    <div x-show="(text || '').trim() === ''"
                        class="pointer-events-none absolute left-2 top-2 select-none text-on-surface dark:text-on-surface-dark text-sm sm:text-base opacity-50 peer-focus:hidden">
                        {{ __('Ask AI anything...') }}
                    </div>
                </div>

                <div class="flex w-full items-center justify-end gap-2 px-2.5 py-2">
                    @if ($streamingId)
                        {{-- STOP while streaming --}}
                        <x-button type="button" variant="primary" size="sm" wire:click="stop">
                            <span class="flex items-center justify-center gap-2">
                                <x-icons.stop variant="solid" size="sm" />
                                <span>{{ __('Stop') }}</span>
                            </span>
                        </x-button>
                    @else
                        {{-- SEND when idle --}}
                        <x-button type="button" variant="primary" size="sm"
                            x-on:click="
                                const val = ($refs.editable.innerText || '').trim();
                                if (val.length === 0) return;
                                $wire.set('input', val);
                                $wire.send();
                                $refs.editable.innerText = '';
                                text = '';
                            "
                            wire:loading.attr="disabled">
                            <span class="flex items-center justify-center gap-2">
                                <x-icons.paper-airplane variant="solid" size="sm" />
                                <span>{{ __('Send') }}</span>
                            </span>
                        </x-button>
                    @endif
                </div>
            </div>

            <p class="text-xs pl-1 pt-2 max-w-full sm:max-w-2xl md:max-w-3xl lg:max-w-5xl mx-auto">
                {{ __('Powered by') }} <a href="https://openai.com" target="_blank"
                    class="text-primary dark:text-primary-dark">OpenAI</a>
            </p>
        </div>
    </div>
</div>

@push('scripts')
    @vite(['resources/js/chat.js'])
@endpush
