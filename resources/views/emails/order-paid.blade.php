<x-mail::message>
# {{ __('Order Payment Confirmed') }}

{{ __('Hi :name,', ['name' => $user->name]) }}

{{ __('Thank you for your purchase! Your payment for Order #:order_id has been successfully processed.', ['order_id' => $order->id]) }}

<x-mail::panel>
## {{ __('Order Details') }}

**{{ __('Order ID') }}:** #{{ $order->id }}

@if($order->product)
**{{ __('Product') }}:** {{ $order->product->name }}
@endif

**{{ __('Total Amount') }}:** {{ number_format($order->total / 100, 2) }} {{ strtoupper($order->currency ?? 'USD') }}

@if($order->invoice_number)
**{{ __('Invoice Number') }}:** {{ $order->invoice_number }}
@endif

**{{ __('Payment Date') }}:** {{ $order->paid_at?->format('F j, Y \a\t g:i A') }}
</x-mail::panel>

<x-mail::button :url="route('orders.index', absolute: true)" color="primary">
{{ __('View Order Details') }}
</x-mail::button>

{{ __('If you have any questions about your order, please don\'t hesitate to contact our support team.') }}

{{ __('Thank you for your business!') }},<br>
{{ config('app.name') }} {{ __('Team') }}
</x-mail::message>

