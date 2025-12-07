@props([
    'aiTokens',
    'aiCost',
    'tokensChange',
    'costChange',
    'totalTokens',
    'totalCost',
    'dateRangeLabel',
    'comparisonLabel',
])

<!-- AI stats grid -->
<div class="gap-3 sm:gap-4 lg:gap-6 grid grid-cols-1 lg:grid-cols-4">
    <!-- AI Tokens -->
    <div class="panel flex flex-col">
        <div class="flex flex-col gap-1.5 sm:gap-2 my-auto">
            <h2
                class="flex font-medium items-center gap-1.5 sm:gap-2 text-sm sm:text-base text-on-surface-strong dark:text-on-surface-dark-strong">
                <div
                    class="flex justify-center items-center bg-surface-dark/10 dark:bg-surface/10 rounded-full p-1 sm:p-1.5">
                    <x-icons.cpu-chip variant="micro" size="sm"
                        class="shrink-0 text-on-surface dark:text-on-surface-dark" />
                </div>
                <span>{{ __('AI Tokens') }}</span>
            </h2>
            <div class="flex gap-1.5 sm:gap-2 items-center font-mono">
                <span
                    class="text-xl sm:text-2xl font-bold font-mono text-on-surface dark:text-on-surface-dark-strong">{{ Number::format($aiTokens) }}</span>
                @if ($tokensChange > 0)
                    <x-badge variant="outline-success" size="xs">
                        {{ $tokensChange }}%<x-icons.arrow-trending-up size="sm" />
                    </x-badge>
                @elseif ($tokensChange < 0)
                    <x-badge variant="outline-danger" size="xs">
                        {{ $tokensChange > 0 ? '+' : '' }}{{ $tokensChange }}%<x-icons.arrow-trending-down
                            size="sm" />
                    </x-badge>
                @endif
            </div>
            <span class="text-xs sm:text-sm">
                @if ($tokensChange != 0)
                    <span class="text-on-surface-muted dark:text-on-surface-dark-muted"> {{ $comparisonLabel }}</span>
                @else
                    <span class="text-on-surface-muted dark:text-on-surface-dark-muted">{{ $dateRangeLabel }}</span>
                @endif
            </span>
        </div>
    </div>

    <!-- AI Cost -->
    <div class="panel flex flex-col">
        <div class="flex flex-col gap-1.5 sm:gap-2 my-auto">
            <h2
                class="flex font-medium items-center gap-1.5 sm:gap-2 text-sm sm:text-base text-on-surface-strong dark:text-on-surface-dark-strong">
                <div
                    class="flex justify-center items-center bg-surface-dark/10 dark:bg-surface/10 rounded-full p-1 sm:p-1.5">
                    <x-icons.currency-dollar variant="micro" size="sm"
                        class="shrink-0 text-on-surface dark:text-on-surface-dark" />
                </div>
                <span>{{ __('AI Cost') }}</span>
            </h2>
            <div class="flex gap-1.5 sm:gap-2 items-center font-mono">
                <span
                    class="text-xl sm:text-2xl font-bold text-on-surface dark:text-on-surface-dark-strong font-mono">${{ number_format($aiCost, 4) }}</span>
                @if ($costChange > 0)
                    <x-badge variant="outline-success" size="xs">
                        {{ $costChange }}%<x-icons.arrow-trending-up size="sm" />
                    </x-badge>
                @elseif ($costChange < 0)
                    <x-badge variant="outline-danger" size="xs">
                        {{ $costChange > 0 ? '+' : '' }}{{ $costChange }}%<x-icons.arrow-trending-down
                            size="sm" />
                    </x-badge>
                @endif
            </div>
            <span class="text-xs sm:text-sm">
                @if ($costChange != 0)
                    <span class="text-on-surface-muted dark:text-on-surface-dark-muted"> {{ $comparisonLabel }}</span>
                @else
                    <span class="text-on-surface-muted dark:text-on-surface-dark-muted">{{ $dateRangeLabel }}</span>
                @endif
            </span>
        </div>
    </div>

    <!-- Total Tokens -->
    <div class="panel flex flex-col">
        <div class="flex flex-col gap-1.5 sm:gap-2 my-auto">
            <h2
                class="flex font-medium items-center gap-1.5 sm:gap-2 text-sm sm:text-base text-on-surface-strong dark:text-on-surface-dark-strong">
                <div
                    class="flex justify-center items-center bg-surface-dark/10 dark:bg-surface/10 rounded-full p-1 sm:p-1.5">
                    <x-icons.cpu-chip variant="micro" size="sm"
                        class="shrink-0 text-on-surface dark:text-on-surface-dark" />
                </div>
                <span>{{ __('Total Tokens') }}</span>
            </h2>
            <div class="flex gap-1.5 sm:gap-2 items-center font-mono">
                <span
                    class="text-xl sm:text-2xl font-bold font-mono text-on-surface dark:text-on-surface-dark-strong">{{ Number::format($totalTokens) }}</span>
            </div>
            <span class="text-xs sm:text-sm">
                <span class="text-on-surface-muted dark:text-on-surface-dark-muted">{{ __('All time') }}</span>
            </span>
        </div>
    </div>

    <!-- Total Cost -->
    <div class="panel-primary flex flex-col order-first xl:order-last">
        <div class="flex flex-col gap-1.5 sm:gap-2 my-auto">
            <h2 class="flex font-medium items-center gap-1.5 sm:gap-2 text-sm sm:text-base">
                <span>{{ __('Total Cost') }}</span>
            </h2>
            <div class="flex gap-1.5 sm:gap-2 items-center">
                <span class="text-xl sm:text-2xl font-bold font-mono">${{ number_format($totalCost, 4) }}</span>
            </div>
            <span class="opacity-75 text-xs sm:text-sm">{{ __('All time') }}</span>
        </div>
    </div>
</div>

