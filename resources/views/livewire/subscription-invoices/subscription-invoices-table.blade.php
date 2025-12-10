<div>
    @if ($searchable)
        <!-- Search Input -->
        <div class="mb-4">
            <x-input wire:model.live="search" class="w-full md:max-w-xs" variant="search" :placeholder="__('Search invoices...')"
                :aria-label="__('Search invoices')" />
        </div>
    @endif

    @if ($invoices->isNotEmpty())
        <x-table>
            <x-slot:head>
                <th scope="col" class="p-4">{{ __('Invoice #') }}</th>
                <th scope="col" class="p-4">{{ __('Date') }}</th>
                <th scope="col" class="p-4">{{ __('Billing Reason') }}</th>
                <th scope="col" class="p-4">{{ __('Status') }}</th>
                <th scope="col" class="p-4">{{ __('Total') }}</th>
                <th scope="col" class="p-4">{{ __('Discount') }}</th>
                <th scope="col" class="p-4">{{ __('Invoice') }}</th>
            </x-slot:head>

            <x-slot:body>
                @foreach ($invoices as $invoice)
                    <tr wire:key="invoice-{{ $invoice->id }}">
                        <td class="p-4">
                            <div class="flex items-center gap-2">
                                {{ $invoice->lemon_squeezy_id }}
                            </div>
                        </td>
                        <td class="p-4">
                            @php
                                $date = $invoice->invoiced_at ?? $invoice->created_at;
                                $userTimezone = auth()->user()?->timezone ?? 'America/New_York';
                                $localDate = $date->copy()->setTimezone($userTimezone);
                                $gmtDate = $date->copy()->setTimezone('UTC');
                            @endphp
                            <div class="whitespace-nowrap font-mono">
                                <div class="text-xs ">{{ $localDate->format('M d, Y H:i') }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    {{ $gmtDate->format('M d, Y H:i') }} UTC
                                </div>
                            </div>
                        </td>
                        <td class="p-4">
                            <x-badge>{{ __(ucfirst($invoice->billing_reason)) }}</x-badge>
                        </td>
                        <td class="p-4 capitalize">
                            @php
                                $statusVariant = match ($invoice->status) {
                                    'paid' => 'outline-success',
                                    'pending' => 'outline-info',
                                    'void' => 'outline-warning',
                                    'refunded', 'partial_refund' => 'outline-danger',
                                    default => 'outline-info',
                                };
                            @endphp
                            <x-badge
                                variant="{{ $statusVariant }}">{{ __(ucfirst(str_replace('_', ' ', $invoice->status))) }}</x-badge>
                        </td>

                        <td class="p-4">{{ Number::currency($invoice->total / 100, $invoice->currency) }}</td>
                        <td class="p-4">{{ Number::currency($invoice->discount_total / 100, $invoice->currency) }}
                        </td>
                        <td class="p-4">
                            @if ($invoice->invoice_url)
                                <a href="{{ $invoice->invoice_url }}" target="_blank"
                                    class="whitespace-nowrap rounded-radius bg-transparent p-0.5 font-semibold text-primary outline-primary hover:opacity-75 focus-visible:outline-2 focus-visible:outline-offset-2 active:opacity-100 active:outline-offset-0 dark:text-primary-dark dark:outline-primary-dark">
                                    {{ __('View Invoice') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </x-slot:body>
        </x-table>

        <div class="mt-4">
            {{ $invoices->links() }}
        </div>
    @else
        <x-blocks.empty-state icon="document-currency-dollar" class="h-[50svh]" :title="__('No invoices')"
            :description="__('We couldn\'t find any subscription invoices.')">
      
        </x-blocks.empty-state>
    @endif
</div>
