<x-layouts.post :post="$post" :relatedPosts="$relatedPosts" :isUnpublished="$isUnpublished ?? false">
    <article class="prose prose-sm sm:prose-base prose-headings:font-title font-body dark:prose-invert max-w-2xl mx-auto">
        @if ($post->image_url)
            <img class="w-full max-h-96 rounded-radius object-cover mb-6" src="{{ $post->image_url }}" alt="{{ $post->title }}">
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


