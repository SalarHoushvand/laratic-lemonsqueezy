@php
    $lightImages = [
        ['src' => asset('images/homepage-slideshow/slide-1-light.webp'), 'caption' => __('Admin Dashboard with a lof of useful metrics.')],
        ['src' => asset('images/homepage-slideshow/slide-2-light.webp'), 'caption' => __('Blog translations with AI powered translation.')],
        ['src' => asset('images/homepage-slideshow/slide-3-light.webp'), 'caption' => __('AI chat interface .')],
        ['src' => asset('images/homepage-slideshow/slide-4-light.webp'), 'caption' => __('Manage subscriptions with Lemon Squeezy payments.')],
        ['src' => asset('images/homepage-slideshow/slide-5-light.webp'), 'caption' => __('Manage users.')],
        ['src' => asset('images/homepage-slideshow/slide-7-light.webp'), 'caption' => __('Manage users.')],
        ['src' => asset('images/homepage-slideshow/slide-8-light.webp'), 'caption' => __('Manage users.')],
        ['src' => asset('images/homepage-slideshow/slide-9-light.webp'), 'caption' => __('Manage users.')],
        ['src' => asset('images/homepage-slideshow/slide-10-light.webp'), 'caption' => __('Manage users.')],
        ['src' => asset('images/homepage-slideshow/slide-11-light.webp'), 'caption' => __('Manage users.')],
        ['src' => asset('images/homepage-slideshow/slide-12-light.webp'), 'caption' => __('Manage users.')],
    ];

    $darkImages = [
        ['src' => asset('images/homepage-slideshow/slide-1-dark.webp'), 'caption' => __('Admin Dashboard with a lof of useful metrics.')],
        ['src' => asset('images/homepage-slideshow/slide-2-dark.webp'), 'caption' => __('Blog translations with AI powered translation.')],
        ['src' => asset('images/homepage-slideshow/slide-3-dark.webp'), 'caption' => __('AI chat interface .')],
        ['src' => asset('images/homepage-slideshow/slide-4-dark.webp'), 'caption' => __('Manage subscriptions with Lemon Squeezy payments.')],
        ['src' => asset('images/homepage-slideshow/slide-5-dark.webp'), 'caption' => __('Manage users.')],
        ['src' => asset('images/homepage-slideshow/slide-7-dark.webp'), 'caption' => __('Manage users.')],
        ['src' => asset('images/homepage-slideshow/slide-8-dark.webp'), 'caption' => __('Manage users.')],
        ['src' => asset('images/homepage-slideshow/slide-9-dark.webp'), 'caption' => __('Manage users.')],
        ['src' => asset('images/homepage-slideshow/slide-10-dark.webp'), 'caption' => __('Manage users.')],
        ['src' => asset('images/homepage-slideshow/slide-11-dark.webp'), 'caption' => __('Manage users.')],
        ['src' => asset('images/homepage-slideshow/slide-12-dark.webp'), 'caption' => __('Manage users.')],
    ];
@endphp

<div {{ $attributes->merge(['class' => 'p-2 mt-2 md:mt-0 md:p-8']) }}>

    <div class="relative mx-auto w-full max-w-2xl xl:max-w-4xl" x-data="{
        lightImages: @js($lightImages),
        darkImages: @js($darkImages),
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

        <div class="absolute rounded-full -z-10 w-full h-full top-[45%] left-[50%] -translate-x-1/2 -translate-y-1/2 bg-primary dark:bg-primary-dark opacity-25 dark:opacity-30 blur-[80px]"
            aria-hidden="true">
        </div>
    </div>
</div>
{{-- / Hero --}}
