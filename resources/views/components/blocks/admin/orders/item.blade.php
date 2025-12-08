<x-table>
    <x-slot:head>
        <th scope="col" class="p-4">{{ __('Name') }}</th>
        <th scope="col" class="p-4">{{ __('Variant ID') }}</th>
        <th scope="col" class="p-4">{{ __('Amount') }}</th>
    </x-slot:head>

    <x-slot:body>
        <tr>
            <td class="p-4">
                <div class="flex items-center gap-2">
                    @if ($item && isset($item->img_url) && $item->img_url)
                        <img 
                            alt="{{ __('Image of :item', ['item' => $item->name]) }}"
                            class="rounded-radius size-10" 
                            src="{{ $item->img_url }}"
                        >
                    @endif
                    {{ $item?->name ?? __('N/A') }}
                </div>
            </td>
            <td class="p-4 font-mono">{{ $order->variant_id ?: __('N/A') }}</td>
            <td class="p-4 font-mono">
                {{ Number::currency($order->total / 100, $order->currency) }}
            </td>
        </tr>
    </x-slot:body>
</x-table>