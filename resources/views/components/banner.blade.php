@props([
    'variant' => 'default',
    'isDismissible' => false,
    'button' => null,
    'href' => null,
    'endDate' => null, // ISO 8601 format: '2025-12-31T23:59:59Z'
])

@php
    $variants = [
        'default' => 'border-outline bg-surface-alt text-on-surface dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark',
        'primary' => 'border-primary bg-primary/10 text-on-surface dark:border-primary-dark dark:bg-primary-dark/10 dark:text-on-surface-dark',
        'info' => 'border-info bg-info/10 text-on-surface dark:border-info dark:bg-info/10 dark:text-on-surface-dark',
        'success' => 'border-success bg-success/10 text-on-surface dark:border-success dark:bg-success/10 dark:text-on-surface-dark',
        'warning' => 'border-warning bg-warning/10 text-on-surface dark:border-warning dark:bg-warning/10 dark:text-on-surface-dark',
        'danger' => 'border-danger bg-danger/10 text-on-surface dark:border-danger dark:bg-danger/10 dark:text-on-surface-dark',
    ];

    $variantClasses = $variants[$variant] ?? $variants['default'];

    // Build the x-data attribute based on whether endDate is provided
    if ($endDate) {
        $xData = "{
        bannerIsVisible: true,
        days: 0,
        hours: 0,
        minutes: 0,
        seconds: 0,
        init() {
                const target = new Date('{$endDate}').getTime();
            const update = () => {
                const diff = target - Date.now();
                if (diff <= 0) {
                    this.bannerIsVisible = false;
                    return;
                }
                const totalSeconds = Math.floor(diff / 1000);
                this.days = Math.floor(totalSeconds / 86400);
                this.hours = Math.floor((totalSeconds % 86400) / 3600);
                this.minutes = Math.floor((totalSeconds % 3600) / 60);
                this.seconds = totalSeconds % 60;
            };
            update();
            setInterval(update, 1000);
        }
        }";
    } else {
        $xData = '{ bannerIsVisible: true }';
    }
@endphp

<div
    x-data="{{ $xData }}"
    x-cloak
    x-show="bannerIsVisible"
    {{ $attributes->class(['relative flex border-b backdrop-blur-md p-4', $variantClasses]) }}>
    <div class="mx-auto flex flex-wrap items-center gap-3 px-6">
        <p class="text-xs text-pretty sm:text-sm">{{ $slot }}</p>

        @if ($endDate)
            {{-- Countdown Timer --}}
            <div class="flex items-center gap-1.5">
                {{-- Desktop view --}}
                <div class="hidden items-center gap-1.5 md:flex">
                    <div class="bg-black/10 rounded px-2 py-0.5 min-w-[2.5rem] text-center dark:bg-white/10">
                        <div class="text-xs font-bold font-mono" x-text="days + 'd'"></div>
                    </div>
                    <div class="bg-black/10 rounded px-2 py-0.5 min-w-[2.5rem] text-center dark:bg-white/10">
                        <div class="text-xs font-bold font-mono" x-text="hours.toString().padStart(2, '0') + 'h'"></div>
                    </div>
                    <div class="bg-black/10 rounded px-2 py-0.5 min-w-[2.5rem] text-center dark:bg-white/10">
                        <div class="text-xs font-bold font-mono" x-text="minutes.toString().padStart(2, '0') + 'm'"></div>
                    </div>
                    <div class="bg-black/10 rounded px-2 py-0.5 min-w-[2.5rem] text-center dark:bg-white/10">
                        <div class="text-xs font-bold font-mono" x-text="seconds.toString().padStart(2, '0') + 's'"></div>
                    </div>
                </div>
                {{-- Mobile view --}}
                <div class="flex items-center gap-1.5 md:hidden bg-black/10 py-0.5 px-2 rounded-radius text-xs dark:bg-white/10">
                    <span class="font-bold font-mono" x-text="days + 'd ' + hours.toString().padStart(2, '0') + 'h'"></span>
                </div>
            </div>
        @endif

        @if ($button)
            @if ($href)
                <x-button variant="{{ $variant }}" href="{{ $href }}" size="xs">
                    {{ $button }}
                </x-button>
            @else
                <x-button variant="{{ $variant }}" {{ $attributes->only(['wire:click', 'wire:target', 'wire:loading', 'wire:confirm']) }} size="xs">
                    {{ $button }}
                </x-button>
            @endif
        @endif
    </div>

    @if ($isDismissible)
        <x-button
            variant="ghost"
            size="xs"
            class="absolute top-1/2 -translate-y-1/2 right-4"
            aria-label="{{ __('Dismiss banner') }}"
            x-on:click="bannerIsVisible = false">
            <x-icons.x-mark class="size-4 shrink-0" :strokeWidth="2.5" />
        </x-button>
    @endif
</div>