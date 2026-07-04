<x-mail::message>
# {{ __('New Order Payment Received') }}

{{ __('A new order payment has been successfully processed.') }}

<x-mail::panel>
## {{ __('Order Information') }}

**{{ __('Order ID') }}:** #{{ $order->id }}

@if($order->user)
**{{ __('Customer') }}:** {{ $order->user->name }} ({{ $order->user->email }})
@endif

@if($order->product)
**{{ __('Product') }}:** {{ $order->product->name }}
@endif

**{{ __('Total Amount') }}:** {{ number_format($order->total / 100, 2) }} {{ strtoupper($order->currency ?? 'USD') }}

@if($order->invoice_number)
**{{ __('Invoice Number') }}:** {{ $order->invoice_number }}
@endif

@if($order->lemon_squeezy_id)
**{{ __('Lemon Squeezy Order ID') }}:** {{ $order->lemon_squeezy_id }}
@endif

**{{ __('Payment Date') }}:** {{ $order->paid_at?->format('F j, Y \a\t g:i A') }}
</x-mail::panel>

<x-mail::button :url="route('admin.orders.show', ['order' => $order->id], absolute: true)" color="primary">
{{ __('View Order in Admin Panel') }}
</x-mail::button>

{{ __('This is an automated notification from') }} {{ config('app.name') }}.
</x-mail::message>

