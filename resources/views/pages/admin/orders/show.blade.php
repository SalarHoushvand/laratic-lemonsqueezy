@push('head')
    <title>{{ __('Order :invoice', ['invoice' => $order->invoice_number]) }} - {{ config('app.name') }}</title>
@endpush

<x-layouts.admin>
    <div class="flex flex-col gap-4 items-center justify-between md:flex-row">
        <h1 class="heading-4 text-on-surface dark:text-on-surface-dark">
            {{ __('Order') }} #{{ $order->invoice_number }}
        </h1>

        <livewire:admin.orders.order-status-selector :order="$order" />
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
                            {{ $order->created_at->setTimezone(auth()->user()?->timezone ?? 'America/New_York')->format('M d, Y') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-on-surface-muted dark:text-on-surface-dark-muted text-sm">{{ __('Payment Status') }}</p>
                        <p class="text-on-surface dark:text-on-surface-dark">
                            @if ($order->paid_at)
                                {{ __('Paid on :date', ['date' => $order->paid_at->setTimezone(auth()->user()?->timezone ?? 'America/New_York')->format('M d, Y H:i:s')]) }}
                            @else
                                {{ __('Pending Payment') }}
                            @endif
                        </p>
                    </div>

                    <div>
                        <p class="text-on-surface-muted dark:text-on-surface-dark-muted text-sm">{{ __('Total Amount') }}</p>
                        <p class="text-on-surface dark:text-on-surface-dark font-mono">
                            {{ Number::currency($order->total / 100, $order->currency) }}
                        </p>
                    </div>

                    <div>
                        <p class="text-on-surface-muted dark:text-on-surface-dark-muted text-sm">{{ __('Paddle ID') }}</p>
                        <p class="text-on-surface dark:text-on-surface-dark">
                            {{ $order->paddle_id ?: __('N/A') }}
                        </p>
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

                <x-profile-summary :user="$order->user" />

                <div class="border-outline dark:border-outline-dark border-t mt-4 pt-4">
                    <h3 class="font-medium mb-2 text-on-surface-strong dark:text-on-surface-dark-strong">
                        {{ __('Shipping Address') }}
                    </h3>
                    @if ($order->shipping_address)
                        <p class="text-on-surface dark:text-on-surface-dark text-sm">
                            {{ $order->shipping_address }}<br>
                            {{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_zip }}<br>
                            {{ $order->shipping_country }}
                        </p>
                    @else
                        <p class="text-on-surface-muted dark:text-on-surface-dark-muted text-sm">
                            {{ __('No shipping address provided.') }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Items Section -->
    <div class="mt-8 w-full">
        <h2 class="heading-4 mb-4 text-on-surface dark:text-on-surface-dark">
            {{ __('Item') }}
        </h2>

        @if ($order->product)
            <x-blocks.admin.orders.item :order="$order" />
        @else
            <p class="text-on-surface-muted dark:text-on-surface-dark-muted text-sm">
                {{ __('No items found for this order.') }}
            </p>
        @endif
    </div>

    <!-- Transactions Section -->
    <div class="mt-12 w-full">
        <h2 class="heading-4 mb-4 text-on-surface dark:text-on-surface-dark">
            {{ __('Transactions') }}
        </h2>

        @if ($transactions->isNotEmpty())
            <x-blocks.admin.orders.transactions :transactions="$transactions" />
        @else
            <p class="text-on-surface-muted dark:text-on-surface-dark-muted text-sm">
                {{ __('No transactions found for this order.') }}
            </p>
        @endif
    </div>
</x-layouts.admin>
