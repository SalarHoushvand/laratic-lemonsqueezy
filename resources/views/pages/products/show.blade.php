@push('head')
    <title>{{ __(':product - Checkout', ['product' => $product->name]) }}</title>
@endpush

<x-layouts.app :sidebar="false" :subscribeBanner="false" :padding="false">

    <div>
        <nav
            class="sticky top-0 z-30 py-3 border-b backdrop-blur-md bg-surface-alt border-outline px-4 dark:border-outline-dark dark:bg-surface-dark-alt">
            <div class="flex items-center justify-between mx-auto px-6 max-w-7xl 2xl:max-w-7xl">
                <!-- Brand Logo -->
                <a href="{{ route('dashboard') }}" class="inline-flex">
                    <x-app-logo class="w-24" />
                    <span class="sr-only">{{ __('Home') }}</span>
                </a>
            </div>
        </nav>

        <!-- Background Blur Effect -->
        <div class="absolute z-5 -top-20 left-1/2 h-40 w-80 -translate-x-1/2 rounded-full bg-primary opacity-30 blur-[60px] dark:bg-primary-dark"
            aria-hidden="true"></div>


        <div>
            <div class="flex flex-col items-center justify-center gap-4 md:min-h-[80svh] pb-10 mt-8">
                <article
                    class="flex w-full max-w-xl flex-col gap-6 rounded-radius md:border border-outline p-8 dark:border-outline-dark dark:bg-transparent md:mt-10">
                    <!-- Plan Details -->
                    <div class="flex justify-start  w-full items-start gap-4">

                        <!-- Image -->
                        @if ($product->img_url)
                            <img src="{{ $product->img_url }}" class="rounded-radius size-28 object-cover shrink-0"
                                alt="{{ $product->name }}" />
                        @endif

                        <div>
                            <p class="heading-4 text-on-surface-strong dark:text-on-surface-dark-strong">
                                {{ __($product->name) }}
                            </p>

                            <div class="flex flex-col ">
                                <span class="text-xl">
                                    <span class="sr-only">{{ __('Price') }}</span>
                                    <div class="flex flex-col gap-2">
                                        <span class="text-3xl font-bold text-primary dark:text-primary-dark">
                                            {{ Number::currency($product->price / 100, $product->currency) }}
                                        </span>
                                        <small class="text-xs text-on-surface-muted dark:text-on-surface-dark-muted">
                                            {{ __('one-time payment') }}
                                        </small>
                                    </div>
                                </span>
                            </div>
                        </div>

                    </div>



                    <!-- Checkout Actions -->
                    <div class="flex flex-col gap-2">
                        <x-lemon-button :href="$checkout"
                            class="rounded-radius flex items-center gap-2 justify-center bg-primary px-4 py-2 text-center text-on-primary dark:bg-primary-dark dark:text-on-primary-dark"
                            dark>
                            {{ __('Secure Checkout') }}
                        </x-lemon-button>

                        <p
                            class="inline-flex items-center gap-1 text-xs text-on-surface/80 dark:text-on-surface-dark/80">
                            <x-icons.lock-closed variant="solid" size="xs" />
                            <span>
                                {{ __('Secure payment powered by') }}
                                <a class="text-primary dark:text-primary-dark inline" href="https://lemon.squeezy.com"
                                    target="_blank" rel="noopener noreferrer">
                                    Lemon Squeezy
                                </a>
                            </span>
                        </p>
                    </div>

                    <div class="mt-1 text-sm text-on-surface/80 dark:text-on-surface-dark/80 prose prose-sm dark:prose-invert max-w-none">
                        {!! $product->description !!}
                    </div>

                    <!-- Features List -->
                    @if ($product->features)
                        <div class="flex flex-col gap-1.5 md:gap-2">
                            @foreach ($product->features as $feature)
                                <div class="flex items-center gap-2 text-xs md:text-sm">
                                    <div
                                        class="p-0.5 rounded-radius bg-surface-dark/5 text-on-surface dark:bg-surface/10 dark:text-on-surface-dark">
                                        <x-icons.check variant="micro" size="sm" class="shrink-0" />
                                    </div>
                                    <span
                                        class="text-on-surface-muted dark:text-on-surface-dark-muted">{{ __($feature) }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <a class="inline-flex items-center gap-2 text-primary dark:text-primary-dark"
                        href="{{ route('products.index') }}">
                        <x-icons.arrow-left strokeWidth="2" size="sm" />
                        {{ __('Back to Products') }}
                    </a>
                </article>
            </div>
        </div>
    </div>
</x-layouts.app>
