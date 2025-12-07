<x-table>
    <x-slot:head>
        <th scope="col" class="p-4">{{ __('Name') }}</th>
        <th scope="col" class="p-4">{{ __('Paddle ID') }}</th>
        <th scope="col" class="p-4">{{ __('Amount') }}</th>
    </x-slot:head>

    <x-slot:body>
        <tr>
            <td class="p-4">
                <div class="flex items-center gap-2">
                    @if ($order->product->img_url)
                        <img 
                            alt="{{ __('Image of :product', ['product' => $order->product->name]) }}"
                            class="rounded-radius size-10" 
                            src="{{ $order->product->img_url }}"
                        >
                    @endif
                    {{ $order->product->name }}
                </div>
            </td>
            <td class="p-4">{{ $order->product->paddle_id }}</td>
            <td class="p-4 font-mono">
                {{ Number::currency($order->product->price / 100, $order->product->currency) }}
            </td>
        </tr>
    </x-slot:body>
</x-table>