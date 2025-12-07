    <div>
        @if ($searchable)
            <!-- Search Input -->
            <div class="mb-4">
                <x-input wire:model.live="search" class="w-full md:max-w-xs" variant="search" :placeholder="__('Search orders...')" :aria-label="__('Search orders')" />
            </div>
        @endif

        @if ($orders->isNotEmpty())
            <x-table>
                <x-slot:head>
                    <th scope="col" >{{ __('Invoice') }}</th>
                    <th scope="col" class="text-center">{{ __('User') }}</th>
                    <th scope="col" class="text-center">{{ __('Status') }}</th>
                    <th scope="col" class="text-center">{{ __('Total') }}</th>
                    <th scope="col" class="text-center">{{ __('Date') }}</th>
                </x-slot:head>

            <x-slot:body>
                @foreach ($orders as $order)
                    <tr wire:key="order-{{ $order->id }}">
                            <td class="p-4">
                                <a class="flex items-center gap-2 link w-max"
                                    href="{{ route('admin.orders.show', $order) }}">
                                    {{ $order->invoice_number ? $order->invoice_number : __('N/A') }}
                                </a>
                            </td>
                            <td class="text-center p-4">{{ $order->user->name }}</td>
                            <td class="text-center p-4">
                                <x-blocks.admin.orders.status-badge :order="$order" />
                            </td>
                            <td class="text-center p-4 font-mono">{{ Number::currency($order->total / 100, $order->currency) }}</td>
                            <td class="text-center p-4">{{ $order->created_at->format('M d, Y') }}</td>
                        </tr>
                    @endforeach
                </x-slot:body>
            </x-table>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $orders->links() }}
            </div>
        @else
            <x-blocks.empty-state icon="shopping-cart" class="h-[50svh]" title="{{ __('No orders') }}"
                description="{{ __('We couldn’t find any orders.') }}" />
        @endif

    </div>
