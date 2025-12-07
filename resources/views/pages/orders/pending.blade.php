@push('head')
    <title>{{ __('Payment Processing...') }}</title>
@endpush
<x-layouts.app :sidebar="false">

    <!-- Header Section -->
    <div class="flex flex-col items-center justify-center gap-6 min-h-[50svh]">
        <x-icons.spinner class="size-12 fill-on-surface motion-safe:animate-spin dark:fill-on-surface-dark" />
        <h1 class="heading-2 text-balance text-center md:w-1/2">
            {{ __('Processing your payment...') }}
        </h1>

        <p class="text-sm text-on-surface-muted dark:text-on-surface-dark-muted text-center w-full sm:w-1/2 md:w-1/3">
            {{ __('This usually takes a few seconds. You\'ll be redirected once your payment is confirmed.') }}
        </p>
    </div>

    <script>
        // Poll the server every few seconds to check if the payment is completed
        const orderId = '{{ $order->id }}';
        setInterval(async () => {
            const response = await fetch(`/orders/status/${orderId}`);
            const data = await response.json();

            if (data.status === 'paid') {
                window.location.href = `/orders`;
            }
        }, 3000);
    </script>
</x-layouts.app>
