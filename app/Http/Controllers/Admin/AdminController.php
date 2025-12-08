<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use LemonSqueezy\Laravel\Order;

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

        [$startDate, $endDate, $previousStartDate] = $this->getDateRangeDates($dateRange, $request);

        // Get metrics data with optimized queries
        $metrics = $this->getMetrics($startDate, $endDate, $previousStartDate, $request);

        // Determine chart interval and get data based on date range
        $useDaily = $this->shouldUseDailyInterval($dateRange);

        if ($useDaily) {
            [$revenueData, $labels] = $this->getDailyRevenue($startDate, $endDate);
            $subscriptionData = $this->getDailyTotalSubscriptionsOptimized($startDate, $endDate, $request);
        } else {
            $chartMonths = $this->getChartMonthsForRange($dateRange, $request);
            [$revenueData, $labels] = $this->getMonthlyRevenue($chartMonths, $startDate, $request);
            $subscriptionData = $this->getMonthlyTotalSubscriptionsOptimized($chartMonths, $startDate, $request);
        }

        // Get human-readable labels for date range
        $dateRangeLabel = $this->getDateRangeLabel($dateRange);
        $comparisonLabel = $this->getComparisonLabel($dateRange);

        return view('pages.admin.dashboard', array_merge($metrics, [
            'revenueData' => $revenueData,
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
    private function getMetrics(Carbon $startDate, Carbon $endDate, Carbon $previousStartDate, Request $request): array
    {
        // Get revenue for all three periods in parallel queries
        $revenueQuery = Order::query()
            ->selectRaw('
                SUM(CASE WHEN ordered_at >= ? AND ordered_at <= ? THEN CAST(total AS DECIMAL(10,2)) ELSE 0 END) as current_revenue,
                SUM(CASE WHEN ordered_at >= ? AND ordered_at < ? THEN CAST(total AS DECIMAL(10,2)) ELSE 0 END) as previous_revenue,
                SUM(CASE WHEN ordered_at >= ? THEN CAST(total AS DECIMAL(10,2)) ELSE 0 END) as ytd_revenue
            ', [
                $startDate, $endDate,
                $previousStartDate, $startDate,
                Carbon::now()->startOfYear(),
            ])
            ->where('status', 'paid');

        $revenueResults = $revenueQuery->first();

        $revenue = round((float) $revenueResults->current_revenue / self::CENTS_TO_DOLLARS, 2);
        $previousRevenue = round((float) $revenueResults->previous_revenue / self::CENTS_TO_DOLLARS, 2);
        $ytdRevenue = round((float) $revenueResults->ytd_revenue / self::CENTS_TO_DOLLARS, 2);

        // Get subscription counts for current and previous periods
        // Use DB::table to avoid model eager loading
        $subscriptionCounts = DB::table('lemon_squeezy_subscriptions')
            ->selectRaw('
                COUNT(CASE WHEN created_at >= ? AND created_at <= ? THEN 1 END) as new_subscriptions,
                COUNT(CASE WHEN created_at >= ? AND created_at < ? THEN 1 END) as previous_subscriptions,
                COUNT(CASE WHEN status = ? AND updated_at >= ? AND updated_at <= ? THEN 1 END) as cancelled_subscriptions,
                COUNT(CASE WHEN status = ? AND updated_at >= ? AND updated_at < ? THEN 1 END) as previous_cancelled_subscriptions
            ', [
                $startDate, $endDate,
                $previousStartDate, $startDate,
                'cancelled', $startDate, $endDate,
                'cancelled', $previousStartDate, $startDate,
            ])
            ->first();

        // Get order counts for current and previous periods
        $orderCounts = Order::query()
            ->where('status', '!=', 'pending')
            ->where('status', '!=', 'failed')
            ->selectRaw('
                COUNT(CASE WHEN ordered_at >= ? AND ordered_at <= ? THEN 1 END) as new_orders,
                COUNT(CASE WHEN ordered_at >= ? AND ordered_at < ? THEN 1 END) as previous_orders
            ', [
                $startDate, $endDate,
                $previousStartDate, $startDate,
            ])
            ->first();

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

        $subscriptionsChange = $subscriptionCounts->previous_subscriptions > 0
            ? round((($subscriptionCounts->new_subscriptions - $subscriptionCounts->previous_subscriptions) / $subscriptionCounts->previous_subscriptions) * 100)
            : ($subscriptionCounts->new_subscriptions > 0 ? 100 : 0);

        $ordersChange = $orderCounts->previous_orders > 0
            ? round((($orderCounts->new_orders - $orderCounts->previous_orders) / $orderCounts->previous_orders) * 100)
            : ($orderCounts->new_orders > 0 ? 100 : 0);

        $usersChange = $userCounts->previous_users > 0
            ? round((($userCounts->new_users - $userCounts->previous_users) / $userCounts->previous_users) * 100)
            : ($userCounts->new_users > 0 ? 100 : 0);

        $cancelledSubscriptionsChange = $subscriptionCounts->previous_cancelled_subscriptions > 0
            ? round((($subscriptionCounts->cancelled_subscriptions - $subscriptionCounts->previous_cancelled_subscriptions) / $subscriptionCounts->previous_cancelled_subscriptions) * 100)
            : ($subscriptionCounts->cancelled_subscriptions > 0 ? 100 : 0);

        return [
            'newSubscriptions' => $subscriptionCounts->new_subscriptions,
            'newOrders' => $orderCounts->new_orders,
            'revenue' => $revenue,
            'ytdRevenue' => $ytdRevenue,
            'percentageChange' => $percentageChange,
            'subscriptionsChange' => $subscriptionsChange,
            'ordersChange' => $ordersChange,
            'newUsers' => $userCounts->new_users,
            'usersChange' => $usersChange,
            'cancelledSubscriptions' => $subscriptionCounts->cancelled_subscriptions,
            'cancelledSubscriptionsChange' => $cancelledSubscriptionsChange,
        ];
    }

    /**
     * Get start date, end date, and previous start date for a given date range
     *
     * @return array{0: \Carbon\Carbon, 1: \Carbon\Carbon, 2: \Carbon\Carbon} Start date, end date, and previous start date
     */
    private function getDateRangeDates(string $range, Request $request): array
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
    private function getChartMonthsForRange(string $range, Request $request): int
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
     * Calculate daily revenue for a specified date range
     *
     * @return array{0: array<int, float>, 1: array<int, string>} Revenue data and date labels
     */
    private function getDailyRevenue(Carbon $startDate, Carbon $endDate): array
    {
        $dateFormat = $this->getDateFormatExpression('ordered_at', 'Y-m-d');

        // Generate all dates in range
        $dateKeys = [];
        $labels = [];
        $currentDate = $startDate->copy();

        while ($currentDate <= $endDate) {
            $dateKeys[] = $currentDate->format('Y-m-d');
            $labels[] = $currentDate->format('M j');
            $currentDate->addDay();
        }

        // Fetch revenue data
        $rawData = DB::table('lemon_squeezy_orders')
            ->selectRaw("{$dateFormat} as date, SUM(CAST(total AS DECIMAL(10,2))) as total")
            ->where('ordered_at', '>=', $startDate)
            ->where('ordered_at', '<=', $endDate)
            ->where('status', 'paid')
            ->groupBy(DB::raw($dateFormat))
            ->get()
            ->keyBy('date');

        // Map revenue to each date
        $revenueData = collect($dateKeys)->map(function ($dateKey) use ($rawData) {
            $total = (float) ($rawData->get($dateKey)?->total ?? 0);

            return round($total / self::CENTS_TO_DOLLARS, 2);
        })->values()->toArray();

        return [$revenueData, $labels];
    }

    /**
     * Calculate monthly revenue for a specified number of months
     *
     * @return array{0: array<int, float>, 1: array<int, string>} Revenue data and month labels
     */
    private function getMonthlyRevenue(int $numberOfMonths, ?Carbon $startDate, Request $request): array
    {
        $start = $startDate
            ? $startDate->copy()->startOfMonth()
            : Carbon::now()->startOfMonth()->subMonths($numberOfMonths - 1);

        [$monthKeys, $months] = $this->generateMonthData($numberOfMonths, $start);

        $dateFormat = $this->getDateFormatExpression('ordered_at');

        // Fetch revenue data using database-agnostic date formatting
        $rawData = DB::table('lemon_squeezy_orders')
            ->selectRaw("{$dateFormat} as month, SUM(CAST(total AS DECIMAL(10,2))) as total")
            ->where('ordered_at', '>=', $start)
            ->where('status', 'paid')
            ->groupBy(DB::raw($dateFormat))
            ->get()
            ->keyBy('month');

        // Map revenue to each month, using 0 for months with no revenue
        $revenueData = collect($monthKeys)->map(function ($monthKey) use ($rawData) {
            $total = (float) ($rawData->get($monthKey)?->total ?? 0);

            return round($total / self::CENTS_TO_DOLLARS, 2);
        })->values()->toArray();

        return [$revenueData, $months];
    }

    /**
     * Calculate daily total active subscriptions - OPTIMIZED VERSION
     *
     * Uses a single query instead of N queries (one per day)
     *
     * @return array<int, int> Total active subscription counts per day
     */
    private function getDailyTotalSubscriptionsOptimized(Carbon $startDate, Carbon $endDate, Request $request): array
    {
        // Generate all dates in range
        $dateKeys = [];
        $currentDate = $startDate->copy();

        while ($currentDate <= $endDate) {
            $dateKeys[] = $currentDate->format('Y-m-d');
            $currentDate->addDay();
        }

        // Get all relevant subscriptions in a single query
        // Use DB::table to avoid model eager loading
        $subscriptions = DB::table('lemon_squeezy_subscriptions')
            ->select(['created_at', 'ends_at'])
            ->where('created_at', '<=', $endDate)
            ->where('status', 'active')
            ->get();

        // Calculate counts for each date in memory
        return collect($dateKeys)->map(function ($dateKey) use ($subscriptions) {
            $date = Carbon::createFromFormat('Y-m-d', $dateKey)->endOfDay();

            return $subscriptions->filter(function ($subscription) use ($date) {
                // Parse dates as UTC (database stores in UTC)
                $createdAt = Carbon::parse($subscription->created_at);
                $endsAt = $subscription->ends_at ? Carbon::parse($subscription->ends_at) : null;

                // Subscription was created before or on this date
                $createdBeforeDate = $createdAt <= $date;

                // Subscription hasn't ended yet or ends after this date
                $stillActiveOnDate = $endsAt === null || $endsAt > $date;

                return $createdBeforeDate && $stillActiveOnDate;
            })->count();
        })->values()->toArray();
    }

    /**
     * Calculate monthly total active subscriptions - OPTIMIZED VERSION
     *
     * Uses a single query instead of N queries (one per month)
     *
     * @return array<int, int> Total active subscription counts per month
     */
    private function getMonthlyTotalSubscriptionsOptimized(int $numberOfMonths, ?Carbon $startDate, Request $request): array
    {
        $start = $startDate
            ? $startDate->copy()->startOfMonth()
            : Carbon::now()->startOfMonth()->subMonths($numberOfMonths - 1);

        [$monthKeys] = $this->generateMonthData($numberOfMonths, $start);

        // Calculate the last month end date
        $lastMonthEnd = Carbon::createFromFormat('Y-m', end($monthKeys))->endOfMonth();

        // Get all relevant subscriptions in a single query
        // Use DB::table to avoid model eager loading
        $subscriptions = DB::table('lemon_squeezy_subscriptions')
            ->select(['created_at', 'ends_at'])
            ->where('created_at', '<=', $lastMonthEnd)
            ->where('status', 'active')
            ->get();

        // Calculate counts for each month in memory
        return collect($monthKeys)->map(function ($monthKey) use ($subscriptions) {
            $monthEnd = Carbon::createFromFormat('Y-m', $monthKey)->endOfMonth();

            return $subscriptions->filter(function ($subscription) use ($monthEnd) {
                // Parse dates as UTC (database stores in UTC)
                $createdAt = Carbon::parse($subscription->created_at);
                $endsAt = $subscription->ends_at ? Carbon::parse($subscription->ends_at) : null;

                // Subscription was created before or at end of this month
                $createdBeforeMonth = $createdAt <= $monthEnd;

                // Subscription hasn't ended yet or ends after this month
                $stillActiveInMonth = $endsAt === null || $endsAt > $monthEnd;

                return $createdBeforeMonth && $stillActiveInMonth;
            })->count();
        })->values()->toArray();
    }

}
