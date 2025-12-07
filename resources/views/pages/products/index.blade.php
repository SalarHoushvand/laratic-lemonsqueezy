@push('head')
    <title>{{ __('Products') }} - {{ config('app.name') }}</title>
@endpush

<x-layouts.app>
    <div class="p-8">
        <x-typography.admin-page-header :title="__('Products')" :description="__('One-time payments products available for purchase.')" />

        @if ($products?->count() > 0)
            <div class="flex flex-wrap gap-6">
                @foreach ($products as $product)
                    <x-card-ecommerce :img="$product->img_url" :name="$product->name" :description="$product->description" :price="$product->price"
                        :currency="$product->currency" :href="route('products.show', $product->lemon_squeezy_variant_id)" :isFeatured="$product->is_featured" />
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <x-blocks.empty-state icon="shopping-bag" class="h-[50svh]" title="{{ __('No Products') }}"
                description="{{ __('Looks like there are no one-time payment products available yet.') }}" />
        @endif
    </div>
</x-layouts.app>
