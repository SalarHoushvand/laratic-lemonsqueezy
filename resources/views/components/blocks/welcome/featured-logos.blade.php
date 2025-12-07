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
