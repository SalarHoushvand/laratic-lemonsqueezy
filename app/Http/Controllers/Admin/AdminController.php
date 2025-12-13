<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    private const CENTS_TO_DOLLARS = 100;

    private const DATE_RANGES = [
        'today' => 'Today',
        'yesterday' => 'Yesterday',
        'last_7_days' => 'Last 7 Days',
        'last_10_days' => 'Last 10 Days',
        'last_30_days' => 'Last 30 Days',
        'last_3_months' => 'Last 3 Months',
        'last_6_months' => 'Last 6 Months',
        'ytd' => 'Year to Date',
    ];

    /**
     * Display the admin dashboard
     *
     * Authorization is handled by the 'role:admin' middleware at the route level
     */
    public function index(Request $request): \Illuminate\View\View
    {
        // Read from URL parameter, then cookie, then fallback to default
        $dateRange = $request->input('range')
            ?? $request->cookie('admin_date_range')
            ?? 'last_30_days';

        // Validate date range
        if (! array_key_exists($dateRange, self::DATE_RANGES)) {
            $dateRange = 'last_30_days';
        }

        [$startDate, $endDate, $previousStartDate] = $this->getDateRangeDates($dateRange);

        // Get metrics data with optimized queries
        $metrics = $this->getMetrics($startDate, $endDate, $previousStartDate);

        // Determine chart interval and get data based on date range
        $useDaily = $this->shouldUseDailyInterval($dateRange);

        if ($useDaily) {
            [$revenueData, $subscriptionRevenueData, $oneTimeRevenueData, $labels] = $this->getDailyRevenue($startDate, $endDate);
            $subscriptionData = $this->getDailyTotalSubscriptionsOptimized($startDate, $endDate);
            $mrrData = $this->getDailyMrrEstimate($startDate, $endDate);
        } else {
            $chartMonths = $this->getChartMonthsForRange($dateRange);
            [$revenueData, $subscriptionRevenueData, $oneTimeRevenueData, $labels] = $this->getMonthlyRevenue($chartMonths, $startDate);
            $subscriptionData = $this->getMonthlyTotalSubscriptionsOptimized($chartMonths, $startDate);
            $mrrData = $this->getMonthlyMrrEstimate($chartMonths, $startDate);
        }

        // Get human-readable labels for date range
        $dateRangeLabel = $this->getDateRangeLabel($dateRange);
        $comparisonLabel = $this->getComparisonLabel($dateRange);

        return view('pages.admin.dashboard', array_merge($metrics, [
            'revenueData' => $revenueData,
            'subscriptionRevenueData' => $subscriptionRevenueData,
            'oneTimeRevenueData' => $oneTimeRevenueData,
            'mrrData' => $mrrData,
            'subscriptionData' => $subscriptionData,
            'labels' => $labels,
            'dateRange' => $dateRange,
            'dateRangeLabel' => $dateRangeLabel,
            'comparisonLabel' => $comparisonLabel,
        ]));
    }

    /**
     * Get all metrics data with optimized queries
     */
    private function getMetrics(Carbon $startDate, Carbon $endDate, Carbon $previousStartDate): array
    {
        $startOfYear = Carbon::now()->startOfYear();

        $orders = DB::table('lemon_squeezy_orders')
            ->selectRaw(
                '
                SUM(CASE WHEN status = ? AND product_type = ? AND ordered_at BETWEEN ? AND ? THEN total ELSE 0 END) AS current_one_time_revenue_cents,
                SUM(CASE WHEN status = ? AND product_type = ? AND ordered_at BETWEEN ? AND ? THEN total ELSE 0 END) AS previous_one_time_revenue_cents,
                SUM(CASE WHEN status = ? AND product_type = ? AND ordered_at BETWEEN ? AND ? THEN total ELSE 0 END) AS ytd_one_time_revenue_cents,
                SUM(CASE WHEN status = ? AND product_type = ? AND ordered_at BETWEEN ? AND ? THEN 1 ELSE 0 END) AS current_subscription_orders,
                SUM(CASE WHEN status = ? AND product_type = ? AND ordered_at BETWEEN ? AND ? THEN 1 ELSE 0 END) AS previous_subscription_orders,
                SUM(CASE WHEN status = ? AND product_type = ? AND ordered_at BETWEEN ? AND ? THEN 1 ELSE 0 END) AS current_one_time_orders,
                SUM(CASE WHEN status = ? AND product_type = ? AND ordered_at BETWEEN ? AND ? THEN 1 ELSE 0 END) AS previous_one_time_orders
                ',
                [
                    'paid', 'one-time', $startDate, $endDate,
                    'paid', 'one-time', $previousStartDate, $startDate,
                    'paid', 'one-time', $startOfYear, $endDate,
                    'paid', 'subscription', $startDate, $endDate,
                    'paid', 'subscription', $previousStartDate, $startDate,
                    'paid', 'one-time', $startDate, $endDate,
                    'paid', 'one-time', $previousStartDate, $startDate,
                ]
            )
            ->first();

        $invoices = DB::table('lemon_squeezy_subscription_invoices')
            ->selectRaw(
                '
                SUM(CASE WHEN status = ? AND invoiced_at BETWEEN ? AND ? THEN total ELSE 0 END) AS current_subscription_revenue_cents,
                SUM(CASE WHEN status = ? AND invoiced_at BETWEEN ? AND ? THEN total ELSE 0 END) AS previous_subscription_revenue_cents,
                SUM(CASE WHEN status = ? AND invoiced_at BETWEEN ? AND ? THEN total ELSE 0 END) AS ytd_subscription_revenue_cents
                ',
                [
                    'paid', $startDate, $endDate,
                    'paid', $previousStartDate, $startDate,
                    'paid', $startOfYear, $endDate,
                ]
            )
            ->first();

        $cancellations = DB::table('lemon_squeezy_subscriptions')
            ->selectRaw(
                '
                SUM(CASE WHEN status = ? AND updated_at BETWEEN ? AND ? THEN 1 ELSE 0 END) AS cancelled_subscriptions,
                SUM(CASE WHEN status = ? AND updated_at BETWEEN ? AND ? THEN 1 ELSE 0 END) AS previous_cancelled_subscriptions
                ',
                [
                    'canceled', $startDate, $endDate,
                    'canceled', $previousStartDate, $startDate,
                ]
            )
            ->first();

        $currentOneTimeRevenueCents = (int) ($orders->current_one_time_revenue_cents ?? 0);
        $previousOneTimeRevenueCents = (int) ($orders->previous_one_time_revenue_cents ?? 0);
        $ytdOneTimeRevenueCents = (int) ($orders->ytd_one_time_revenue_cents ?? 0);

        $currentSubscriptionRevenueCents = (int) ($invoices->current_subscription_revenue_cents ?? 0);
        $previousSubscriptionRevenueCents = (int) ($invoices->previous_subscription_revenue_cents ?? 0);
        $ytdSubscriptionRevenueCents = (int) ($invoices->ytd_subscription_revenue_cents ?? 0);

        $currentRevenueCents = $currentOneTimeRevenueCents + $currentSubscriptionRevenueCents;
        $previousRevenueCents = $previousOneTimeRevenueCents + $previousSubscriptionRevenueCents;
        $ytdRevenueCents = $ytdOneTimeRevenueCents + $ytdSubscriptionRevenueCents;

        $revenue = round($currentRevenueCents / self::CENTS_TO_DOLLARS, 2);
        $previousRevenue = round($previousRevenueCents / self::CENTS_TO_DOLLARS, 2);
        $ytdRevenue = round($ytdRevenueCents / self::CENTS_TO_DOLLARS, 2);

        // New subscriptions come from subscription-type paid orders
        $newSubscriptions = (int) ($orders->current_subscription_orders ?? 0);
        $previousSubscriptions = (int) ($orders->previous_subscription_orders ?? 0);

        // New one-time orders (paid)
        $newOneTimeOrders = (int) ($orders->current_one_time_orders ?? 0);
        $previousOneTimeOrders = (int) ($orders->previous_one_time_orders ?? 0);

        $cancelledSubscriptions = (int) ($cancellations->cancelled_subscriptions ?? 0);
        $previousCancelledSubscriptions = (int) ($cancellations->previous_cancelled_subscriptions ?? 0);

        // Get user counts for current and previous periods
        $userCounts = User::query()
            ->selectRaw('
                COUNT(CASE WHEN created_at >= ? AND created_at <= ? THEN 1 END) as new_users,
                COUNT(CASE WHEN created_at >= ? AND created_at < ? THEN 1 END) as previous_users
            ', [
                $startDate, $endDate,
                $previousStartDate, $startDate,
            ])
            ->first();

        // Calculate percentage changes
        $percentageChange = $previousRevenue > 0
            ? round((($revenue - $previousRevenue) / $previousRevenue) * 100)
            : ($revenue > 0 ? 100 : 0);

        $subscriptionsChange = $previousSubscriptions > 0
            ? round((($newSubscriptions - $previousSubscriptions) / $previousSubscriptions) * 100)
            : ($newSubscriptions > 0 ? 100 : 0);

        $ordersChange = $previousOneTimeOrders > 0
            ? round((($newOneTimeOrders - $previousOneTimeOrders) / $previousOneTimeOrders) * 100)
            : ($newOneTimeOrders > 0 ? 100 : 0);

        $usersChange = $userCounts->previous_users > 0
            ? round((($userCounts->new_users - $userCounts->previous_users) / $userCounts->previous_users) * 100)
            : ($userCounts->new_users > 0 ? 100 : 0);

        $cancelledSubscriptionsChange = $previousCancelledSubscriptions > 0
            ? round((($cancelledSubscriptions - $previousCancelledSubscriptions) / $previousCancelledSubscriptions) * 100)
            : ($cancelledSubscriptions > 0 ? 100 : 0);

        return [
            'newSubscriptions' => $newSubscriptions,
            'newOrders' => $newOneTimeOrders,
            'revenue' => $revenue,
            'ytdRevenue' => $ytdRevenue,
            'percentageChange' => $percentageChange,
            'subscriptionsChange' => $subscriptionsChange,
            'ordersChange' => $ordersChange,
            'newUsers' => $userCounts->new_users,
            'usersChange' => $usersChange,
            'cancelledSubscriptions' => $cancelledSubscriptions,
            'cancelledSubscriptionsChange' => $cancelledSubscriptionsChange,
        ];
    }

    /**
     * Get start date, end date, and previous start date for a given date range
     *
     * @return array{0: \Carbon\Carbon, 1: \Carbon\Carbon, 2: \Carbon\Carbon} Start date, end date, and previous start date
     */
    private function getDateRangeDates(string $range): array
    {
        $endDate = Carbon::now()->endOfDay();

        $dates = match ($range) {
            'today' => [
                Carbon::now()->startOfDay(),
                $endDate,
                Carbon::now()->subDay()->startOfDay(),
            ],
            'yesterday' => [
                Carbon::now()->subDay()->startOfDay(),
                Carbon::now()->subDay()->endOfDay(),
                Carbon::now()->subDays(2)->startOfDay(),
            ],
            'last_7_days' => [
                Carbon::now()->subDays(6)->startOfDay(),
                $endDate,
                Carbon::now()->subDays(13)->startOfDay(),
            ],
            'last_10_days' => [
                Carbon::now()->subDays(9)->startOfDay(),
                $endDate,
                Carbon::now()->subDays(19)->startOfDay(),
            ],
            'last_30_days' => [
                Carbon::now()->subDays(29)->startOfDay(),
                $endDate,
                Carbon::now()->subDays(59)->startOfDay(),
            ],
            'last_3_months' => [
                Carbon::now()->subMonths(2)->startOfMonth(),
                $endDate,
                Carbon::now()->subMonths(5)->startOfMonth(),
            ],
            'last_6_months' => [
                Carbon::now()->subMonths(5)->startOfMonth(),
                $endDate,
                Carbon::now()->subMonths(11)->startOfMonth(),
            ],
            'ytd' => [
                Carbon::now()->startOfYear(),
                $endDate,
                Carbon::now()->subYear()->startOfYear(),
            ],
            default => [
                Carbon::now()->subDays(29)->startOfDay(),
                $endDate,
                Carbon::now()->subDays(59)->startOfDay(),
            ],
        };

        return $dates;
    }

    /**
     * Get human-readable label for date range
     */
    private function getDateRangeLabel(string $range): string
    {
        return match ($range) {
            'today' => 'Today',
            'yesterday' => 'Yesterday',
            'last_7_days' => 'In the last 7 days',
            'last_10_days' => 'In the last 10 days',
            'last_30_days' => 'In the last 30 days',
            'last_3_months' => 'In the last 3 months',
            'last_6_months' => 'In the last 6 months',
            'ytd' => 'Year to date',
            default => 'In the last 30 days',
        };
    }

    /**
     * Get human-readable comparison label for date range
     */
    private function getComparisonLabel(string $range): string
    {
        return match ($range) {
            'today' => 'vs yesterday',
            'yesterday' => 'vs previous day',
            'last_7_days' => 'vs previous 7 days',
            'last_10_days' => 'vs previous 10 days',
            'last_30_days' => 'vs previous 30 days',
            'last_3_months' => 'vs previous 3 months',
            'last_6_months' => 'vs previous 6 months',
            'ytd' => 'vs previous year',
            default => 'vs previous period',
        };
    }

    /**
     * Determine if daily interval should be used for charts
     */
    private function shouldUseDailyInterval(string $range): bool
    {
        return in_array($range, ['today', 'yesterday', 'last_7_days', 'last_10_days', 'last_30_days']);
    }

    /**
     * Get number of months for chart based on date range
     */
    private function getChartMonthsForRange(string $range): int
    {
        return match ($range) {
            'today', 'yesterday' => 1,
            'last_7_days', 'last_10_days' => 1,
            'last_30_days' => 2,
            'last_3_months' => 3,
            'last_6_months' => 6,
            'ytd' => Carbon::now()->month,
            default => 6,
        };
    }

    /**
     * Get database-specific date format expression
     */
    private function getDateFormatExpression(string $column, string $format = 'Y-m'): string
    {
        $driver = DB::getDriverName();

        if ($format === 'Y-m-d') {
            return match ($driver) {
                'sqlite' => "strftime('%Y-%m-%d', {$column})",
                'mysql' => "DATE_FORMAT({$column}, '%Y-%m-%d')",
                'pgsql' => "TO_CHAR({$column}, 'YYYY-MM-DD')",
                default => "DATE_FORMAT({$column}, '%Y-%m-%d')",
            };
        }

        return match ($driver) {
            'sqlite' => "strftime('%Y-%m', {$column})",
            'mysql' => "DATE_FORMAT({$column}, '%Y-%m')",
            'pgsql' => "TO_CHAR({$column}, 'YYYY-MM')",
            default => "DATE_FORMAT({$column}, '%Y-%m')",
        };
    }

    /**
     * Generate month keys and labels for chart data
     *
     * @return array{0: array<int, string>, 1: array<int, string>} Month keys and labels
     */
    private function generateMonthData(int $numberOfMonths, Carbon $start): array
    {
        $monthKeys = [];
        $months = [];

        for ($i = 0; $i < $numberOfMonths; $i++) {
            $monthDate = $start->copy()->addMonths($i);
            $monthKeys[] = $monthDate->format('Y-m');
            $months[] = $monthDate->format('M');
        }

        return [$monthKeys, $months];
    }

    /**
     * Calculate daily revenue breakdown (total, subscriptions, one-time) for a specified date range.
     *
     * @return array{
     *     0: array<int, float>,
     *     1: array<int, float>,
     *     2: array<int, float>,
     *     3: array<int, string>
     * }
     */
    private function getDailyRevenue(Carbon $startDate, Carbon $endDate): array
    {
        $orderDateFormat = $this->getDateFormatExpression('ordered_at', 'Y-m-d');
        $invoiceDateFormat = $this->getDateFormatExpression('invoiced_at', 'Y-m-d');

        // Generate all dates in range
        $dateKeys = [];
        $labels = [];
        $currentDate = $startDate->copy();

        while ($currentDate <= $endDate) {
            $dateKeys[] = $currentDate->format('Y-m-d');
            $labels[] = $currentDate->format('M j');
            $currentDate->addDay();
        }

        // One-time revenue from paid orders
        $oneTimeRaw = DB::table('lemon_squeezy_orders')
            ->selectRaw("{$orderDateFormat} as date, SUM(total) as total")
            ->whereBetween('ordered_at', [$startDate, $endDate])
            ->where('status', 'paid')
            ->where('product_type', 'one-time')
            ->groupBy(DB::raw($orderDateFormat))
            ->get()
            ->keyBy('date');

        // Subscription revenue from paid invoices
        $subscriptionRaw = DB::table('lemon_squeezy_subscription_invoices')
            ->selectRaw("{$invoiceDateFormat} as date, SUM(total) as total")
            ->whereBetween('invoiced_at', [$startDate, $endDate])
            ->where('status', 'paid')
            ->groupBy(DB::raw($invoiceDateFormat))
            ->get()
            ->keyBy('date');

        $totalRevenueData = [];
        $subscriptionRevenueData = [];
        $oneTimeRevenueData = [];

        foreach ($dateKeys as $dateKey) {
            $oneTimeRow = $oneTimeRaw->get($dateKey);
            $subscriptionRow = $subscriptionRaw->get($dateKey);

            $oneTimeTotalCents = $oneTimeRow ? (int) $oneTimeRow->total : 0;
            $subscriptionTotalCents = $subscriptionRow ? (int) $subscriptionRow->total : 0;

            $oneTimeValue = round($oneTimeTotalCents / self::CENTS_TO_DOLLARS, 2);
            $subscriptionValue = round($subscriptionTotalCents / self::CENTS_TO_DOLLARS, 2);
            $totalValue = round(($oneTimeTotalCents + $subscriptionTotalCents) / self::CENTS_TO_DOLLARS, 2);

            $oneTimeRevenueData[] = $oneTimeValue;
            $subscriptionRevenueData[] = $subscriptionValue;
            $totalRevenueData[] = $totalValue;
        }

        return [$totalRevenueData, $subscriptionRevenueData, $oneTimeRevenueData, $labels];
    }

    /**
     * Calculate monthly revenue breakdown (total, subscriptions, one-time) for a specified number of months.
     *
     * @return array{
     *     0: array<int, float>,
     *     1: array<int, float>,
     *     2: array<int, float>,
     *     3: array<int, string>
     * }
     */
    private function getMonthlyRevenue(int $numberOfMonths, ?Carbon $startDate): array
    {
        $start = $startDate
            ? $startDate->copy()->startOfMonth()
            : Carbon::now()->startOfMonth()->subMonths($numberOfMonths - 1);

        [$monthKeys, $months] = $this->generateMonthData($numberOfMonths, $start);

        $orderDateFormat = $this->getDateFormatExpression('ordered_at');
        $invoiceDateFormat = $this->getDateFormatExpression('invoiced_at');

        // One-time revenue from paid orders
        $oneTimeRaw = DB::table('lemon_squeezy_orders')
            ->selectRaw("{$orderDateFormat} as month, SUM(total) as total")
            ->where('ordered_at', '>=', $start)
            ->where('status', 'paid')
            ->where('product_type', 'one-time')
            ->groupBy(DB::raw($orderDateFormat))
            ->get()
            ->keyBy('month');

        // Subscription revenue from paid invoices
        $subscriptionRaw = DB::table('lemon_squeezy_subscription_invoices')
            ->selectRaw("{$invoiceDateFormat} as month, SUM(total) as total")
            ->where('invoiced_at', '>=', $start)
            ->where('status', 'paid')
            ->groupBy(DB::raw($invoiceDateFormat))
            ->get()
            ->keyBy('month');

        $totalRevenueData = [];
        $subscriptionRevenueData = [];
        $oneTimeRevenueData = [];

        foreach ($monthKeys as $monthKey) {
            $oneTimeRow = $oneTimeRaw->get($monthKey);
            $subscriptionRow = $subscriptionRaw->get($monthKey);

            $oneTimeTotalCents = $oneTimeRow ? (int) $oneTimeRow->total : 0;
            $subscriptionTotalCents = $subscriptionRow ? (int) $subscriptionRow->total : 0;

            $oneTimeValue = round($oneTimeTotalCents / self::CENTS_TO_DOLLARS, 2);
            $subscriptionValue = round($subscriptionTotalCents / self::CENTS_TO_DOLLARS, 2);
            $totalValue = round(($oneTimeTotalCents + $subscriptionTotalCents) / self::CENTS_TO_DOLLARS, 2);

            $oneTimeRevenueData[] = $oneTimeValue;
            $subscriptionRevenueData[] = $subscriptionValue;
            $totalRevenueData[] = $totalValue;
        }

        return [$totalRevenueData, $subscriptionRevenueData, $oneTimeRevenueData, $months];
    }

    /**
     * Calculate daily total active subscriptions - OPTIMIZED VERSION
     *
     * Uses a single query instead of N queries (one per day)
     *
     * @return array<int, int> Total active subscription counts per day
     */
    private function getDailyTotalSubscriptionsOptimized(Carbon $startDate, Carbon $endDate): array
    {
        $dateKeys = [];
        $currentDate = $startDate->copy();

        while ($currentDate <= $endDate) {
            $dateKeys[] = $currentDate->format('Y-m-d');
            $currentDate->addDay();
        }

        if ($dateKeys === []) {
            return [];
        }

        // Fetch once, then build an "event" map and a cumulative series:
        // active(endOfDay[d]) = active(endOfDay[d-1]) + starts[d] - ends[d]
        $subscriptions = DB::table('lemon_squeezy_subscriptions')
            ->select(['created_at', 'ends_at'])
            ->where('created_at', '<=', $endDate)
            ->where('status', 'active')
            ->get();

        $firstKey = $dateKeys[0];
        $lastKey = $dateKeys[count($dateKeys) - 1];
        $firstDayEnd = Carbon::createFromFormat('Y-m-d', $firstKey)->endOfDay();

        $initialActive = 0;
        $startsByDate = [];
        $endsByDate = [];

        foreach ($subscriptions as $subscription) {
            $createdAt = Carbon::parse($subscription->created_at);
            $endsAt = $subscription->ends_at ? Carbon::parse($subscription->ends_at) : null;

            if ($createdAt <= $firstDayEnd && ($endsAt === null || $endsAt > $firstDayEnd)) {
                $initialActive++;
            }

            $createdKey = $createdAt->format('Y-m-d');
            if ($createdKey >= $firstKey && $createdKey <= $lastKey) {
                $startsByDate[$createdKey] = ($startsByDate[$createdKey] ?? 0) + 1;
            }

            if ($endsAt !== null) {
                $endKey = $endsAt->format('Y-m-d');
                if ($endKey >= $firstKey && $endKey <= $lastKey) {
                    $endsByDate[$endKey] = ($endsByDate[$endKey] ?? 0) + 1;
                }
            }
        }

        $series = [];
        $active = $initialActive;

        foreach ($dateKeys as $index => $dateKey) {
            if ($index === 0) {
                $series[] = $active;
                continue;
            }

            $active += ($startsByDate[$dateKey] ?? 0) - ($endsByDate[$dateKey] ?? 0);
            $series[] = $active;
        }

        return $series;
    }

    /**
     * Calculate monthly total active subscriptions - OPTIMIZED VERSION
     *
     * Uses a single query instead of N queries (one per month)
     *
     * @return array<int, int> Total active subscription counts per month
     */
    private function getMonthlyTotalSubscriptionsOptimized(int $numberOfMonths, ?Carbon $startDate): array
    {
        $start = $startDate
            ? $startDate->copy()->startOfMonth()
            : Carbon::now()->startOfMonth()->subMonths($numberOfMonths - 1);

        [$monthKeys] = $this->generateMonthData($numberOfMonths, $start);

        // Calculate the last month end date
        $lastMonthEnd = Carbon::createFromFormat('Y-m', end($monthKeys))->endOfMonth();

        if ($monthKeys === []) {
            return [];
        }

        $subscriptions = DB::table('lemon_squeezy_subscriptions')
            ->select(['created_at', 'ends_at'])
            ->where('created_at', '<=', $lastMonthEnd)
            ->where('status', 'active')
            ->get();

        $firstKey = $monthKeys[0];
        $lastKey = $monthKeys[count($monthKeys) - 1];
        $firstMonthEnd = Carbon::createFromFormat('Y-m', $firstKey)->endOfMonth();

        $initialActive = 0;
        $startsByMonth = [];
        $endsByMonth = [];

        foreach ($subscriptions as $subscription) {
            $createdAt = Carbon::parse($subscription->created_at);
            $endsAt = $subscription->ends_at ? Carbon::parse($subscription->ends_at) : null;

            if ($createdAt <= $firstMonthEnd && ($endsAt === null || $endsAt > $firstMonthEnd)) {
                $initialActive++;
            }

            $createdKey = $createdAt->format('Y-m');
            if ($createdKey >= $firstKey && $createdKey <= $lastKey) {
                $startsByMonth[$createdKey] = ($startsByMonth[$createdKey] ?? 0) + 1;
            }

            if ($endsAt !== null) {
                $endKey = $endsAt->format('Y-m');
                if ($endKey >= $firstKey && $endKey <= $lastKey) {
                    $endsByMonth[$endKey] = ($endsByMonth[$endKey] ?? 0) + 1;
                }
            }
        }

        $series = [];
        $active = $initialActive;

        foreach ($monthKeys as $index => $monthKey) {
            if ($index === 0) {
                $series[] = $active;
                continue;
            }

            $active += ($startsByMonth[$monthKey] ?? 0) - ($endsByMonth[$monthKey] ?? 0);
            $series[] = $active;
        }

        return $series;
    }

    /**
     * Calculate daily MRR estimate for a specified date range.
     *
     * MRR is approximated as:
     *   monthly subscriptions: price
     *   yearly subscriptions:  price / 12
     *
     * @return array<int, float> MRR values per day
     */
    private function getDailyMrrEstimate(Carbon $startDate, Carbon $endDate): array
    {
        $dateKeys = [];
        $currentDate = $startDate->copy();

        while ($currentDate <= $endDate) {
            $dateKeys[] = $currentDate->format('Y-m-d');
            $currentDate->addDay();
        }

        if ($dateKeys === []) {
            return [];
        }

        // Load active subscriptions with their plan prices
        $subscriptions = DB::table('lemon_squeezy_subscriptions')
            ->join('plans', 'lemon_squeezy_subscriptions.variant_id', '=', 'plans.lemon_squeezy_variant_id')
            ->select([
                'lemon_squeezy_subscriptions.created_at',
                'lemon_squeezy_subscriptions.ends_at',
                'plans.price',
                'plans.billing_period',
            ])
            ->where('lemon_squeezy_subscriptions.status', 'active')
            ->where('lemon_squeezy_subscriptions.created_at', '<=', $endDate)
            ->get();

        $firstKey = $dateKeys[0];
        $lastKey = $dateKeys[count($dateKeys) - 1];
        $firstDayEnd = Carbon::createFromFormat('Y-m-d', $firstKey)->endOfDay();

        $initialMrrCents = 0;
        $startsByDateCents = [];
        $endsByDateCents = [];

        foreach ($subscriptions as $subscription) {
            $createdAt = Carbon::parse($subscription->created_at);
            $endsAt = $subscription->ends_at ? Carbon::parse($subscription->ends_at) : null;

            $priceCents = (int) $subscription->price;
            $billingPeriod = $subscription->billing_period;
            $monthlyEquivalentCents = in_array($billingPeriod, ['year', 'yearly'], true)
                ? (int) round($priceCents / 12)
                : $priceCents;

            if ($createdAt <= $firstDayEnd && ($endsAt === null || $endsAt > $firstDayEnd)) {
                $initialMrrCents += $monthlyEquivalentCents;
            }

            $createdKey = $createdAt->format('Y-m-d');
            if ($createdKey >= $firstKey && $createdKey <= $lastKey) {
                $startsByDateCents[$createdKey] = ($startsByDateCents[$createdKey] ?? 0) + $monthlyEquivalentCents;
            }

            if ($endsAt !== null) {
                $endKey = $endsAt->format('Y-m-d');
                if ($endKey >= $firstKey && $endKey <= $lastKey) {
                    $endsByDateCents[$endKey] = ($endsByDateCents[$endKey] ?? 0) + $monthlyEquivalentCents;
                }
            }
        }

        $series = [];
        $mrrCents = $initialMrrCents;

        foreach ($dateKeys as $index => $dateKey) {
            if ($index === 0) {
                $series[] = round($mrrCents / self::CENTS_TO_DOLLARS, 2);
                continue;
            }

            $mrrCents += ($startsByDateCents[$dateKey] ?? 0) - ($endsByDateCents[$dateKey] ?? 0);
            $series[] = round($mrrCents / self::CENTS_TO_DOLLARS, 2);
        }

        return $series;
    }

    /**
     * Calculate monthly MRR estimate for a specified number of months.
     *
     * @return array<int, float> MRR values per month
     */
    private function getMonthlyMrrEstimate(int $numberOfMonths, ?Carbon $startDate): array
    {
        $start = $startDate
            ? $startDate->copy()->startOfMonth()
            : Carbon::now()->startOfMonth()->subMonths($numberOfMonths - 1);

        [$monthKeys] = $this->generateMonthData($numberOfMonths, $start);

        if ($monthKeys === []) {
            return [];
        }

        // Calculate the last month end date
        $lastMonthEnd = Carbon::createFromFormat('Y-m', end($monthKeys))->endOfMonth();

        // Load active subscriptions with their plan prices
        $subscriptions = DB::table('lemon_squeezy_subscriptions')
            ->join('plans', 'lemon_squeezy_subscriptions.variant_id', '=', 'plans.lemon_squeezy_variant_id')
            ->select([
                'lemon_squeezy_subscriptions.created_at',
                'lemon_squeezy_subscriptions.ends_at',
                'plans.price',
                'plans.billing_period',
            ])
            ->where('lemon_squeezy_subscriptions.status', 'active')
            ->where('lemon_squeezy_subscriptions.created_at', '<=', $lastMonthEnd)
            ->get();

        $firstKey = $monthKeys[0];
        $lastKey = $monthKeys[count($monthKeys) - 1];
        $firstMonthEnd = Carbon::createFromFormat('Y-m', $firstKey)->endOfMonth();

        $initialMrrCents = 0;
        $startsByMonthCents = [];
        $endsByMonthCents = [];

        foreach ($subscriptions as $subscription) {
            $createdAt = Carbon::parse($subscription->created_at);
            $endsAt = $subscription->ends_at ? Carbon::parse($subscription->ends_at) : null;

            $priceCents = (int) $subscription->price;
            $billingPeriod = $subscription->billing_period;
            $monthlyEquivalentCents = in_array($billingPeriod, ['year', 'yearly'], true)
                ? (int) round($priceCents / 12)
                : $priceCents;

            if ($createdAt <= $firstMonthEnd && ($endsAt === null || $endsAt > $firstMonthEnd)) {
                $initialMrrCents += $monthlyEquivalentCents;
            }

            $createdKey = $createdAt->format('Y-m');
            if ($createdKey >= $firstKey && $createdKey <= $lastKey) {
                $startsByMonthCents[$createdKey] = ($startsByMonthCents[$createdKey] ?? 0) + $monthlyEquivalentCents;
            }

            if ($endsAt !== null) {
                $endKey = $endsAt->format('Y-m');
                if ($endKey >= $firstKey && $endKey <= $lastKey) {
                    $endsByMonthCents[$endKey] = ($endsByMonthCents[$endKey] ?? 0) + $monthlyEquivalentCents;
                }
            }
        }

        $series = [];
        $mrrCents = $initialMrrCents;

        foreach ($monthKeys as $index => $monthKey) {
            if ($index === 0) {
                $series[] = round($mrrCents / self::CENTS_TO_DOLLARS, 2);
                continue;
            }

            $mrrCents += ($startsByMonthCents[$monthKey] ?? 0) - ($endsByMonthCents[$monthKey] ?? 0);
            $series[] = round($mrrCents / self::CENTS_TO_DOLLARS, 2);
        }

        return $series;
    }

}
