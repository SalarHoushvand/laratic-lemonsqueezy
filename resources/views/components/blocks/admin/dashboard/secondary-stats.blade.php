@props(['newUsers', 'usersChange', 'cancelledSubscriptions', 'cancelledSubscriptionsChange', 'comparisonLabel', 'dateRangeLabel'])

<!-- Secondary stats grid (smaller) -->
<div class="gap-3 sm:gap-4 lg:gap-6 grid grid-cols-1 lg:grid-cols-2">
    <!-- New Users -->
    <div class="panel flex flex-col">
        <div class="flex flex-col md:flex-row items-start md:items-center gap-2 sm:gap-3 md:gap-4 my-auto">
            <h3 class="flex font-medium items-center gap-1.5 sm:gap-2 text-sm sm:text-base text-on-surface-strong dark:text-on-surface-dark-strong">
                <div class="flex justify-center items-center bg-surface-dark/10 dark:bg-surface/10 rounded-full p-1 sm:p-1.5">
                    <x-icons.users variant="micro" size="sm"
                        class="shrink-0 text-on-surface dark:text-on-surface-dark" />
                </div>
                <span>{{ __('New Users') }}</span>
            </h3>
            <div class="flex gap-1.5 sm:gap-2 items-center font-mono">
                <span
                    class="text-xl sm:text-2xl font-bold font-mono text-on-surface dark:text-on-surface-dark-strong">{{ Number::format($newUsers) }}</span>
                @if ($usersChange > 0)
                    <x-badge variant="outline-success" size="xs">
                        {{ $usersChange }}%<x-icons.arrow-trending-up size="sm" />
                    </x-badge>
                @elseif ($usersChange < 0)
                    <x-badge variant="outline-danger" size="xs">
                        {{ $usersChange > 0 ? '+' : '' }}{{ $usersChange }}%<x-icons.arrow-trending-down
                            size="sm" />
                    </x-badge>
                @endif
            </div>
            <span class="text-xs sm:text-sm md:ml-auto">
                @if ($usersChange != 0)
                    <span class="text-on-surface-muted dark:text-on-surface-dark-muted"> {{ $comparisonLabel }}</span>
                @else
                    <span class="text-on-surface-muted dark:text-on-surface-dark-muted">{{ $dateRangeLabel }}</span>
                @endif
            </span>
        </div>
    </div>

    <!-- Cancelled Subscriptions -->
    <div class="panel flex flex-col">
        <div class="flex flex-col md:flex-row items-start md:items-center gap-2 sm:gap-3 md:gap-4 my-auto">
            <h3 class="flex font-medium items-center gap-1.5 sm:gap-2 text-sm sm:text-base text-on-surface-strong dark:text-on-surface-dark-strong">
                <div class="flex justify-center items-center bg-surface-dark/10 dark:bg-surface/10 rounded-full p-1 sm:p-1.5">
                    <x-icons.x-circle variant="micro" size="sm"
                        class="shrink-0 text-on-surface dark:text-on-surface-dark" />
                </div>
                <span>{{ __('Cancelled Subscriptions') }}</span>
            </h3>
            <div class="flex gap-1.5 sm:gap-2 items-center font-mono">
                <span
                    class="text-xl sm:text-2xl font-bold font-mono text-on-surface dark:text-on-surface-dark-strong">{{ Number::format($cancelledSubscriptions) }}</span>
                @if ($cancelledSubscriptionsChange > 0)
                    <x-badge variant="outline-danger" size="xs">
                        {{ $cancelledSubscriptionsChange }}%<x-icons.arrow-trending-up size="sm" />
                    </x-badge>
                @elseif ($cancelledSubscriptionsChange < 0)
                    <x-badge variant="outline-success" size="xs">
                        {{ $cancelledSubscriptionsChange > 0 ? '+' : '' }}{{ $cancelledSubscriptionsChange }}%<x-icons.arrow-trending-down
                            size="sm" />
                    </x-badge>
                @endif
            </div>
            <span class="text-xs sm:text-sm md:ml-auto">
                @if ($cancelledSubscriptionsChange != 0)
                    <span class="text-on-surface-muted dark:text-on-surface-dark-muted"> {{ $comparisonLabel }}</span>
                @else
                    <span class="text-on-surface-muted dark:text-on-surface-dark-muted">{{ $dateRangeLabel }}</span>
                @endif
            </span>
        </div>
    </div>
</div>

