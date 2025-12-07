<div>
    @if ($user->transactions->isNotEmpty())
        <x-table class="max-h-72 overflow-y-auto" headClass="sticky top-0">
            <x-slot:head>
                <th scope="col" class="p-4">{{ __('Date') }}</th>
                <th scope="col" class="p-4">{{ __('Type') }}</th>
                <th scope="col" class="p-4">{{ __('Amount') }}</th>
                <th scope="col" class="p-4">{{ __('Tax') }}</th>
                <th scope="col" class="p-4">{{ __('Invoice') }}</th>
            </x-slot:head>

            <x-slot:body>
                @foreach ($user->transactions as $transaction)
                    <tr>
                        <td class="p-4">{{ $transaction->billed_at->toFormattedDateString() }}</td>
                        <td class="p-4">
                            {{ $transaction->paddle_subscription_id ? __('Subscription') : __('Order') }}
                        </td>
                        <td class="p-4 font-mono">{{ $transaction->total() }}</td>
                        <td class="p-4 font-mono">{{ $transaction->tax() }}</td>
                        <td class="p-4">
                            @if ($transaction->invoice_number)
                                <a href="{{ route('transactions.download-invoice', $transaction->id) }}" target="_blank"
                                    class="whitespace-nowrap rounded-radius bg-transparent p-0.5 font-semibold text-primary outline-primary hover:opacity-75 focus-visible:outline-2 focus-visible:outline-offset-2 active:opacity-100 active:outline-offset-0 dark:text-primary-dark dark:outline-primary-dark">
                                    {{ __('Download') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </x-slot:body>
        </x-table>
    @else
        <x-blocks.empty-state icon="banknotes" class="mt-6 items-start" title="{{ __('No transactions') }}"
            description="{{ __('We couldn’t find any transactions') }}" />
    @endif
</div>
