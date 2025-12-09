@push('head')
    <title>{{ __('Admin') }}</title>
@endpush

<x-layouts.admin>
    <h1 class="sr-only">{{ __('Dashboard') }}</h1>

    <!-- Date Range Selector -->
    <div class="mb-6 w-full md:w-auto md:max-w-[23.4%] space-y-0.5">
        <x-date-range-selector :selected="$dateRange" class="w-full" />
        <small class="text-on-surface-muted dark:text-on-surface-dark-muted text-xs">{{ __('All times are in UTC') }}</small>
    </div>

    <!-- Quick Stats Section -->
    <x-blocks.admin.dashboard.quick-stats :newOrders="$newOrders" :newSubscriptions="$newSubscriptions" :revenue="$revenue" :ytdRevenue="$ytdRevenue"
        :percentageChange="$percentageChange" :subscriptionsChange="$subscriptionsChange" :ordersChange="$ordersChange" :dateRangeLabel="$dateRangeLabel" :comparisonLabel="$comparisonLabel" />

    <!-- Secondary Stats Section -->
    <div class="mt-6">
        <x-blocks.admin.dashboard.secondary-stats :newUsers="$newUsers" :usersChange="$usersChange"
            :cancelledSubscriptions="$cancelledSubscriptions" :cancelledSubscriptionsChange="$cancelledSubscriptionsChange"
            :dateRangeLabel="$dateRangeLabel" :comparisonLabel="$comparisonLabel" />
    </div>

    <div class="col-span-12 flex flex-col gap-6 grid-cols-12 mt-6 w-full xl:grid">
        <!-- Revenue Chart -->
        <div
            class="panel col-span-12 xl:col-span-6 flex flex-col justify-center p-4">
            <h2 class="heading-5 text-on-surface-strong dark:text-on-surface-dark-strong">
                {{ __('Revenue') }}
            </h2>
            <x-line-chart :categories="$labels" :data="$revenueData" :currency="'$'" />
        </div>

        <!-- Subscriptions Chart -->
        <div
            class="panel col-span-12 xl:col-span-6 flex flex-col justify-center p-4">
            <h2 class="heading-5 text-on-surface-strong dark:text-on-surface-dark-strong">
                {{ __('Subscriptions') }}
            </h2>
            <x-line-chart :categories="$labels" :data="$subscriptionData" />
        </div>
    </div>
</x-layouts.admin>
