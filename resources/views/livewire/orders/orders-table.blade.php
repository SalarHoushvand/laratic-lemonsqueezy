<div>
    @if ($searchable)
        <!-- Search Input -->
        <div class="mb-4">
            <x-input wire:model.live="search" class="w-full md:max-w-xs" variant="search"
                :placeholder="__('Search orders...')" :aria-label="__('Search orders')" />
        </div>
    @endif

    @if ($orders->isNotEmpty())
        <x-table>
            <x-slot:head>
                <th scope="col" class="p-4">{{ __('Order #') }}</th>
                <th scope="col" class="p-4">{{ __('Date') }}</th>
                <th scope="col" class="p-4">{{ __('Status') }}</th>
                <th scope="col" class="p-4">{{ __('Total') }}</th>
                <th scope="col" class="p-4">{{ __('Discount') }}</th>
                <th scope="col" class="p-4">{{ __('Receipt') }}</th>
            </x-slot:head>

            <x-slot:body>
                @foreach ($orders as $order)
                    <tr wire:key="order-{{ $order->id }}">
                        <td class="p-4">
                            <div class="flex items-center gap-2">
                                {{ $order->order_number }}
                            </div>
                        </td>
                        <td class="p-4">{{ $order->created_at->toFormattedDateString() }}</td>
                        <td class="p-4 capitalize">
                           <x-badge variant="outline-{{ $order->status === 'paid' ? 'success' : 'info' }}">{{ __($order->status) }}</x-badge>
                        </td>

                        <td class="p-4">{{ Number::currency($order->total / 100, $order->currency) }}</td>
                        <td class="p-4">{{ Number::currency($order->discount_total / 100, $order->currency) }}</td>
                        <td class="p-4">
                            @if ($order->receipt_url)
                                <a href="{{ $order->receipt_url }}"
                                    target="_blank"
                                    class="whitespace-nowrap rounded-radius bg-transparent p-0.5 font-semibold text-primary outline-primary hover:opacity-75 focus-visible:outline-2 focus-visible:outline-offset-2 active:opacity-100 active:outline-offset-0 dark:text-primary-dark dark:outline-primary-dark">
                                    {{ __('View Receipt') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </x-slot:body>
        </x-table>

        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    @else
        <x-blocks.empty-state icon="shopping-cart" class="h-[50svh]" title="{{ __('No orders') }}"
            description="{{ __('We couldn’t find any orders.') }}">
            <x-button class="mt-2" variant="outline" size="xs" href="{{ route('products.index') }}" :aria-label="__('Browse Products')">
                {{ __('View Products') }}
            </x-button>
        </x-blocks.empty-state>
    @endif
</div>
