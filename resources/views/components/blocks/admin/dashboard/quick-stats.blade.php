@props([
    'newSubscriptions',
    'newOrders',
    'revenue',
    'ytdRevenue',
    'percentageChange',
    'subscriptionsChange',
    'ordersChange',
    'dateRangeLabel',
    'comparisonLabel',
])

<!-- Quick stats grid -->
<div class="gap-3 sm:gap-4 lg:gap-6 grid grid-cols-1 xl:grid-cols-4">
    <!-- New Subscriptions -->
    <div class="panel flex flex-col">
        <div class="flex flex-col gap-1.5 sm:gap-2 my-auto">
            <h2
                class="flex font-medium items-center gap-1.5 sm:gap-2 text-sm sm:text-base text-on-surface-strong dark:text-on-surface-dark-strong">
                <div
                    class="flex justify-center items-center bg-surface-dark/10 dark:bg-surface/10 rounded-full p-1 sm:p-1.5">
                    <x-icons.credit-card variant="micro" size="sm"
                        class="shrink-0 text-on-surface dark:text-on-surface-dark" />
                </div>
                <span>{{ __('New Subscriptions') }}</span>
            </h2>
            <div class="flex gap-1.5 sm:gap-2 items-center font-mono">
                <span
                    class="text-xl sm:text-2xl font-bold font-mono text-on-surface dark:text-on-surface-dark-strong">{{ $newSubscriptions }}</span>
                @if ($subscriptionsChange > 0)
                    <x-badge variant="outline-success" size="xs">
                        {{ $subscriptionsChange }}%<x-icons.arrow-trending-up size="sm" />
                    </x-badge>
                @elseif ($subscriptionsChange < 0)
                    <x-badge variant="outline-danger" size="xs">
                        {{ $subscriptionsChange > 0 ? '+' : '' }}{{ $subscriptionsChange }}%<x-icons.arrow-trending-down
                            size="sm" />
                    </x-badge>
                @endif
            </div>
            <span class="text-xs sm:text-sm">
                @if ($subscriptionsChange != 0)
                    <span class="text-on-surface-muted dark:text-on-surface-dark-muted"> {{ $comparisonLabel }}</span>
                @else
                    <span class="text-on-surface-muted dark:text-on-surface-dark-muted">{{ $dateRangeLabel }}</span>
                @endif
            </span>
        </div>
    </div>

    <!-- New Orders -->
    <div class="panel flex flex-col">
        <div class="flex flex-col gap-1.5 sm:gap-2 my-auto">
            <h2
                class="flex font-medium items-center gap-1.5 sm:gap-2 text-sm sm:text-base text-on-surface-strong dark:text-on-surface-dark-strong">
                <div
                    class="flex justify-center items-center bg-surface-dark/10 dark:bg-surface/10 rounded-full p-1 sm:p-1.5">
                    <x-icons.shopping-bag variant="micro" size="sm"
                        class="shrink-0 text-on-surface dark:text-on-surface-dark" />
                </div>
                <span>{{ __('New Orders') }}</span>
            </h2>
            <div class="flex gap-1.5 sm:gap-2 items-center font-mono">
                <span
                    class="text-xl sm:text-2xl font-bold font-mono text-on-surface dark:text-on-surface-dark-strong">{{ $newOrders }}</span>
                @if ($ordersChange > 0)
                    <x-badge variant="outline-success" size="xs">
                        {{ $ordersChange }}%<x-icons.arrow-trending-up size="sm" />
                    </x-badge>
                @elseif ($ordersChange < 0)
                    <x-badge variant="outline-danger" size="xs">
                        {{ $ordersChange > 0 ? '+' : '' }}{{ $ordersChange }}%<x-icons.arrow-trending-down
                            size="sm" />
                    </x-badge>
                @endif
            </div>
            <span class="text-xs sm:text-sm">
                @if ($ordersChange != 0)
                    <span class="text-on-surface-muted dark:text-on-surface-dark-muted"> {{ $comparisonLabel }}</span>
                @else
                    <span class="text-on-surface-muted dark:text-on-surface-dark-muted">{{ $dateRangeLabel }}</span>
                @endif
            </span>
        </div>
    </div>

    <!-- Total Revenue -->
    <div class="panel flex flex-col">
        <div class="flex flex-col gap-1.5 sm:gap-2 my-auto">
            <h2
                class="flex font-medium items-center gap-1.5 sm:gap-2 text-sm sm:text-base text-on-surface-strong dark:text-on-surface-dark-strong">
                <div
                    class="flex justify-center items-center bg-surface-dark/10 dark:bg-surface/10 rounded-full p-1 sm:p-1.5">
                    <x-icons.banknotes variant="micro" size="sm"
                        class="shrink-0 text-on-surface dark:text-on-surface-dark" />
                </div>
                <span>{{ __('Total Revenue') }}</span>
            </h2>
            <div class="flex gap-1.5 sm:gap-2 items-center font-mono">
                <span
                    class="text-xl sm:text-2xl font-bold text-on-surface dark:text-on-surface-dark-strong font-mono">{{ Number::currency($revenue, 'USD') }}</span>
                @if ($percentageChange > 0)
                    <x-badge variant="outline-success" size="xs">
                        {{ $percentageChange }}%<x-icons.arrow-trending-up size="sm" />
                    </x-badge>
                @elseif ($percentageChange < 0)
                    <x-badge variant="outline-danger" size="xs">
                        {{ $percentageChange > 0 ? '+' : '' }}{{ $percentageChange }}%<x-icons.arrow-trending-down
                            size="sm" />
                    </x-badge>
                @endif
            </div>
            <span class="text-xs sm:text-sm">
                @if ($percentageChange != 0)
                    <span class="text-on-surface-muted dark:text-on-surface-dark-muted"> {{ $comparisonLabel }}</span>
                @else
                    <span class="text-on-surface-muted dark:text-on-surface-dark-muted">{{ $dateRangeLabel }}</span>
                @endif
            </span>
        </div>
    </div>

    <!-- YTD Revenue -->
    <div class="panel-primary flex flex-col order-first xl:order-last">
        <div class="flex flex-col gap-1.5 sm:gap-2 my-auto">
            <h2 class="flex font-medium items-center gap-1.5 sm:gap-2 text-sm sm:text-base">
                <span>{{ __('YTD Revenue') }}</span>
            </h2>
            <div class="flex gap-1.5 sm:gap-2 items-center">
                <span class="text-xl sm:text-2xl font-bold font-mono">{{ Number::currency($ytdRevenue, 'USD') }}</span>
            </div>
            <span class="opacity-75 text-xs sm:text-sm">{{ __('Year to Date') }}</span>
        </div>
    </div>
</div>
