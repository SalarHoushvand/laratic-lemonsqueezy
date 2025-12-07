@push('head')
    <title>{{ __('Manage your subscription - :app', ['app' => config('app.name')]) }}</title>
    <meta name="description"
        content="{{ __('Manage your subscription to :app. Update your payment method, cancel your subscription, or switch to a different plan.', ['app' => config('app.name')]) }}">
@endpush

<div class="space-y-8 p-8">
    @php
        $userSubscription = $user->subscription();
        $isSubscribed = $userSubscription && $userSubscription->valid();
    @endphp

    @if ($isSubscribed && $userSubscription)
        <!-- Current Subscription Status -->
        <div class="panel">
            <div class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
                <div class="space-y-3">
                    <div class="flex items-center gap-3">
                        <h2 class="heading-5 text-on-surface-strong dark:text-on-surface-dark-strong">
                            {{ __('Current Subscription') }}
                        </h2>
                        @if ($currentPlan)
                            <x-badge variant="primary" size="sm">
                                {{ $currentPlan }}
                            </x-badge>
                        @endif
                    </div>

                    <div class="space-y-1 text-sm text-on-surface-muted dark:text-on-surface-dark-muted">
                        @if ($userSubscription->onGracePeriod())
                            <p>
                                <span class="text-on-surface dark:text-on-surface-dark">{{ __('Ends on:') }}</span>
                                <span class="font-medium">{{ $userSubscription->ends_at->format('M d, Y') }}</span>
                            </p>
                        @endif

                        @if ($userSubscription->onTrial())
                            <p>
                                <span class="text-on-surface dark:text-on-surface-dark">{{ __('Trial ends:') }}</span>
                                <span
                                    class="font-medium">{{ $userSubscription->trial_ends_at->format('M d, Y') }}</span>
                            </p>
                        @endif

                        @if ($nextPaymentAmount && $nextPaymentCurrency && $nextPaymentDate)
                            <p>
                                <span class="text-on-surface dark:text-on-surface-dark">{{ __('Next payment:') }}</span>
                                <span class="font-medium">
                                    {{ Number::currency($nextPaymentAmount / 100, $nextPaymentCurrency) }}
                                    {{ __('on') }} {{ $nextPaymentDate->format('M d, Y') }}
                                </span>
                            </p>
                        @endif
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex flex-wrap gap-2">
                    <x-button variant="alternative" size="sm" wire:click="updatePaymentMethod">
                        <x-icons.credit-card variant="outline" size="sm" />
                        {{ __('Update Payment') }}
                    </x-button>

                    @if (!$userSubscription->onGracePeriod())
                        <x-blocks.plans.cancel-plan>
                            <x-button variant="ghost" size="sm">
                                {{ __('Cancel Subscription') }}
                            </x-button>
                        </x-blocks.plans.cancel-plan>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <!-- Available Plans -->
    @if ($plans->isNotEmpty())
        @php
            $monthlyPlans = $plans->where('billing_period', 'month');
            $yearlyPlans = $plans->where('billing_period', 'year');
            $hasMonthly = $monthlyPlans->count() > 0;
            $hasYearly = $yearlyPlans->count() > 0;
        @endphp

        <div x-data="{ billingPeriod: '{{ $hasMonthly ? 'monthly' : 'yearly' }}' }">
            <h2 class="heading-5 mb-6 text-on-surface-strong dark:text-on-surface-dark-strong">
                {{ $isSubscribed ? __('Switch Plan') : __('Choose a Plan') }}
            </h2>

            @if ($hasMonthly && $hasYearly)
                <div class="flex justify-center mb-8">
                    <div
                        class="inline-flex items-center gap-3 p-1 bg-surface dark:bg-surface-dark rounded-radius border border-outline dark:border-outline-dark">
                        <button x-on:click="billingPeriod = 'monthly'"
                            x-bind:class="billingPeriod === 'monthly' ?
                                'bg-primary text-on-primary dark:bg-primary-dark dark:text-on-primary-dark' :
                                'text-on-surface dark:text-on-surface-dark hover:text-on-surface-strong dark:hover:text-on-surface-dark-strong'"
                            class="px-6 py-2 rounded-radius text-sm font-medium transition-all duration-200"
                            type="button">
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

            <div x-show="billingPeriod === 'monthly'" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                @if ($hasMonthly)
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                        @foreach ($monthlyPlans as $plan)
                            <article wire:key="plan-monthly-{{ $plan->id }}"
                                class="panel relative flex flex-col transition-all {{ $plan->is_featured ? 'border-primary dark:border-primary-dark' : 'border-outline dark:border-outline-dark' }} ">

                                @if ($plan->is_featured)
                                    <div class="absolute -top-3 left-6">
                                        <x-badge variant="primary" size="sm">
                                            {{ __('Popular') }}
                                        </x-badge>
                                    </div>
                                @endif

                                <!-- Plan Name -->
                                <div class="mb-4">
                                    <h3
                                        class="text-lg font-semibold text-on-surface-strong dark:text-on-surface-dark-strong">
                                        {{ __($plan->name) }}
                                    </h3>
                                    @if ($currentPlan === $plan->name)
                                        <x-badge variant="primary" size="xs" class="mt-2">
                                            {{ __('Current') }}
                                        </x-badge>
                                    @endif
                                </div>

                                <!-- Price -->
                                <div class="mb-4">
                                    <div class="flex items-baseline gap-1">
                                        <span
                                            class="text-3xl font-bold text-on-surface-strong dark:text-on-surface-dark-strong">
                                            {{ Number::currency($plan->price / 100, $plan->currency) }}
                                        </span>
                                        <span class="text-sm text-on-surface-muted dark:text-on-surface-dark-muted">
                                            /{{ $plan->billing_period }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Description -->
                                <p class="mb-6 text-sm text-on-surface-muted dark:text-on-surface-dark-muted">
                                    {{ __($plan->description) }}
                                </p>

                                <!-- Action Button -->
                                <div class="mt-auto">
                                    @if ($isSubscribed && $userSubscription && !$userSubscription->onGracePeriod() && !$userSubscription->onTrial())
                                        @if ($currentPlan !== $plan->name)
                                            <x-blocks.plans.swap-plan :plan="$plan">
                                                <x-button class="w-full" :variant="$plan->is_featured ? 'primary' : 'outline'" size="sm">
                                                    {{ __('Switch to :plan', ['plan' => $plan->name]) }}
                                                </x-button>
                                            </x-blocks.plans.swap-plan>
                                        @else
                                            <x-button class="w-full" variant="outline" size="sm" disabled>
                                                {{ __('Current Plan') }}
                                            </x-button>
                                        @endif
                                    @elseif ($userSubscription && $userSubscription->onTrial())
                                        @if ($currentPlan === $plan->name)
                                            <x-button class="w-full" variant="outline" size="sm" disabled>
                                                {{ __('Current Plan') }}
                                            </x-button>
                                        @else
                                            <p class="text-xs text-on-surface-muted dark:text-on-surface-dark-muted">
                                                {{ __('End trial to switch plans') }}
                                            </p>
                                        @endif
                                    @else
                                        <x-button :variant="$plan->is_featured ? 'primary' : 'outline'" :href="route('plans.show', $plan->lemon_squeezy_variant_id)" class="w-full" size="sm">
                                            {{ __('Get Started') }}
                                        </x-button>
                                    @endif
                                </div>
                            </article>
                        @endforeach
                    </div>
                @else
                    <div class="flex h-[20vh] items-center justify-center">
                        <p class="text-on-surface-muted dark:text-on-surface-dark-muted">
                            {{ __('No monthly plans available at the moment') }}
                        </p>
                    </div>
                @endif
            </div>

            <div x-show="billingPeriod === 'yearly'" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                @if ($hasYearly)
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                        @foreach ($yearlyPlans as $plan)
                            <article wire:key="plan-yearly-{{ $plan->id }}"
                                class="panel relative flex flex-col transition-all {{ $plan->is_featured ? 'border-primary dark:border-primary-dark' : 'border-outline dark:border-outline-dark' }} ">

                                @if ($plan->is_featured)
                                    <div class="absolute -top-3 left-6">
                                        <x-badge variant="primary" size="sm">
                                            {{ __('Popular') }}
                                        </x-badge>
                                    </div>
                                @endif

                                <!-- Plan Name -->
                                <div class="mb-4">
                                    <h3
                                        class="text-lg font-semibold text-on-surface-strong dark:text-on-surface-dark-strong">
                                        {{ __($plan->name) }}
                                    </h3>
                                    @if ($currentPlan === $plan->name)
                                        <x-badge variant="primary" size="xs" class="mt-2">
                                            {{ __('Current') }}
                                        </x-badge>
                                    @endif
                                </div>

                                <!-- Price -->
                                <div class="mb-4">
                                    <div class="flex items-baseline gap-1">
                                        <span
                                            class="text-3xl font-bold text-on-surface-strong dark:text-on-surface-dark-strong">
                                            {{ Number::currency($plan->price / 100, $plan->currency) }}
                                        </span>
                                        <span class="text-sm text-on-surface-muted dark:text-on-surface-dark-muted">
                                            /{{ $plan->billing_period }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Description -->
                                <p class="mb-6 text-sm text-on-surface-muted dark:text-on-surface-dark-muted">
                                    {{ __($plan->description) }}
                                </p>

                                <!-- Action Button -->
                                <div class="mt-auto">
                                    @if ($isSubscribed && $userSubscription && !$userSubscription->onGracePeriod() && !$userSubscription->onTrial())
                                        @if ($currentPlan !== $plan->name)
                                            <x-blocks.plans.swap-plan :plan="$plan">
                                                <x-button class="w-full" :variant="$plan->is_featured ? 'primary' : 'outline'" size="sm">
                                                    {{ __('Switch to :plan', ['plan' => $plan->name]) }}
                                                </x-button>
                                            </x-blocks.plans.swap-plan>
                                        @else
                                            <x-button class="w-full" variant="outline" size="sm" disabled>
                                                {{ __('Current Plan') }}
                                            </x-button>
                                        @endif
                                    @elseif ($userSubscription && $userSubscription->onTrial())
                                        @if ($currentPlan === $plan->name)
                                            <x-button class="w-full" variant="outline" size="sm" disabled>
                                                {{ __('Current Plan') }}
                                            </x-button>
                                        @else
                                            <p class="text-xs text-on-surface-muted dark:text-on-surface-dark-muted">
                                                {{ __('End trial to switch plans') }}
                                            </p>
                                        @endif
                                    @else
                                        <x-button :variant="$plan->is_featured ? 'primary' : 'outline'" :href="route('plans.show', $plan->lemon_squeezy_variant_id)" class="w-full" size="sm">
                                            {{ __('Get Started') }}
                                        </x-button>
                                    @endif
                                </div>
                            </article>
                        @endforeach
                    </div>
                @else
                    <div class="flex h-[20vh] items-center justify-center">
                        <p class="text-on-surface-muted dark:text-on-surface-dark-muted">
                            {{ __('No yearly plans available at the moment') }}
                        </p>
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="flex h-[40vh] items-center justify-center">
            <p class="text-on-surface-muted dark:text-on-surface-dark-muted">
                {{ __('No plans available at the moment') }}
            </p>
        </div>
    @endif
</div>
