@props(['post' => null])

<div
    {{ $attributes->merge(['class' => 'flex flex-col p-4 gap-2 bg-surface-alt/75 dark:bg-surface-dark-alt/75 rounded-radius']) }}>
    @if ($post->image_url && $post->image_url !== '')
        <div class="rounded-radius ">
            <img class="h-auto w-full border border-outline/20 dark:border-outline-dark/20 rounded-radius object-cover"
                src="{{ $post->image_url }}" alt="{{ $post->title }}">
        </div>
    @endif

    <div class="flex flex-col gap-2.5 p-1.5">
        @isset($post->title)
            @isset($post->slug)
                <a href="{{ route('posts.show', ['slug' => $post->slug]) }}">
                    <h3 class="heading-6 text-on-surface-strong dark:text-on-surface-dark-strong">{{ __($post->title) }}</h3>
                </a>
            @else
                <h3 class="heading-4">{{ __($post->title) }}</h3>
            @endisset
        @endisset

        @isset($post->description)
            <p class="text-sm ">{{ __($post->description) }}</p>
        @endisset

        @isset($post->created_at)
            @php
                $timezone = auth()->user()?->timezone ?? 'America/New_York';
                $formattedDate = $post->created_at->copy()->setTimezone($timezone)->format('M d, Y');
            @endphp
            <x-badge variant="outline">{{ $formattedDate }}</x-badge>
        @endisset
    </div>
</div>
