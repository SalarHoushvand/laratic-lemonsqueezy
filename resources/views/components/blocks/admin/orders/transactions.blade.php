<!-- Order transactions table component -->
<x-table>
    <x-slot:head>
        <th scope="col" class="p-4">{{ __('Date') }}</th>
        <th scope="col" class="p-4">{{ __('Type') }}</th>
        <th scope="col" class="p-4">{{ __('Amount') }}</th>
        <th scope="col" class="p-4">{{ __('Tax') }}</th>
        <th scope="col" class="p-4">{{ __('Invoice') }}</th>
    </x-slot:head>

    <x-slot:body>
        @foreach ($transactions as $transaction)
            <tr>
                <td class="p-4">{{ $transaction->billed_at->toFormattedDateString() }}</td>
                <td class="p-4">
                    {{ $transaction->paddle_subscription_id ? __('Subscription') : __('Order') }}
                </td>
                <td class="p-4 font-mono">{{ $transaction->total() }}</td>
                <td class="p-4 font-mono">{{ $transaction->tax() }}</td>
                <td class="p-4">
                    @if ($transaction->invoice_number)
                        <a 
                            class="whitespace-nowrap rounded-radius bg-transparent font-semibold outline-primary p-0.5 text-primary hover:opacity-75 focus-visible:outline-2 focus-visible:outline-offset-2 active:opacity-100 active:outline-offset-0 dark:text-primary-dark dark:outline-primary-dark"
                            href="{{ route('transactions.download-invoice', $transaction->id) }}"
                            target="_blank"
                        >
                            {{ __('Download') }}
                        </a>
                    @endif
                </td>
            </tr>
        @endforeach
    </x-slot:body>
</x-table>
