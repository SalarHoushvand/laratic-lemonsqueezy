@php
    $themes = [
        'arctic',
        'christmas',
        'halloween',
        'highContrast',
        'industrial',
        'laratic',
        'minimal',
        'modern',
        'neoBrutalism',
        'news',
        'pastel',
        'prototype',
        'retro',
        'zombie',
    ];

    // Create mixed array of light and dark variants
    $mixedThemes = [];
    foreach ($themes as $theme) {
        $mixedThemes[] = ['name' => $theme, 'variant' => 'light'];
        $mixedThemes[] = ['name' => $theme, 'variant' => 'dark'];
    }
    shuffle($mixedThemes);
@endphp

<div x-data="{
    interval: 3500,
    timer: null,

    start() {
        this.stop();

        this.timer = setInterval(() => {
            const track = this.$refs.track;

            if (!track) {
                return;
            }

            const firstCard = track.querySelector('[data-theme-card]');

            if (!firstCard) {
                return;
            }

            const cardWidth = firstCard.offsetWidth;
            const gap = 24; // gap-6 = 24px on md screens
            const scrollAmount = cardWidth + gap;
            const maxScroll = track.scrollWidth - track.clientWidth;

            if (maxScroll <= 0) {
                return;
            }

            if (track.scrollLeft + scrollAmount >= maxScroll - 5) {
                track.scrollTo({ left: 0, behavior: 'smooth' });
            } else {
                track.scrollBy({ left: scrollAmount, behavior: 'smooth' });
            }
        }, this.interval);
    },

    stop() {
        if (this.timer) {
            clearInterval(this.timer);
            this.timer = null;
        }
    },

    init() {
        setTimeout(() => {
            this.start();
        }, 100);
    }
}" x-init="init()" x-on:mouseenter="stop()" x-on:mouseleave="start()"
    {{ $attributes->merge(['class' => 'p-0 md:p-8']) }}>
    <x-typography.guest-page-header
        title="{{ __('Beautiful Themes') }}"
        description="{{ __('Choose from a variety of stunning themes to match your style.') }}"
        size="h2"
        :divider-dots="true" />

    <div class="relative mx-auto w-full max-w-7xl mt-12 overflow-hidden">
        <div x-ref="track" class="themes-carousel-track flex flex-nowrap gap-4 md:gap-6 overflow-x-auto w-full" style="scroll-behavior: smooth;">
            @foreach ($mixedThemes as $item)
                <div data-theme-card
                    class="group relative rounded-radius overflow-hidden border border-outline dark:border-outline-dark cursor-pointer transition-all duration-300 hover:border-primary dark:hover:border-primary-dark min-w-[70%] sm:min-w-[45%] md:min-w-[30%]">
                    <div class="relative w-full h-auto overflow-hidden">
                        <img src="{{ asset("images/themes/themes-{$item['name']}-{$item['variant']}.webp") }}"
                            alt="{{ ucfirst($item['name']) }} theme ({{ $item['variant'] }})"
                            class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110"
                            loading="lazy" decoding="async">
                        {{-- Overlay on hover --}}
                        <div
                            class="absolute inset-0 bg-surface/50 dark:bg-surface-dark/50 backdrop-blur-sm opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                            <h3
                                class="text-lg md:text-xl font-bold text-on-surface-strong dark:text-on-surface-dark-strong text-center px-4">
                                {{ ucwords(str_replace(['-', '_'], ' ', preg_replace('/([a-z])([A-Z])/', '$1 $2', $item['name']))) }} ({{ ucfirst($item['variant']) }})
                            </h3>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Edge gradients for smooth fade --}}
        <div class="pointer-events-none absolute inset-y-0 left-0 w-16 bg-gradient-to-r from-surface dark:from-surface-dark to-transparent z-10"
            aria-hidden="true"></div>
        <div class="pointer-events-none absolute inset-y-0 right-0 w-16 bg-gradient-to-l from-surface dark:from-surface-dark to-transparent z-10"
            aria-hidden="true"></div>
    </div>
</div>

@once
    <style>
        .themes-carousel-track {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .themes-carousel-track::-webkit-scrollbar {
            display: none;
        }
    </style>
@endonce
