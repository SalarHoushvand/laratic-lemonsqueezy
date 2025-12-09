<div>
    @if ($searchable)
        <!-- Search Input -->
        <div class="mb-4">
            <x-input wire:model.live="search" class="w-full md:max-w-xs" variant="search"
                :placeholder="__('Search AI usage...')" :aria-label="__('Search AI usage')" />
        </div>
    @endif

    @if ($aiUsages->isNotEmpty())
        <x-table>
            <x-slot:head>
                <th scope="col" class="p-4">{{ __('User') }}</th>
                <th scope="col" class="p-4">{{ __('Model') }}</th>
                <th scope="col" class="p-4">{{ __('Total Tokens') }}</th>
                <th scope="col" class="p-4">{{ __('Total Cost') }}</th>
                <th scope="col" class="p-4">{{ __('Date & Time') }}</th>
            </x-slot:head>

            <x-slot:body>
                @foreach ($aiUsages as $aiUsage)
                    <tr wire:key="ai-usage-{{ $aiUsage->id }}">
                        <td class="p-4">
                           <x-profile-summary :user="$aiUsage->user" />
                        </td>
                        <td class="p-4">
                            <x-badge>{{ $aiUsage->model }}</x-badge>
                        </td>
                        <td class="p-4 font-mono">
                            {{ number_format($aiUsage->total_tokens) }}
                        </td>
                        <td class="p-4 font-mono">
                            {{ number_format($aiUsage->total_cost, 5) }} {{ strtoupper($aiUsage->currency) }}
                        </td>
                        <td class="p-4 font-mono">
                            @php
                                $date = $aiUsage->created_at;
                                $userTimezone = auth()->user()?->timezone ?? 'America/New_York';
                                $localDate = $date->copy()->setTimezone($userTimezone);
                                $gmtDate = $date->copy()->setTimezone('UTC');
                            @endphp
                            <div class="whitespace-nowrap">
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
            {{ $aiUsages->links() }}
        </div>
    @else
        <x-blocks.empty-state icon="robot" class="h-[50svh]" title="{{ __('No AI usage') }}"
            description="{{ __('We couldn’t find any AI usage.') }}" />
    @endif
</div>

