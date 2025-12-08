@push('head')
    <title>{{ __('Order :order', ['order' => $order->order_number]) }} - {{ config('app.name') }}</title>
@endpush

<x-layouts.admin>
    <div class="flex flex-col gap-4 items-center justify-between md:flex-row">
        <h1 class="heading-4 text-on-surface dark:text-on-surface-dark">
            {{ __('Order') }} #{{ $order->order_number }}
        </h1>
    </div>

    <!-- Order Details -->
    <div class="flex flex-col gap-8 md:flex-row mt-8">
        <!-- Order Information -->
        <div class="w-full">
            <div class="panel h-full">
                <h2 class="font-medium mb-4 text-lg text-on-surface-strong dark:text-on-surface-dark-strong">
                    {{ __('Order Information') }}
                </h2>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <p class="text-on-surface-muted dark:text-on-surface-dark-muted text-sm">{{ __('Order Date') }}</p>
                        <p class="text-on-surface dark:text-on-surface-dark">
                            {{ $order->ordered_at?->setTimezone(auth()->user()?->timezone ?? 'America/New_York')->format('M d, Y H:i:s') ?? $order->created_at->setTimezone(auth()->user()?->timezone ?? 'America/New_York')->format('M d, Y H:i:s') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-on-surface-muted dark:text-on-surface-dark-muted text-sm">{{ __('Payment Status') }}</p>
                        <p class="text-on-surface dark:text-on-surface-dark">
                            <x-blocks.admin.orders.status-badge :order="$order" />
                        </p>
                    </div>

                    @if ($order->product_type)
                        <div>
                            <p class="text-on-surface-muted dark:text-on-surface-dark-muted text-sm">{{ __('Type') }}</p>
                            <p class="text-on-surface dark:text-on-surface-dark">
                               {{ __(ucfirst($order->product_type)) }}
                            </p>
                        </div>
                    @endif

                    <div>
                        <p class="text-on-surface-muted dark:text-on-surface-dark-muted text-sm">{{ __('LemonSqueezy Order ID') }}</p>
                        <p class="text-on-surface dark:text-on-surface-dark font-mono text-sm">
                            {{ $order->lemon_squeezy_id ?: __('N/A') }}
                        </p>
                    </div>

                    @if ($order->product_id)
                        <div>
                            <p class="text-on-surface-muted dark:text-on-surface-dark-muted text-sm">{{ __('LemonSqueezy Product ID') }}</p>
                            <p class="text-on-surface dark:text-on-surface-dark font-mono text-sm">
                                {{ $order->product_id }}
                            </p>
                        </div>
                    @endif

                    @if ($order->variant_id)
                        <div>
                            <p class="text-on-surface-muted dark:text-on-surface-dark-muted text-sm">{{ __('LemonSqueezy Variant ID') }}</p>
                            <p class="text-on-surface dark:text-on-surface-dark font-mono text-sm">
                                {{ $order->variant_id }}
                            </p>
                        </div>
                    @endif

                    @if ($order->receipt_url)
                        <div>
                            <p class="text-on-surface-muted dark:text-on-surface-dark-muted text-sm">{{ __('Receipt') }}</p>
                            <p class="text-on-surface dark:text-on-surface-dark">
                                <a href="{{ $order->receipt_url }}" target="_blank" class="link">
                                    {{ __('View Receipt') }}
                                </a>
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
                                {{ Number::currency($order->subtotal / 100, $order->currency) }}
                            </span>
                        </div>

                        @if ($order->discount_total > 0)
                            <div class="flex justify-between items-center">
                                <span class="text-on-surface dark:text-on-surface-dark text-sm">{{ __('Discount') }}</span>
                                <span class="font-mono text-sm text-danger">
                                    -{{ Number::currency($order->discount_total / 100, $order->currency) }}
                                </span>
                            </div>
                        @endif

                        @if ($order->tax > 0)
                            <div class="flex justify-between items-center">
                                <span class="text-on-surface dark:text-on-surface-dark text-sm">
                                    {{ __('Tax') }}
                                    @if ($order->tax_name)
                                        <span class="text-on-surface-muted dark:text-on-surface-dark-muted">({{ $order->tax_name }})</span>
                                    @endif
                                </span>
                                <span class="text-on-surface dark:text-on-surface-dark font-mono text-sm">
                                    {{ Number::currency($order->tax / 100, $order->currency) }}
                                </span>
                            </div>
                        @endif

                        <div class="flex justify-between items-center border-t border-outline dark:border-outline-dark pt-2 mt-2">
                            <span class="font-medium text-on-surface-strong dark:text-on-surface-dark-strong">{{ __('Total') }}</span>
                            <span class="font-semibold text-on-surface-strong dark:text-on-surface-dark-strong font-mono">
                                {{ Number::currency($order->total / 100, $order->currency) }}
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

                @if ($order->billable)
                    <x-profile-summary :user="$order->billable" />
                @else
                    <p class="text-on-surface-muted dark:text-on-surface-dark-muted text-sm">
                        {{ __('No customer information available.') }}
                    </p>
                @endif
            </div>
        </div>
    </div>

    <!-- Items Section -->
    <div class="mt-8 w-full">
        <h2 class="heading-4 mb-4 text-on-surface dark:text-on-surface-dark">
            {{ __('Item') }}
        </h2>

        @if ($item)
            <x-blocks.admin.orders.item :order="$order" :item="$item" />
        @else
            <p class="text-on-surface-muted dark:text-on-surface-dark-muted text-sm">
                {{ __('No items found for this order.') }}
            </p>
        @endif
    </div>

</x-layouts.admin>
