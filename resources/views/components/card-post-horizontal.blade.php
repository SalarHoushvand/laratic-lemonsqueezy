@props(['post' => null])

<div class="flex flex-col md:flex-row gap-4 border border-outline dark:border-outline-dark rounded-radius p-4">
    @isset($post->image_url)
        <img class="h-52 w-full md:w-80 flex-shrink-0 rounded-radius object-cover" src="{{ $post->image_url }}"
            alt="{{ $post->title }}" />
    @endisset

    <div class="flex flex-col justify-center gap-2 md:w-3/5 md:max-w-md">
        @isset($post->created_at)
            <small class="flex w-full items-center justify-between">
                <div>{{ $post->created_at->format('M d, Y') }}</div>
            </small>
        @endisset

        @isset($post->title)
            @isset($post->slug)
                <a href="{{ route('posts.show', ['slug' => $post->slug]) }}" class="hover:underline">
                    <h3 class="heading-4">{{ __($post->title) }}</h3>
                </a>
            @else
                <h3 class="heading-5">{{ __($post->title) }}</h3>
            @endisset
        @endisset

        @isset($post->description)
            <p class="text-sm text-on-surface/70 dark:text-on-surface-dark/70">
                {{ __($post->description) }}
            </p>
        @endisset

        @isset($post->author)
            <small class="flex w-full items-center justify-between">
                <div>By {{ $post->author }}</div>
            </small>
        @endisset
    </div>
</div>

