<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AiUsageController extends Controller
{
    private const DEFAULT_TIMEZONE = 'America/New_York';

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
     * Display a listing of AI usage records
     *
     * Authorization is handled by the 'role:admin' middleware at the route level
     */
    public function index(Request $request): View
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

        // Get all AI usage metrics in a single optimized query
        $metrics = $this->getMetrics($startDate, $endDate, $previousStartDate);

        // Calculate percentage changes
        $tokensChange = $metrics['previousAiTokens'] > 0
            ? round((($metrics['aiTokens'] - $metrics['previousAiTokens']) / $metrics['previousAiTokens']) * 100)
            : ($metrics['aiTokens'] > 0 ? 100 : 0);

        $costChange = $metrics['previousAiCost'] > 0
            ? round((($metrics['aiCost'] - $metrics['previousAiCost']) / $metrics['previousAiCost']) * 100)
            : ($metrics['aiCost'] > 0 ? 100 : 0);

        // Get human-readable label for date range
        $dateRangeLabel = $this->getDateRangeLabel($dateRange);
        $comparisonLabel = $this->getComparisonLabel($dateRange);

        // Get model usage aggregation filtered by date range
        $modelUsage = $this->getModelUsage($startDate, $endDate);

        return view('pages.admin.ai-usage.index', array_merge($metrics, [
            'tokensChange' => $tokensChange,
            'costChange' => $costChange,
            'dateRange' => $dateRange,
            'dateRangeLabel' => $dateRangeLabel,
            'comparisonLabel' => $comparisonLabel,
            'modelUsage' => $modelUsage,
        ]));
    }

    /**
     * Get all AI usage metrics with optimized queries
     */
    private function getMetrics(Carbon $startDate, Carbon $endDate, Carbon $previousStartDate): array
    {
        // Get all metrics in a single query using CASE WHEN statements
        // Use DB::table to avoid model eager loading
        $results = DB::table('ai_usages')
            ->selectRaw('
                SUM(CASE WHEN created_at >= ? AND created_at <= ? THEN total_tokens ELSE 0 END) as current_tokens,
                SUM(CASE WHEN created_at >= ? AND created_at < ? THEN total_tokens ELSE 0 END) as previous_tokens,
                SUM(CASE WHEN created_at >= ? AND created_at <= ? THEN total_cost ELSE 0 END) as current_cost,
                SUM(CASE WHEN created_at >= ? AND created_at < ? THEN total_cost ELSE 0 END) as previous_cost,
                SUM(total_tokens) as total_tokens,
                SUM(total_cost) as total_cost
            ', [
                $startDate,
                $endDate,
                $previousStartDate,
                $startDate,
                $startDate,
                $endDate,
                $previousStartDate,
                $startDate,
            ])
            ->first();

        return [
            'aiTokens' => (int) ($results->current_tokens ?? 0),
            'previousAiTokens' => (int) ($results->previous_tokens ?? 0),
            'aiCost' => (float) ($results->current_cost ?? 0),
            'previousAiCost' => (float) ($results->previous_cost ?? 0),
            'totalTokens' => (int) ($results->total_tokens ?? 0),
            'totalCost' => (float) ($results->total_cost ?? 0),
        ];
    }

    /**
     * Get start date, end date, and previous start date for a given date range
     *
     * @return array{0: \Carbon\Carbon, 1: \Carbon\Carbon, 2: \Carbon\Carbon} Start date, end date, and previous start date
     */
    private function getDateRangeDates(string $range, Request $request): array
    {
        $timezone = $this->getTimezone($request);
        $endDate = Carbon::now($timezone)->endOfDay();

        $dates = match ($range) {
            'today' => [
                Carbon::now($timezone)->startOfDay(),
                $endDate,
                Carbon::now($timezone)->subDay()->startOfDay(),
            ],
            'yesterday' => [
                Carbon::now($timezone)->subDay()->startOfDay(),
                Carbon::now($timezone)->subDay()->endOfDay(),
                Carbon::now($timezone)->subDays(2)->startOfDay(),
            ],
            'last_7_days' => [
                Carbon::now($timezone)->subDays(6)->startOfDay(),
                $endDate,
                Carbon::now($timezone)->subDays(13)->startOfDay(),
            ],
            'last_10_days' => [
                Carbon::now($timezone)->subDays(9)->startOfDay(),
                $endDate,
                Carbon::now($timezone)->subDays(19)->startOfDay(),
            ],
            'last_30_days' => [
                Carbon::now($timezone)->subDays(29)->startOfDay(),
                $endDate,
                Carbon::now($timezone)->subDays(59)->startOfDay(),
            ],
            'last_3_months' => [
                Carbon::now($timezone)->subMonths(2)->startOfMonth(),
                $endDate,
                Carbon::now($timezone)->subMonths(5)->startOfMonth(),
            ],
            'last_6_months' => [
                Carbon::now($timezone)->subMonths(5)->startOfMonth(),
                $endDate,
                Carbon::now($timezone)->subMonths(11)->startOfMonth(),
            ],
            'ytd' => [
                Carbon::now($timezone)->startOfYear(),
                $endDate,
                Carbon::now($timezone)->subYear()->startOfYear(),
            ],
            default => [
                Carbon::now($timezone)->subDays(29)->startOfDay(),
                $endDate,
                Carbon::now($timezone)->subDays(59)->startOfDay(),
            ],
        };

        return $dates;
    }

    /**
     * Get human-readable label for date range
     *
     * @param  string  $range  Date range identifier
     * @return string Human-readable label
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
     *
     * @param  string  $range  Date range identifier
     * @return string Human-readable comparison label
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
     * Get aggregated AI usage by model filtered by date range
     */
    private function getModelUsage(Carbon $startDate, Carbon $endDate): \Illuminate\Support\Collection
    {
        return DB::table('ai_usages')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('
                model,
                SUM(total_tokens) as total_tokens,
                SUM(total_cost) as total_cost,
                COUNT(*) as usage_count
            ')
            ->groupBy('model')
            ->orderByDesc('total_tokens')
            ->get();
    }

    /**
     * Get timezone from authenticated user or fallback to default.
     */
    private function getTimezone(Request $request): string
    {
        $user = $request->user() ?? Auth::user();

        return $user?->timezone ?? self::DEFAULT_TIMEZONE;
    }
}
