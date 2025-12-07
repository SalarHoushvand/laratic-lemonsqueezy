@props(['post' => null])

<div {{ $attributes->merge(['class' => 'flex flex-col gap-2 border border-outline dark:border-outline-dark rounded-radius p-4']) }}>
    @if($post->image_url && $post->image_url !== '')
        <img class="h-44 w-full rounded-radius object-cover" src="{{ $post->image_url }}" alt="{{ $post->title }}">
    @endif

    @if (isset($post->author) || isset($post->created_at))
        <small class="mt-8 flex w-full items-center justify-between">
            <div>{{ $post->created_at->format('M d, Y') }}</div>
        </small>
    @endif

    @isset($post->title)
        @isset($post->slug)
            <a href="{{ route('posts.show', ['slug' => $post->slug]) }}" class="hover:underline">
                <h3 class="heading-4">{{ __($post->title) }}</h3>
            </a>
        @else
            <h3 class="heading-4">{{ __($post->title) }}</h3>
        @endisset
    @endisset
    @isset($post->description)
        <p class="text-sm text-on-surface/70 dark:text-on-surface-dark/70">{{ __($post->description) }}</p>
    @endisset
</div>

