@props(['post' => null])

<div
    {{ $attributes->merge(['class' => 'flex flex-col lg:flex-row gap-4 bg-surface-alt/75 dark:bg-surface-dark-alt/75 rounded-radius p-4']) }}>
    @if ($post->image_url && $post->image_url !== '')
        <img class="h-auto w-full lg:max-w-lg border border-outline/20 dark:border-outline-dark/20 rounded-radius "
            src="{{ $post->image_url }}" alt="{{ $post->title }}" />
    @endif

    <div class="flex flex-col justify-center gap-4 p-1.5 md:w-3/5 md:max-w-md">

        @isset($post->created_at)
            @php
                $timezone = auth()->user()?->timezone ?? 'America/New_York';
                $formattedDate = $post->created_at->copy()->setTimezone($timezone)->format('M d, Y');
            @endphp
            <x-badge variant="outline-primary">{{ $formattedDate }}</x-badge>
        @endisset

        @isset($post->title)
            @isset($post->slug)
                <a href="{{ route('posts.show', ['slug' => $post->slug]) }}" >
                    <h3 class="heading-5 sm:heading-4 md:heading-3 text-on-surface-strong dark:text-on-surface-dark-strong">{{ __($post->title) }}</h3>
                </a>
            @else
                <h3 class="heading-4">{{ __($post->title) }}</h3>
            @endisset
        @endisset

        @isset($post->description)
            <p class="text-sm">
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
