<div>
    @if ($user->orders->isNotEmpty())
    <x-table class="max-h-72 overflow-y-auto" headClass="sticky top-0">
        <x-slot:head>
            <th scope="col" class="p-4">{{ __('Date') }}</th>
            <th scope="col" class="p-4">{{ __('Status') }}</th>
            <th scope="col" class="p-4">{{ __('Total') }}</th>
            <th scope="col" class="p-4">{{ __('Receipt') }}</th>
        </x-slot:head>
    
        <x-slot:body>
            @foreach ($user->orders as $order)
                <tr onclick="window.location.href='{{ route('admin.orders.show', $order) }}'"
                    class="cursor-pointer hover:bg-surface-dark/5 dark:hover:bg-surface/5 transition-colors">
                    <td class="p-4">
                        {{ $order->ordered_at?->setTimezone(auth()->user()?->timezone ?? 'America/New_York')->format('M d, Y H:i') ?? $order->created_at->setTimezone(auth()->user()?->timezone ?? 'America/New_York')->format('M d, Y H:i') }}
                    </td>
                    <td class="p-4">
                        <x-blocks.admin.orders.status-badge :order="$order" />
                    </td>
                    <td class="p-4 font-mono">{{ Number::currency($order->total / 100, $order->currency) }}</td>
                    <td class="p-4" onclick="event.stopPropagation()">
                        @if ($order->receipt_url)
                            <a href="{{ $order->receipt_url }}" target="_blank" class="whitespace-nowrap rounded-radius bg-transparent p-0.5 font-semibold text-primary outline-primary hover:opacity-75 focus-visible:outline-2 focus-visible:outline-offset-2 active:opacity-100 active:outline-offset-0 dark:text-primary-dark dark:outline-primary-dark">
                                {{ __('View Receipt') }}
                            </a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </x-slot:body>
    </x-table>
    @else
    <x-blocks.empty-state icon="shopping-cart" class="mt-6 items-start" title="{{ __('No orders') }}"
    description="{{ __('We couldn’t find any orders') }}" />
    @endif
</div>
