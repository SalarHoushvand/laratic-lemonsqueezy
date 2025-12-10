@push('head')
    <title>{{ __('Invoice :invoice', ['invoice' => $invoice->lemon_squeezy_id]) }} - {{ config('app.name') }}</title>
@endpush

<x-layouts.admin>
    <div class="flex flex-col gap-4 items-center justify-between md:flex-row">
        <h1 class="heading-4 text-on-surface dark:text-on-surface-dark">
            {{ __('Subscription Invoice') }} #{{ $invoice->lemon_squeezy_id }}
        </h1>
    </div>

    <!-- Invoice Details -->
    <div class="flex flex-col gap-8 md:flex-row mt-8">
        <!-- Invoice Information -->
        <div class="w-full">
            <div class="panel h-full">
                <h2 class="font-medium mb-4 text-lg text-on-surface-strong dark:text-on-surface-dark-strong">
                    {{ __('Invoice Information') }}
                </h2>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <p class="text-on-surface-muted dark:text-on-surface-dark-muted text-sm mb-1">
                            {{ __('Invoice Date') }}
                        </p>
                        @php
                            $invoiceDate = $invoice->invoiced_at ?? $invoice->created_at;
                            $userTimezone = auth()->user()?->timezone ?? 'America/New_York';
                            // Get raw database value to avoid timezone conversion issues
                            // Use timestamp (timezone-agnostic) to create UTC Carbon instance
                            $timestamp = $invoiceDate->timestamp;
                            // Create Carbon instance from timestamp explicitly in UTC
                            $invoiceDateUtc = \Carbon\Carbon::createFromTimestamp($timestamp, 'UTC');
                            // GMT is the same as UTC
                            $gmtDate = $invoiceDateUtc->copy();
                            // Convert to user's timezone
                            $userDate = $invoiceDateUtc->copy()->setTimezone($userTimezone);
                        @endphp
                        <div class="space-y-1">
                            <p class="flex flex-col text-on-surface dark:text-on-surface-dark">
                                <span class="text-on-surface-muted dark:text-on-surface-dark-muted text-xs">GMT</span>
                                <span class="text-sm font-mono">{{ $gmtDate->format('M d, Y H:i:s') }}</span>
                            </p>
                            <p class="flex flex-col text-on-surface dark:text-on-surface-dark">
                                <span
                                    class="text-on-surface-muted dark:text-on-surface-dark-muted text-xs">{{ $userTimezone }}</span>
                                <span class="text-sm font-mono">{{ $userDate->format('M d, Y H:i:s') }}</span>
                            </p>
                        </div>
                    </div>

                    <div>
                        <p class="text-on-surface-muted dark:text-on-surface-dark-muted text-sm mb-1">
                            {{ __('Status') }}</p>
                        <p class="text-on-surface dark:text-on-surface-dark">
                            <x-badge :variant="match($invoice->status) {
                                'paid' => 'outline-success',
                                'pending' => 'outline-warning',
                                'refunded' => 'outline-danger',
                                'void' => 'outline-secondary',
                                default => 'outline-secondary',
                            }">
                                {{ __(ucfirst($invoice->status)) }}
                            </x-badge>
                        </p>
                    </div>

                    <div>
                        <p class="text-on-surface-muted dark:text-on-surface-dark-muted text-sm mb-1">
                            {{ __('Billing Reason') }}</p>
                        <p class="text-on-surface dark:text-on-surface-dark">
                            <x-badge>{{ __(ucfirst($invoice->billing_reason)) }}</x-badge>
                        </p>
                    </div>

                    <div>
                        <p class="text-on-surface-muted dark:text-on-surface-dark-muted text-sm mb-1">
                            {{ __('LemonSqueezy Invoice ID') }}</p>
                        <p class="text-on-surface dark:text-on-surface-dark font-mono text-sm">
                            {{ $invoice->lemon_squeezy_id ?: __('N/A') }}
                        </p>
                    </div>

                    @if ($invoice->subscription_id)
                        <div>
                            <p class="text-on-surface-muted dark:text-on-surface-dark-muted text-sm mb-1">
                                {{ __('Subscription ID') }}</p>
                            <p class="text-on-surface dark:text-on-surface-dark font-mono text-sm">
                                {{ $invoice->subscription_id }}
                            </p>
                        </div>
                    @endif

                    @if ($invoice->customer_id)
                        <div>
                            <p class="text-on-surface-muted dark:text-on-surface-dark-muted text-sm mb-1">
                                {{ __('Customer ID') }}</p>
                            <p class="text-on-surface dark:text-on-surface-dark font-mono text-sm">
                                {{ $invoice->customer_id }}
                            </p>
                        </div>
                    @endif

                    @if ($invoice->invoice_url)
                        <div>
                            <p class="text-on-surface-muted dark:text-on-surface-dark-muted text-sm">
                                {{ __('Invoice') }}</p>
                            <p class="text-on-surface dark:text-on-surface-dark">
                                <a href="{{ $invoice->invoice_url }}" target="_blank" class="link">
                                    {{ __('View Invoice') }}
                                </a>
                            </p>
                        </div>
                    @endif

                    @if ($invoice->refunded)
                        <div>
                            <p class="text-on-surface-muted dark:text-on-surface-dark-muted text-sm mb-1">
                                {{ __('Refunded') }}</p>
                            <p class="text-on-surface dark:text-on-surface-dark">
                                @if ($invoice->refunded_at)
                                    @php
                                        $refundDate = $invoice->refunded_at;
                                        $refundTimestamp = $refundDate->timestamp;
                                        $refundDateUtc = \Carbon\Carbon::createFromTimestamp($refundTimestamp, 'UTC');
                                        $refundGmtDate = $refundDateUtc->copy();
                                        $refundUserDate = $refundDateUtc->copy()->setTimezone($userTimezone);
                                    @endphp
                                    <div class="space-y-1">
                                        <p class="flex flex-col text-on-surface dark:text-on-surface-dark">
                                            <span class="text-on-surface-muted dark:text-on-surface-dark-muted text-xs">GMT</span>
                                            <span class="text-sm font-mono">{{ $refundGmtDate->format('M d, Y H:i:s') }}</span>
                                        </p>
                                        <p class="flex flex-col text-on-surface dark:text-on-surface-dark">
                                            <span
                                                class="text-on-surface-muted dark:text-on-surface-dark-muted text-xs">{{ $userTimezone }}</span>
                                            <span class="text-sm font-mono">{{ $refundUserDate->format('M d, Y H:i:s') }}</span>
                                        </p>
                                    </div>
                                @else
                                    {{ __('Yes') }}
                                @endif
                            </p>
                        </div>
                    @endif

                    @if ($invoice->card_brand && $invoice->card_last_four)
                        <div>
                            <p class="text-on-surface-muted dark:text-on-surface-dark-muted text-sm mb-1">
                                {{ __('Payment Method') }}</p>
                            <p class="text-on-surface dark:text-on-surface-dark">
                                {{ ucfirst($invoice->card_brand) }} •••• {{ $invoice->card_last_four }}
                            </p>
                        </div>
                    @endif
                </div>

                <!-- Pricing Breakdown -->
                <div class="mt-6 border-t border-outline dark:border-outline-dark pt-6">
                    <h3 class="font-medium mb-4 text-on-surface-strong dark:text-on-surface-dark-strong">
                        {{ __('Pricing Breakdown') }}
                    </h3>
                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="text-on-surface dark:text-on-surface-dark text-sm">{{ __('Subtotal') }}</span>
                            <span class="text-on-surface dark:text-on-surface-dark font-mono text-sm">
                                {{ Number::currency($invoice->subtotal / 100, $invoice->currency) }}
                            </span>
                        </div>

                        @if ($invoice->discount_total > 0)
                            <div class="flex justify-between items-center">
                                <span
                                    class="text-on-surface dark:text-on-surface-dark text-sm">{{ __('Discount') }}</span>
                                <span class="font-mono text-sm text-danger">
                                    -{{ Number::currency($invoice->discount_total / 100, $invoice->currency) }}
                                </span>
                            </div>
                        @endif

                        @if ($invoice->tax > 0)
                            <div class="flex justify-between items-center">
                                <span class="text-on-surface dark:text-on-surface-dark text-sm">
                                    {{ __('Tax') }}
                                </span>
                                <span class="text-on-surface dark:text-on-surface-dark font-mono text-sm">
                                    {{ Number::currency($invoice->tax / 100, $invoice->currency) }}
                                </span>
                            </div>
                        @endif

                        <div
                            class="flex justify-between items-center border-t border-outline dark:border-outline-dark pt-2 mt-2">
                            <span
                                class="font-medium text-on-surface-strong dark:text-on-surface-dark-strong">{{ __('Total') }}</span>
                            <span
                                class="font-semibold text-on-surface-strong dark:text-on-surface-dark-strong font-mono">
                                {{ Number::currency($invoice->total / 100, $invoice->currency) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Information -->
        <div class="w-full md:max-w-xs">
            <div class="panel">
                <h2 class="font-medium mb-4 text-lg text-on-surface-strong dark:text-on-surface-dark-strong">
                    {{ __('Customer Information') }}
                </h2>

                @if ($invoice->billable)
                    <x-profile-summary :user="$invoice->billable" />
                @else
                    <p class="text-on-surface-muted dark:text-on-surface-dark-muted text-sm">
                        {{ __('No customer information available.') }}
                    </p>
                @endif
            </div>

            @if ($invoice->subscription)
                <div class="panel mt-4">
                    <h2 class="font-medium mb-4 text-lg text-on-surface-strong dark:text-on-surface-dark-strong">
                        {{ __('Subscription') }}
                    </h2>
                    <div class="space-y-2">
                        @if ($plan)
                            <div>
                                <p class="text-on-surface-muted dark:text-on-surface-dark-muted text-sm mb-1">
                                    {{ __('Plan') }}
                                </p>
                                <p class="text-on-surface dark:text-on-surface-dark font-medium">
                                    {{ $plan->name }}
                                </p>
                                @if ($plan->billing_period)
                                    <p class="text-on-surface-muted dark:text-on-surface-dark-muted text-xs mt-1">
                                        {{ __(ucfirst($plan->billing_period)) }}
                                    </p>
                                @endif
                            </div>
                        @endif
                        <div>
                            <p class="text-on-surface-muted dark:text-on-surface-dark-muted text-sm mb-1">
                                {{ __('Status') }}
                            </p>
                            <p class="text-on-surface dark:text-on-surface-dark">
                                <x-badge :variant="match($invoice->subscription->status) {
                                    'active' => 'outline-success',
                                    'past_due' => 'outline-warning',
                                    'canceled' => 'outline-danger',
                                    default => 'outline-secondary',
                                }">
                                    {{ __(ucfirst($invoice->subscription->status)) }}
                                </x-badge>
                            </p>
                        </div>
                       
                    </div>
                </div>
            @endif
        </div>
    </div>

</x-layouts.admin>

