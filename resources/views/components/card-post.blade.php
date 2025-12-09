@props(['post' => null])

<div
    {{ $attributes->merge(['class' => 'flex flex-col p-4  gap-2 bordser border-outline dark:border-outline-dark bg-surface-alt/75 dark:bg-surface-dark-alt/75 rounded-radius']) }}>
    @if ($post->image_url && $post->image_url !== '')
        <div class="rounded-radius ">
            <img class="h-auto w-full border border-outline dark:border-outline-dark/20 rounded-radius object-cover"
                src="{{ $post->image_url }}" alt="{{ $post->title }}">
        </div>
    @endif

    <div class="flex flex-col gap-2.5 p-1.5">
        @isset($post->title)
            @isset($post->slug)
                <a href="{{ route('posts.show', ['slug' => $post->slug]) }}" class="hover:underline">
                    <h3 class="heading-6 text-on-surface-strong dark:text-on-surface-dark-strong">{{ __($post->title) }}</h3>
                </a>
            @else
                <h3 class="heading-4">{{ __($post->title) }}</h3>
            @endisset
        @endisset

        @isset($post->description)
            <p class="text-sm ">{{ __($post->description) }}</p>
        @endisset

        {{-- @if (isset($post->created_at))
            <small class="flex items-center gap-1 text-on-surface-muted dark:text-on-surface-dark-muted">
                <x-icons.calendar-days variant="micro" size="sm" />
                {{ $post->created_at->format('M d, Y') }}
            </small>
        @endif --}}
    </div>
</div>
