@php
    use App\Models\Plan;
    
    $plans = Plan::where('status', 'published')
        ->orderBy('sort_order')
        ->orderByDesc('is_featured')
        ->orderBy('id')
        ->get();
        
    $monthlyPlans = $plans->where('billing_period', 'month');
    $yearlyPlans = $plans->where('billing_period', 'year');
    $hasMonthly = $monthlyPlans->count() > 0;
    $hasYearly = $yearlyPlans->count() > 0;
@endphp

<div {{ $attributes }} x-data="{ billingPeriod: '{{ $hasMonthly ? 'monthly' : 'yearly' }}' }">
    <!-- Header Section -->
    <div class="flex flex-col justify-center items-center gap-4">
        <x-typography.guest-page-header
            title="{{ __('Pricing') }}"
            description="{{ __('Affordable pricing for indie hackers and solo developers.') }}"
            size="h2"
            :divider-dots="true" />
    </div>

    @if ($hasMonthly && $hasYearly)
        <div class="flex justify-center mb-4 md:mb-12 mt-8">
            <div
                class="inline-flex items-center gap-3 p-1 bg-surface dark:bg-surface-dark rounded-radius border border-outline dark:border-outline-dark">
                <button x-on:click="billingPeriod = 'monthly'"
                    x-bind:class="billingPeriod === 'monthly' ?
                        'bg-primary text-on-primary dark:bg-primary-dark dark:text-on-primary-dark' :
                        'text-on-surface dark:text-on-surface-dark hover:text-on-surface-strong dark:hover:text-on-surface-dark-strong'"
                    class="px-6 py-2 rounded-radius text-sm font-medium transition-all duration-200" type="button">
                    {{ __('Monthly') }}
                </button>
                <button x-on:click="billingPeriod = 'yearly'"
                    x-bind:class="billingPeriod === 'yearly' ?
                        'bg-primary text-on-primary dark:bg-primary-dark dark:text-on-primary-dark' :
                        'text-on-surface dark:text-on-surface-dark hover:text-on-surface-strong dark:hover:text-on-surface-dark-strong'"
                    class="px-6 py-2 rounded-radius text-sm font-medium transition-all duration-200 flex items-center gap-2"
                    type="button">
                    {{ __('Yearly') }}
                    <x-badge size="xs">
                        {{ __('Save 20%') }}
                    </x-badge>
                </button>
            </div>
        </div>
    @endif

    <div x-cloak x-show="billingPeriod === 'monthly'" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
        @if ($hasMonthly)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mt-8">
                @foreach ($monthlyPlans as $plan)
                    <x-card-subscription-plan :plan="$plan" />
                @endforeach
            </div>
        @else
            <x-blocks.empty-state icon="credit-card" title="{{ __('No monthly plans found') }}"
                description="{{ __('There are no monthly plans available.') }}" />
        @endif
    </div>

    <div x-cloak x-show="billingPeriod === 'yearly'" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
        @if ($hasYearly)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mt-8">
                @foreach ($yearlyPlans as $plan)
                    <x-card-subscription-plan :plan="$plan" />
                @endforeach
            </div>
        @else
            <x-blocks.empty-state icon="credit-card" title="{{ __('No yearly plans found') }}"
                description="{{ __('There are no yearly plans available.') }}" />
        @endif
    </div>
</div>
