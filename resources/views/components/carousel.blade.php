@props([
    'slides' => [
        [
            'imgSrc' => '/images/carousel-slide-1.webp',
            'imgAlt' => 'Vibrant abstract painting with swirling blue and light pink hues on a canvas.',
            'title' => 'Front end developers',
            'description' =>
                'The architects of the digital world, constantly battling against their mortal enemy – browser compatibility.',
            'ctaUrl' => 'https://example.com',
            'ctaText' => 'Become a Developer',
        ],
        [
            'imgSrc' => '/images/carousel-slide-2.webp',
            'imgAlt' => 'Vibrant abstract painting with swirling red, yellow, and pink hues on a canvas.',
            'title' => 'Back end developers',
            'description' =>
                'Because not all superheroes wear capes, some wear headphones and stare at terminal screens',
            'ctaUrl' => 'https://example.com',
            'ctaText' => 'Become a Developer',
        ],
        [
            'imgSrc' => '/images/carousel-slide-3.webp',
            'imgAlt' => 'Vibrant abstract painting with swirling blue and purple hues on a canvas.',
            'title' => 'Full stack developers',
            'description' => 'Where "burnout" is just a fancy term for "Tuesday".',
            'ctaUrl' => 'https://example.com',
            'ctaText' => 'Become a Developer',
        ],
    ],
    'startIndex' => 1,
    'autoplay' => false,
    'interval' => 5000,
])

<div x-data="{
    slides: @js($slides),
    currentSlideIndex: {{ (int) $startIndex }},
    autoplay: {{ $autoplay ? 'true' : 'false' }},
    interval: {{ (int) $interval }},
    timer: null,

    previous() {
        this.currentSlideIndex =
            this.currentSlideIndex > 1 ?
            this.currentSlideIndex - 1 :
            this.slides.length;
    },

    next() {
        this.currentSlideIndex =
            this.currentSlideIndex < this.slides.length ?
            this.currentSlideIndex + 1 :
            1;
    },

    startAutoplay() {
        if (!this.autoplay) return;
        this.stopAutoplay();
        this.timer = setInterval(() => this.next(), this.interval);
    },

    stopAutoplay() {
        if (this.timer) clearInterval(this.timer);
    },

    toggleAutoplay() {
        this.autoplay = !this.autoplay;
        this.autoplay ? this.startAutoplay() : this.stopAutoplay();
    }
}" x-init="startAutoplay()" {{ $attributes->class('relative w-full overflow-hidden') }}>
    <!-- previous button -->
    <button type="button"
        class="absolute left-5 top-1/2 z-20 flex -translate-y-1/2 items-center justify-center rounded-full bg-surface/40 p-2 text-on-surface transition hover:bg-surface/60 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary active:outline-offset-0 dark:bg-surface-dark/40 dark:text-on-surface-dark dark:hover:bg-surface-dark/60 dark:focus-visible:outline-primary-dark"
        aria-label="previous slide" x-on:click="previous()">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-width="3"
            class="size-5 pr-0.5 md:size-6" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
        </svg>
    </button>

    <!-- next button -->
    <button type="button"
        class="absolute right-5 top-1/2 z-20 flex -translate-y-1/2 items-center justify-center rounded-full bg-surface/40 p-2 text-on-surface transition hover:bg-surface/60 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary active:outline-offset-0 dark:bg-surface-dark/40 dark:text-on-surface-dark dark:hover:bg-surface-dark/60 dark:focus-visible:outline-primary-dark"
        aria-label="next slide" x-on:click="next()">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" fill="none"
            stroke-width="3" class="size-5 pl-0.5 md:size-6" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
        </svg>
    </button>

    <!-- slides -->
    <div class="relative min-h-[50svh] w-full rounded-radius overflow-hidden">
        <template x-for="(slide, index) in slides" :key="index">
            <div x-cloak x-show="currentSlideIndex === index + 1" class="absolute inset-0"
                x-transition.opacity.duration.1000ms>

                <div
                    class="absolute inset-0 z-10 flex flex-col items-center justify-end gap-2 bg-linear-to-t from-surface-dark/85 to-transparent px-16 py-12 text-center lg:px-32 lg:py-14">

                    <h3 class="w-full text-balance text-2xl font-bold text-on-surface-dark-strong lg:w-[80%] lg:text-3xl"
                        x-text="slide.title" x-bind:aria-describedby="'slide' + (index + 1) + 'Description'"></h3>

                    <p class="w-full text-pretty text-sm text-on-surface-dark lg:w-1/2" x-text="slide.description"
                        x-bind:id="'slide' + (index + 1) + 'Description'"></p>

                    <button type="button" x-cloak x-show="slide.ctaUrl !== null"
                        class="mt-2 whitespace-nowrap rounded-radius border border-on-surface-dark-strong bg-transparent px-4 py-2 text-center text-xs font-medium tracking-wide text-on-surface-dark-strong transition hover:opacity-75 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-on-surface-dark-strong active:opacity-100 active:outline-offset-0 md:text-sm"
                        x-text="slide.ctaText"></button>
                </div>

                <img class="absolute inset-0 h-full w-full object-cover text-on-surface dark:text-on-surface-dark"
                    x-bind:src="slide.imgSrc" x-bind:alt="slide.imgAlt" />
            </div>
        </template>
    </div>

    <!-- indicators -->
    <div class="absolute bottom-3 left-1/2 z-20 flex -translate-x-1/2 gap-4 rounded-radius px-1.5 py-1 md:bottom-5 md:gap-3 md:px-2"
        role="group" aria-label="slides">
        <template x-for="(slide, index) in slides" :key="'dot-' + index">
            <button class="size-2 rounded-full transition" x-on:click="currentSlideIndex = index + 1"
                x-bind:class="[currentSlideIndex === index + 1 ? 'bg-neutral-300' : 'bg-neutral-300/50']"
                x-bind:aria-label="'slide ' + (index + 1)"></button>
        </template>
    </div>

    <!-- Pause / Play button -->
    <template x-if="slides.length > 1 && {{ $autoplay ? 'true' : 'false' }}">
        <button x-on:click="toggleAutoplay()"
            class="absolute bottom-3 right-3 md:bottom-5 md:right-5 z-20 flex items-center justify-center cursor-pointer rounded-full bg-surface/40 p-2 text-on-surface transition hover:bg-surface/60 dark:hover:bg-surface-dark/60 dark:bg-surface-dark/40 dark:text-on-surface-dark"
            x-bind:aria-label="autoplay ? 'Pause autoplay' : 'Resume autoplay'">
            <!-- Pause icon -->
            <x-icons.pause x-cloak x-show="autoplay" aria-hidden="true" variant="mini" size="sm" />

            <!-- Play icon -->
            <x-icons.play x-cloak x-show="!autoplay" aria-hidden="true" variant="mini" size="sm" />
        </button>
    </template>

</div>
