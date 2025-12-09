<x-layouts.post :post="$post" :relatedPosts="$relatedPosts" :isUnpublished="$isUnpublished ?? false">
    <article
        class="prose prose-sm sm:prose-base prose-headings:font-title font-body dark:prose-invert prose-img:rounded-radius prose-img:border prose-img:border-outline dark:prose-img:border-outline-dark prose-img:w-full prose-img:h-auto prose-video:rounded-radius prose-video:border prose-video:border-outline dark:prose-video:border-outline-dark prose-video:w-full prose-video:h-auto max-w-2xl mx-auto">
        @if ($post->image_url)
            <div class="p-2 sm:p-4 border border-outline dark:border-outline-dark rounded-radius mb-6 bg-surface-alt/25 dark:bg-surface-dark-alt/25 backdrop-blur-sm">
                <img class="w-full h-auto rounded-radius border border-outline/50 dark:border-outline-dark/50 p-0! m-0!"
                    src="{{ $post->image_url }}" alt="{{ $post->title }}">
            </div>
        @endif

        <h1 class="mb-2">{{ __($post->title) }}</h1>
        @if ($post->author)
            <p class="text-on-surface/70 dark:text-on-surface-dark/70 text-sm mb-6">
                {{ $post->author }}
            </p>
        @endif

        <div x-data class="markdown-content" x-html="renderMarkdown(@js($post->content ?? ''))"></div>
    </article>

    @push('scripts')
        <!-- Chat script because it's using the same markdown renderer as the blog index -->
        @vite(['resources/js/chat.js'])
    @endpush
</x-layouts.post>
