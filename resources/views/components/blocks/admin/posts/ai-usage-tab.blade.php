@props(['livewire'])

@if ($livewire->post)
    <div
        x-show="tab === 'ai-usage'"
        x-cloak
        id="tabpanel-ai-usage"
        class="space-y-6"
        role="tabpanel"
        aria-label="ai-usage"
    >
        <div class="space-y-4">
            <div>
                <x-input-label :value="__('AI Usage History')" />
                <div class="mt-3 space-y-3">
                    @if ($livewire->aiUsages->count() > 0)
                        @foreach ($livewire->aiUsages as $usage)
                            <div
                                class="rounded-radius border border-outline dark:border-outline-dark p-4 bg-surface-alt dark:bg-surface-dark-alt"
                            >
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <div class="font-medium text-on-surface dark:text-on-surface-dark">
                                            {{ $usage->model }}
                                        </div>
                                        <div class="text-xs text-on-surface/60 dark:text-on-surface-dark/60 mt-1">
                                            {{ $usage->created_at->format('M d, Y H:i') }}
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="font-medium text-on-surface dark:text-on-surface-dark">
                                            {{ number_format($usage->total_cost, 4) }}
                                            {{ $usage->currency }}
                                        </div>
                                        <div class="text-sm text-on-surface/70 dark:text-on-surface-dark/70">
                                            {{ number_format($usage->total_tokens) }}
                                            {{ __('tokens') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-sm text-on-surface/70 dark:text-on-surface-dark/70">
                            {{ __('No AI usage recorded for this post.') }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endif
