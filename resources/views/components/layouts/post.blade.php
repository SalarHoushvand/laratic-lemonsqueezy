@props(['post', 'relatedPosts', 'isUnpublished' => false])

@push('head')
    <title>{{ __($post->title) }} - {{ config('app.name') }}</title>
    <meta name="description" content="{{ __($post->description) }}">

    {{-- Open Graph meta tags for social media sharing --}}
    <meta property="og:title" content="{{ __($post->title) }}" />
    <meta property="og:description" content="{{ __($post->description) }}" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="{{ url()->current() }}" />
    @if ($post->image_url)
        <meta property="og:image" content="{{ $post->image_url }}" />
        <meta property="og:image:alt" content="{{ __($post->title) }}" />
    @endif

    <link rel="canonical" href="{{ url()->current() }}" />

    {{-- JSON-LD structured data for search engines --}}
    @php
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => __($post->title),
            'description' => __($post->description),
            'url' => url()->current(),
            'datePublished' => $post->created_at->toIso8601String(),
            'dateModified' => ($post->updated_at ?? $post->created_at)->toIso8601String(),
            'publisher' => [
                '@type' => 'Organization',
                'name' => config('app.name'),
                'url' => config('app.url'),
            ],
        ];

        if ($post->author) {
            $schema['author'] = [
                '@type' => 'Person',
                'name' => $post->author,
            ];
        }

        if ($post->image_url) {
            $schema['image'] = $post->image_url;
        }
    @endphp
    <script type="application/ld+json">
        {!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
@endpush

<x-layouts.guest>
    <div>
        @if ($isUnpublished)
            <livewire:admin.posts.publish-post-banner :post="$post" />
        @endif

        <div class="flex flex-col p-16 gap-4 max-w-3xl mx-auto">
            <div class="flex items-center justify-between">
                <small>
                    {{ $post->created_at->format('M d, Y') }}
                </small>
                <x-share-widget>
                    <x-slot name="trigger">
                        <button type="button" title="{{ __('share') }}"
                            class="rounded-full p-1 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary active:outline-offset-0 dark:focus-visible:outline-primary-dark"
                            x-on:click="share()">
                            <x-icons.arrow-up-on-square />
                            <span class="sr-only">{{ __('share') }}</span>
                        </button>
                    </x-slot>
                </x-share-widget>
            </div>

            {{ $slot }}

            @if ($relatedPosts->isNotEmpty())
                <div class="flex flex-col py-16 gap-8 max-w-3xl mx-auto">
                    <h2 class="heading-4 mb-4">{{ __('Read Similar') }}</h2>
                    @foreach ($relatedPosts as $relatedPost)
                        <div class="flex flex-col md:flex-row items-center gap-4">
                            @if ($relatedPost->image_url)
                                <img class="rounded-radius w-full h-auto max-w-48"
                                    src="{{ $relatedPost->image_url }}"
                                    alt="{{ __($relatedPost->title) }}">
                            @endif
                            <div class="w-full flex flex-col gap-2">
                                <span class="text-xs text-on-surface-muted dark:text-on-surface-dark-muted">{{ $relatedPost->created_at->format('M d') }}</span>
                                <a href="{{ route('posts.show', $relatedPost->slug) }}">
                                    <h3 class="heading-5">{{ __($relatedPost->title) }}</h3>
                                </a>
                                @if ($relatedPost->description)
                                    <p class="text-sm text-on-surface-muted dark:text-on-surface-dark-muted">{{ __($relatedPost->description) }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <x-blocks.blog.newsletter id="newsletter-signup" class="mx-auto my-12" />
</x-layouts.guest>
