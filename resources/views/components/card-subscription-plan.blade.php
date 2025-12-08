@props(['plan'])

<article
    {{ $attributes->merge(['class' => 'flex w-full flex-col gap-6 rounded-radius border p-8 ' . ($plan->is_featured ?? false ? 'relative border-2 border-primary dark:border-primary-dark dark:bg-surface-dark/50' : 'border-outline bg-surface dark:border-outline-dark dark:bg-surface-dark/50')]) }}>

    <!-- Most Popular Badge -->
    @if (isset($plan->is_featured) && $plan->is_featured)
        <div class="absolute -top-3 left-1/2 -translate-x-1/2">
            <span
                class="rounded-radius bg-primary px-3 py-1 text-xs font-semibold text-on-primary dark:bg-primary-dark dark:text-on-primary-dark">
                {{ __('Most Popular') }}
            </span>
        </div>
    @endif

    <!-- Plan Details -->
    <div class="flex w-full items-start justify-start">
        <div>
            <p class="heading-4 text-on-surface-strong dark:text-on-surface-dark-strong">
                {{ __($plan->name) }}
            </p>

            <div class="mt-4 flex flex-col">
                <span class="text-xl">
                    <span class="sr-only size-0">{{ __('Price') }}</span>
                    <div class="flex flex-col gap-2">
                        <span class="text-3xl font-bold text-primary dark:text-primary-dark">
                            {{ Number::currency($plan->price / 100, $plan->currency ?? 'USD') }}
                        </span>
                        <small class="text-xs text-on-surface-muted dark:text-on-surface-dark-muted">
                            @if (isset($plan->billing_period) && $plan->billing_period !== 'one-time')
                                {{ __('per :period', ['period' => __($plan->billing_period)]) }}
                            @else
                                {{ __('One-time payment') }}
                            @endif
                        </small>
                        @if (isset($plan->trial_period) && $plan->trial_period && $plan->trial_interval)
                            <small class="text-xs font-medium text-primary dark:text-primary-dark">
                                {{ (int) $plan->trial_interval }}
                                {{ Str::plural($plan->trial_period, (int) $plan->trial_interval) }}
                                {{ __('free trial') }}
                            </small>
                        @endif
                    </div>
                </span>
            </div>

            <!-- Checkout Actions -->
            <div class="flex flex-col gap-2 my-6">
                @php
                    $href = isset($plan->href)
                        ? $plan->href
                        : (isset($plan->lemon_squeezy_variant_id)
                            ? route('plans.show', $plan->lemon_squeezy_variant_id)
                            : '#');
                    $buttonText = isset($plan->button_text) ? $plan->button_text : __('Subscribe');
                @endphp
                <x-button :variant="$plan->is_featured ?? false ? 'primary' : 'outline'" :href="$href" class="flex items-center justify-center gap-2 w-full">
                    {{ __($buttonText) }}
                </x-button>
            </div>

            <div
                class="mt-2 text-sm text-on-surface-muted dark:text-on-surface-dark-muted text-pretty prose prose-sm dark:prose-invert max-w-none">
                {!! $plan->description !!}
            </div>
        </div>
    </div>

</article>
