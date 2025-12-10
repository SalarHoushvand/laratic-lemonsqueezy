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
                <th scope="col">{{ __('User') }}</th>
                <th scope="col" class="text-center">{{ __('Invoice #') }}</th>
                <th scope="col" class="text-center">{{ __('Status') }}</th>
                <th scope="col" class="text-center">{{ __('Billing Reason') }}</th>
                <th scope="col" class="text-center">{{ __('Total') }}</th>
                <th scope="col" class="text-center">{{ __('Date') }}</th>
            </x-slot:head>

            <x-slot:body>
                @foreach ($invoices as $invoice)
                    <tr wire:key="invoice-{{ $invoice->id }}" 
                        onclick="window.location.href='{{ route('admin.subscription-invoices.show', $invoice) }}'"
                        class="cursor-pointer hover:bg-surface-dark/5 dark:hover:bg-surface/5 transition-colors">
                        <td class="p-4">
                            @if ($invoice->billable)
                                <x-profile-summary :user="$invoice->billable" :isLink="false" :hasAvatar="false" />
                            @else
                                {{ __('N/A') }}
                            @endif
                        </td>
                        <td class="p-4 text-center font-mono">
                            {{ $invoice->lemon_squeezy_id ?? __('N/A') }}
                        </td>

                        <td class="text-center p-4">
                            <x-badge :variant="match($invoice->status) {
                                'paid' => 'outline-success',
                                'pending' => 'outline-warning',
                                'refunded' => 'outline-danger',
                                'void' => 'outline-secondary',
                                default => 'outline-secondary',
                            }">
                                {{ __(ucfirst($invoice->status)) }}
                            </x-badge>
                        </td>
                        <td class="text-center p-4">
                            <x-badge>{{ __(ucfirst($invoice->billing_reason)) }}</x-badge>
                        </td>
                        <td class="text-center p-4 font-mono">
                            {{ Number::currency($invoice->total / 100, $invoice->currency) }}
                        </td>
                        <td class="text-center p-4">
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
                    </tr>
                @endforeach
            </x-slot:body>
        </x-table>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $invoices->links() }}
        </div>
    @else
        <x-blocks.empty-state icon="document-currency-dollar" class="h-[50svh]" title="{{ __('No invoices') }}"
            description="{{ __('We could not find any subscription invoices.') }}" />
    @endif

</div>

