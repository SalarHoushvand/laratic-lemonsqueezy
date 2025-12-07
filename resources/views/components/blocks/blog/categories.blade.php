<div {{ $attributes }}>
    <div class="flex flex-wrap gap-2 w-full justify-center">
        <x-button variant="{{ request()->get('category') ? 'alternative' : 'primary' }}" size="sm" href="{{ route('blog') }}">
            <span class="text-sm">{{ __('All') }}</span>
        </x-button>
        @foreach ($categories as $category)
            <x-button variant="{{ request()->get('category') === $category->slug ? 'primary' : 'alternative' }}" size="sm" href="{{ route('blog', ['category' => $category->slug]) }}">
                <span class="text-sm">{{ $category->name }}</span>
            </x-button>
        @endforeach
    </div>
</div>
