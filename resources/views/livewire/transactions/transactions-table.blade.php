<div>
    @if ($transactions->isNotEmpty())
        <x-table>
            <x-slot:head>
                <th scope="col">{{ __('Date') }}</th>
                <th scope="col" class="text-center">{{ __('Type') }}</th>
                <th scope="col" class="text-center">{{ __('Amount') }}</th>
                <th scope="col" class="text-center">{{ __('Tax') }}</th>
                <th scope="col" class="text-center">{{ __('Invoice') }}</th>
            </x-slot:head>

            <x-slot:body>
                @foreach ($transactions as $transaction)
                    <tr wire:key="transaction-{{ $transaction->id }}">
                        <td class="p-4">{{ $transaction->billed_at->toFormattedDateString() }}</td>
                        <td class="text-center">
                            @if ($transaction->paddle_subscription_id)
                                <x-badge>{{ __('Subscription') }}</x-badge>
                            @else
                                <x-badge>{{ __('Order') }}</x-badge>
                            @endif
                        </td>

                        <td class="text-center">{{ $transaction->total() }}</td>
                        <td class="text-center">{{ $transaction->tax() }}</td>
                        <td class="text-center">
                            @if ($transaction->invoice_number)
                                <a href="{{ route('transactions.download-invoice', $transaction->id) }}"
                                    target="_blank"
                                    class="whitespace-nowrap rounded-radius bg-transparent p-0.5 font-semibold text-primary outline-primary hover:opacity-75 focus-visible:outline-2 focus-visible:outline-offset-2 active:opacity-100 active:outline-offset-0 dark:text-primary-dark dark:outline-primary-dark">
                                    {{ __('Download') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </x-slot:body>
        </x-table>

        <div class="mt-4">
            {{ $transactions->links() }}
        </div>
    @else
        <x-blocks.empty-state icon="banknotes" class="h-[50svh]" title="{{ __('No transactions') }}"
            description="{{ __('You haven’t made any transactions yet.') }}" />
    @endif
</div>
