@props([
    'img' => null,
    'name' => null,
    'description' => null,
    'price' => null,
    'currency' => null,
    'href' => null,
    'buttonLabel' => __('View'),
    'isFeatured' => false,
])

<article
    class="panel group flex justify-between gap-4 rounded-radius text-on-surface dark:text-on-surface-dark w-full xl:max-w-lg min-h-24 {{ $isFeatured ? 'bg-primary/10 dark:bg-primary-dark/10' : '' }}">
    <!-- Thumbnail -->
    @if ($img)
        <div class="shrink-0 my-auto">
            <div class="size-20 overflow-hidden rounded-lg">
                <img src="{{ $img }}" class="h-full w-full object-cover"
                    alt="{{ __('Image of :product', ['product' => $name]) }}" />
            </div>
        </div>
    @else
        <div class="shrink-0 my-auto">
            <div class="size-20 overflow-hidden flex items-center justify-center rounded-lg bg-surface-dark/5 p-2 text-on-surface dark:bg-surface/10 dark:text-on-surface-dark">
                <x-icons.shopping-bag variant="solid" size="lg" />
            </div>
        </div>
    @endif

    <!-- Title + Description -->
    <div class="min-w-0 flex-1">
        <h3 class="heading-7 text-on-surface-strong dark:text-on-surface-dark-strong truncate font-medium"
            aria-describedby="productDescription">
            {{ $name }}
        </h3>
        <div id="productDescription" class="mt-1 line-clamp-2 text-sm text-on-surface/80 dark:text-on-surface-dark/80 prose prose-sm dark:prose-invert max-w-none">
            {!! $description !!}
        </div>
    </div>

    <!-- Price + CTA -->
    <div class="flex shrink-0 self-stretch flex-col items-end justify-between gap-2">
        <span class="text-sm font-semibold">
            <span class="sr-only size-0">{{ __('Price') }}</span>
            {{ is_null($price) ? '' : Number::currency($price / 100, $currency) }}
        </span>

        @if ($href)
            <x-button href="{{ $href }}" :variant="$isFeatured ? 'primary' : 'inverse'" size="xs">
                {{ $buttonLabel }}
            </x-button>
        @endif
    </div>
</article>
