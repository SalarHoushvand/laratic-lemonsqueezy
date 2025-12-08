    <div>
        @if ($searchable)
            <!-- Search Input -->
            <div class="mb-4">
                <x-input wire:model.live="search" class="w-full md:max-w-xs" variant="search" :placeholder="__('Search orders...')"
                    :aria-label="__('Search orders')" />
            </div>
        @endif

        @if ($orders->isNotEmpty())
            <x-table>
                <x-slot:head>
                    <th scope="col">{{ __('User') }}</th>
                    <th scope="col" class="text-center">{{ __('Order #') }}</th>
                    <th scope="col" class="text-center">{{ __('Status') }}</th>
                    <th scope="col" class="text-center">{{ __('Type') }}</th>
                    <th scope="col" class="text-center">{{ __('Total') }}</th>
                    <th scope="col" class="text-center">{{ __('Date') }}</th>
                </x-slot:head>

                <x-slot:body>
                    @foreach ($orders as $order)
                        <tr wire:key="order-{{ $order->id }}" 
                            onclick="window.location.href='{{ route('admin.orders.show', $order) }}'"
                            class="cursor-pointer hover:bg-surface-dark/5 dark:hover:bg-surface/5 transition-colors">
                            <td class="p-4">
                                @if ($order->billable)
                                    <x-profile-summary :user="$order->billable" :isLink="false" :hasAvatar="false" />
                                @else
                                    {{ __('N/A') }}
                                @endif
                            </td>
                            <td class="p-4 text-center font-mono">
                                {{ $order->order_number ?? __('N/A') }}
                            </td>

                            <td class="text-center p-4">
                                <x-blocks.admin.orders.status-badge :order="$order" />
                            </td>
                            <td class="text-center p-4">
                                @if ($order->product_type)
                                    <x-badge>{{ __(ucfirst($order->product_type)) }}</x-badge>
                                @else
                                    {{ __('N/A') }}
                                @endif
                            </td>
                            <td class="text-center p-4 font-mono">
                                {{ Number::currency($order->total / 100, $order->currency) }}
                            </td>
                            <td class="text-center p-4 whitespace-nowrap">
                                {{ $order->ordered_at?->setTimezone(auth()->user()?->timezone ?? 'America/New_York')->format('M d, Y H:i') ?? $order->created_at->setTimezone(auth()->user()?->timezone ?? 'America/New_York')->format('M d, Y H:i:s') }}
                            </td>
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
