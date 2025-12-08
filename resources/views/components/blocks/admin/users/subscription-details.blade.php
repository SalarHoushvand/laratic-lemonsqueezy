<div class="flex h-full flex-col gap-4 panel">
    <h2 class="heading-5 text-on-surface-strong dark:text-on-surface-dark-strong">
        {{ __('Subscription') }}
    </h2>

    @if ($user->subscribed())
        <p class="text-sm text-on-surface dark:text-on-surface-dark">
            {{ __('Subscribed to the :plan plan.', ['plan' => $user->currentPlanName()]) }}
        </p>
        @if ($user->subscription()->cancelled())
            <p class="text-sm text-on-surface dark:text-on-surface-dark">
                @if ($user->subscription()->expired())
                    {{ __('Subscription expired on :date.', ['date' => $user->subscription()->ends_at?->format('M d, Y') ?? 'N/A']) }}
                @else
                    {{ __('Subscription will be cancelled on :date.', ['date' => $user->subscription()->ends_at?->format('M d, Y') ?? 'N/A']) }}
                @endif
            </p>
        @endif
        @if ($user->subscription()->onTrial())
            <p class="text-sm text-on-surface dark:text-on-surface-dark">
                {{ __('On trial until :date.', ['date' => $user->subscription()->trial_ends_at->format('M d, Y')]) }}
            </p>
        @endif
    @else
       <x-blocks.empty-state icon="credit-card"  title="{{ __('No subscription') }}"
       description="{{ __('We couldn’t find any subscription') }}" />
    @endif

    @if ($user->subscribed())
        <div class="mt-auto">
            <livewire:admin.subscription.cancel-subscription :subscription="$user->subscription()" />
        </div>
    @endif
</div>
