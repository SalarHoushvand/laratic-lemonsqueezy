@push('head')
    <title>{{ __('AI Usage') }} - {{ config('app.name') }}</title>
@endpush

<x-layouts.admin>
    <x-typography.admin-page-header :title="__('AI Usage')" :description="__('View and manage AI usage records here.')" />

    <!-- Date Range Selector -->
    <div class="mb-6 max-w-full md:max-w-[23.4%] space-y-0.5">
        <x-date-range-selector :selected="$dateRange" />
        <small class="text-on-surface-muted dark:text-on-surface-dark-muted text-xs">{{ __('All times are in UTC') }}</small>
    </div>

    <!-- AI Usage Statistics -->
    <x-blocks.admin.ai-usage.stats :aiTokens="$aiTokens" :aiCost="$aiCost" :tokensChange="$tokensChange"
        :costChange="$costChange" :totalTokens="$totalTokens" :totalCost="$totalCost" :dateRangeLabel="$dateRangeLabel"
        :comparisonLabel="$comparisonLabel" />

    <!-- Model Usage Summary Table -->
    @if ($modelUsage->isNotEmpty())
        <div class="mt-6">
            <h2 class="sr-only">
                {{ __('Usage by Model') }}
            </h2>
            <x-table>
                <x-slot:head>
                    <th scope="col" class="p-4">{{ __('Model') }}</th>
                    <th scope="col" class="p-4">{{ __('Total Tokens') }}</th>
                    <th scope="col" class="p-4">{{ __('Total Cost') }}</th>
                    <th scope="col" class="p-4">{{ __('Usage Count') }}</th>
                </x-slot:head>

                <x-slot:body>
                    @foreach ($modelUsage as $usage)
                        <tr>
                            <td class="p-4">
                                <x-badge>{{ $usage->model }}</x-badge>
                            </td>
                            <td class="p-4 font-mono">
                                {{ number_format($usage->total_tokens) }}
                            </td>
                            <td class="p-4 font-mono">
                                {{ number_format($usage->total_cost, 5) }} USD
                            </td>
                            <td class="p-4 font-mono">
                                {{ number_format($usage->usage_count) }}
                            </td>
                        </tr>
                    @endforeach
                </x-slot:body>
            </x-table>
        </div>
    @endif

    <!-- User Usage Table -->
    <div class="mt-6">
        <livewire:admin.ai-usage.ai-usage-table />
    </div>
</x-layouts.admin>

