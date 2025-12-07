@props(['blob' => 0])

<x-layouts.guest>
    @push('head')
        <title>Test Hero - {{ config('app.name') }}</title>
        <meta name="description" content="Test hero page for theme screenshots">
    @endpush
    <div class="relative  items-center justify-center overflow-hidden">
        <!-- Polka dot background -->
        <div class="hidden dark:block absolute inset-0 -z-10 bg-pattern pointer-events-none opacity-30"
            aria-hidden="true"></div>
        <!-- Main Content -->
        <div class="mx-auto my-8">
            @if ($blob)
                <div class="absolute -z-10 -top-30 left-1/2 h-40 w-80 -translate-x-1/2 rounded-full bg-primary opacity-30 blur-[60px] dark:bg-primary-dark"
                    aria-hidden="true"></div>
            @endif
            <!-- Content -->
            <div class="mx-auto flex flex-col items-center text-center gap-6 w-full max-w-3xl pt-16">
                <x-badge class="rounded-full!" size="xs">
                    <x-icons.clock variant="micro" size="sm" class="text-primary dark:text-primary-dark" />
                    <span>{{ __('Save Months of Development Time') }}</span>
                </x-badge>
                <!-- Heading -->
                <h1 class="heading-1 text-balance">
                    {{ __('Build your') }} <span
                        class="text-primary dark:text-primary-dark">{{ __('Laravel Apps') }}</span>
                    {{ __('Fast and ship them faster') }} <br>
                </h1>
                <!-- Description -->
                <p class="max-w-md text-on-surface-muted dark:text-on-surface-dark-muted">
                    {{ __('All-in-one Laravel starter kit for SaaS applications') }}
                </p>
                <!-- CTA Buttons -->
                <div class="flex items-center gap-4">
                    <x-button href="{{ route('login') }}" size="md">
                        {{ __('Let\'s Go') }}
                    </x-button>
                    <x-button href="#" variant="alternative" size="md">
                        {{ __('Explore Features') }}
                    </x-button>
                </div>
            </div>
        </div>

        @props([
            'logos' => [
                [
                    'name' => 'Laravel',
                    'url' => 'https://laravel.com',
                    'image' => 'laravel-logo.png',
                ],
                [
                    'name' => 'Livewire',
                    'url' => 'https://livewire.laravel.com/',
                    'image' => 'livewire-logo.png',
                ],
                [
                    'name' => 'Tailwind CSS',
                    'url' => 'https://tailwindcss.com',
                    'image' => 'tailwind-css-logo.png',
                ],
                [
                    'name' => 'Alpine.js',
                    'url' => 'https://alpinejs.dev/',
                    'image' => 'alpine-logo.png',
                ],
            ],
        ])
        <div {{ $attributes->merge(['class' => 'w-full']) }}>
            <div class="flex items-center justify-center gap-8 sm:gap-12 md:gap-16 flex-wrap">
                @foreach ($logos as $logo)
                    <img src="{{ asset('/images/' . $logo['image']) }}" alt="{{ $logo['name'] }}"
                        class="w-14 sm:w-16 md:w-20 h-auto dark:grayscale hover:grayscale-0 transition-all duration-200 z-1"
                        loading="lazy" decoding="async">
                @endforeach
            </div>
            <p class="text-xs text-on-surface-muted dark:text-on-surface-dark-muted text-center font-thin">
                {{ __('Built with TALL Stack') }}
            </p>
        </div>

        <div class="p-8">

            <div class="relative mx-auto w-full max-w-2xl xl:max-w-4xl" x-data="{
                lightImages: [
                    { src: '{{ asset('images/temp/dashboard-industrial-light.jpg') }}', caption: '{{ __('Admin Dashboard with a lof of useful metrics.') }}' },
                ],
                darkImages: [
                    { src: '{{ asset('images/temp/dashboard-industrial-dark.jpg') }}', caption: '{{ __('Admin Dashboard with a lof of useful metrics.') }}' },
                 
                ],
                lightIndex: 0,
                darkIndex: 0,
                init() {
                    setInterval(() => {
                        if (this.lightImages.length > 0) {
                            this.lightIndex = (this.lightIndex + 1) % this.lightImages.length;
                        }
                        if (this.darkImages.length > 0) {
                            this.darkIndex = (this.darkIndex + 1) % this.darkImages.length;
                        }
                    }, 5000);
                }
            }">
                <div
                    class="relative p-2 md:p-6 bg-surface-alt/25 dark:bg-surface-dark-alt/5 rounded-radius backdrop-blur-md border border-outline dark:border-outline-dark">
                    {{-- Light theme figure --}}
                    <figure class="dark:hidden">
                        <div class="relative aspect-[21/10]">
                            <template x-for="(image, index) in lightImages" x-key="index">
                                <img x-bind:src="image.src" x-bind:alt="image.caption"
                                    class="w-full h-full rounded-border border border-outline dark:border-outline-dark/50 absolute inset-0 transition-opacity duration-500"
                                    x-bind:class="lightIndex === index ? 'opacity-95' : 'opacity-0'" loading="lazy"
                                    decoding="async" width="1920" height="1080">
                            </template>
                        </div>
                        <figcaption
                            class="mt-2 italic text-sm text-on-surface-muted dark:text-on-surface-dark-muted transition-opacity duration-500 sr-only"
                            x-text="lightImages[lightIndex].caption"></figcaption>
                    </figure>
                    {{-- Dark theme figure --}}
                    <figure class="hidden dark:block">
                        <div class="relative aspect-[21/10]">
                            <template x-for="(image, index) in darkImages" x-key="index">
                                <img x-bind:src="image.src" x-bind:alt="image.caption"
                                    class="w-full h-full rounded-border border border-outline dark:border-outline-dark/50 absolute inset-0 transition-opacity duration-500"
                                    x-bind:class="darkIndex === index ? 'opacity-95' : 'opacity-0'" loading="lazy"
                                    decoding="async" width="1920" height="1080">
                            </template>
                        </div>
                        <figcaption
                            class="mt-2 italic text-sm text-on-surface-muted dark:text-on-surface-dark-muted transition-opacity duration-500 sr-only"
                            x-text="darkImages[darkIndex].caption"></figcaption>
                    </figure>
                </div>

                @if ($blob)
                <div class="absolute rounded-full -z-10 w-full h-full top-[45%] left-[50%] -translate-x-1/2 -translate-y-1/2 bg-primary dark:bg-primary-dark opacity-25 dark:opacity-30 blur-[80px]"
                        aria-hidden="true">
                    </div>
                @endif
            </div>
        </div>
        {{-- / Hero --}}

    </div>
</x-layouts.guest>
