@push('head')
    <title>{{ __('Plans & Products') }}</title>
@endpush

<div class="flex flex-col gap-8">
    <div class="flex flex-col gap-4">
        <x-typography.admin-page-header :title="__('Plans & Products')" :description="__('Manage sort order and featured status for subscription plans and one-time products.')" />

        <div
            class="w-full rounded-radius border border-outline bg-surface-alt p-4 text-sm text-on-surface dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark">
            <div class="flex flex-col gap-3">
                <div class="space-y-1">
                    <h2 class="text-sm font-semibold text-on-surface-strong dark:text-on-surface-dark-strong">
                        {{ __('Sync with Lemon Squeezy') }}
                    </h2>
                    <p class="text-xs text-on-surface-muted dark:text-on-surface-dark-muted">
                        {{ __('Fetch the latest products and subscription plans from Lemon Squeezy and update the local database. ') }}<br>
                        <span class="font-bold text-warning">{{ __('Variants removed in Lemon Squeezy will also be removed here.') }}</span>
                    </p>
                </div>

                <div class="flex flex-col gap-3">
                    <x-button type="button" size="sm" variant="primary" wire:click="syncLemonSqueezyProducts"
                        wire:loading.attr="disabled" wire:target="syncLemonSqueezyProducts">
                        <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 19 24"
                            fill="none" class="w-3">
                            <path fill="#FFC233" fill-rule="evenodd"
                                d="m6.452 14.73 6.453 2.977a3.3 3.3 0 0 1 1.669 1.699c.77 1.8-.283 3.64-1.937 4.302s-3.419.235-4.22-1.636l-2.809-6.57c-.217-.509.33-1.01.844-.772M6.84 12.804l6.66-2.513c2.214-.835 4.632.745 4.6 3.04l-.002.09c-.048 2.236-2.399 3.739-4.564 2.948l-6.688-2.443a.594.594 0 0 1-.007-1.122M6.466 11.934l6.548-2.777c2.176-.922 2.728-3.691 1.024-5.29l-.067-.064C12.3 2.256 9.538 2.801 8.587 4.84l-2.939 6.297c-.234.502.296 1.019.818.798M4.781 10.836l2.38-6.512a3.15 3.15 0 0 0-.064-2.342C6.324.183 4.232-.398 2.577.265.925.93-.01 2.435.794 4.305l2.826 6.562c.22.509.972.489 1.162-.03"
                                clip-rule="evenodd"></path>
                        </svg>

                        <span wire:loading.remove wire:target="syncLemonSqueezyProducts">
                            {{ __('Sync now') }}
                        </span>
                        <span class="inline-flex items-center gap-1" wire:loading
                            wire:target="syncLemonSqueezyProducts">
                            <span>{{ __('Syncing...') }}</span>
                        </span>
                    </x-button>

                    <p class="text-[11px] text-on-surface-muted dark:text-on-surface-dark-muted">
                        {{ __('This may take a few seconds depending on how many products you have.') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- Plans Table -->
    <div class="space-y-4">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="heading-5 text-on-surface-strong dark:text-on-surface-dark-strong">
                    {{ __('Plans') }}
                </h2>
                <p class="text-xs text-on-surface-muted dark:text-on-surface-dark-muted mt-1">
                    {{ __('Drag using the handle to change order. Toggle featured to highlight plans in the app.') }}
                </p>
            </div>
        </div>

        @if ($plans->isNotEmpty())
            <div class="overflow-hidden overflow-x-auto rounded-radius border border-outline dark:border-outline-dark">
                <table class="w-full text-left text-xs sm:text-sm text-on-surface dark:text-on-surface-dark">
                    <thead
                        class="border-b border-outline bg-surface-alt text-xs sm:text-sm text-on-surface-strong dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark-strong [&_th]:p-2 sm:[&_th]:p-4">
                        <tr>
                            <th scope="col" class="w-10"></th>
                            <th scope="col">{{ __('Name') }}</th>
                            <th scope="col" class="hidden md:table-cell">{{ __('Billing') }}</th>
                            <th scope="col" class="hidden md:table-cell">{{ __('Price') }}</th>
                            <th scope="col" class="hidden md:table-cell">{{ __('Trial') }}</th>
                            <th scope="col" class="text-center">{{ __('Featured') }}</th>
                        </tr>
                    </thead>

                    <tbody wire:sort="sortPlan"
                        class="divide-y divide-outline bg-surface dark:divide-outline-dark dark:bg-surface-dark [&_td]:p-2.5 sm:[&_td]:p-4">
                        @foreach ($plans as $plan)
                            <tr wire:sort:item="{{ $plan->id }}" wire:key="plan-{{ $plan->id }}">
                                <td class="p-2 text-center">
                                    <button type="button" wire:sort:handle
                                        class="inline-flex items-center justify-center rounded-radius p-1.5 text-on-surface-muted hover:text-on-surface-strong hover:bg-surface-dark/5 dark:text-on-surface-dark-muted dark:hover:text-on-surface-dark-strong dark:hover:bg-surface/5 cursor-grab active:cursor-grabbing"
                                        aria-label="{{ __('Reorder plan') }}">
                                        <x-icons.bars-3 variant="outline" size="sm" />
                                    </button>
                                </td>
                                <td class="p-4">
                                    <div class="flex flex-col">
                                        <span
                                            class="text-sm font-medium text-on-surface-strong dark:text-on-surface-dark-strong">
                                            {{ $plan->name }}
                                        </span>
                                        <span class="text-xs text-on-surface-muted dark:text-on-surface-dark-muted">
                                            {{ __('Variant ID: :id', ['id' => $plan->lemon_squeezy_variant_id]) }}
                                        </span>
                                    </div>
                                </td>
                                <td class="p-4 hidden md:table-cell">
                                    <span class="text-sm text-on-surface dark:text-on-surface-dark">
                                        {{ ucfirst($plan->billing_period) }}
                                    </span>
                                </td>
                                <td class="p-4 hidden md:table-cell">
                                    <span class="font-mono text-sm">
                                        {{ Number::currency($plan->price / 100, $plan->currency) }}
                                    </span>
                                </td>
                                <td class="p-4 hidden md:table-cell">
                                    @if ($plan->trial_period && $plan->trial_interval)
                                        <span class="text-sm text-on-surface dark:text-on-surface-dark">
                                            {{ $plan->trial_interval }} {{ ucfirst($plan->trial_period) }}{{ (int) $plan->trial_interval !== 1 ? 's' : '' }}
                                        </span>
                                    @else
                                        <span class="text-xs text-on-surface-muted dark:text-on-surface-dark-muted">
                                            {{ __('No trial') }}
                                        </span>
                                    @endif
                                </td>
                                <td class="p-4 text-center">
                                    <x-toggle size="sm" labelPosition="none" :checked="$plan->is_featured"
                                        wire:click="togglePlanFeatured({{ $plan->id }})" :ariaLabel="__('Toggle featured for :name', ['name' => $plan->name])" />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <x-blocks.empty-state icon="credit-card" class="h-[30svh]" title="{{ __('No plans') }}"
                description="{{ __('There are no subscription plans in the database yet. You can add them in LemonSqueezy and sync them here.') }}" />
        @endif
    </div>

    <!-- Products Table -->
    <div class="space-y-4">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="heading-5 text-on-surface-strong dark:text-on-surface-dark-strong">
                    {{ __('Products') }}
                </h2>
                <p class="text-xs text-on-surface-muted dark:text-on-surface-dark-muted mt-1">
                    {{ __('Drag using the handle to change order. Toggle featured to highlight products in the app.') }}
                </p>
            </div>
        </div>

        @if ($products->isNotEmpty())
            <div class="overflow-hidden overflow-x-auto rounded-radius border border-outline dark:border-outline-dark">
                <table class="w-full text-left text-xs sm:text-sm text-on-surface dark:text-on-surface-dark">
                    <thead
                        class="border-b border-outline bg-surface-alt text-xs sm:text-sm text-on-surface-strong dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark-strong [&_th]:p-2 sm:[&_th]:p-4">
                        <tr>
                            <th scope="col" class="w-10"></th>
                            <th scope="col">{{ __('Name') }}</th>
                            <th scope="col" class="hidden md:table-cell">{{ __('Price') }}</th>
                            <th scope="col" class="text-center">{{ __('Featured') }}</th>
                        </tr>
                    </thead>

                    <tbody wire:sort="sortProduct"
                        class="divide-y divide-outline bg-surface dark:divide-outline-dark dark:bg-surface-dark [&_td]:p-2.5 sm:[&_td]:p-4">
                        @foreach ($products as $product)
                            <tr wire:sort:item="{{ $product->id }}" wire:key="product-{{ $product->id }}">
                                <td class="p-2 text-center">
                                    <button type="button" wire:sort:handle
                                        class="inline-flex items-center justify-center rounded-radius p-1.5 text-on-surface-muted hover:text-on-surface-strong hover:bg-surface-dark/5 dark:text-on-surface-dark-muted dark:hover:text-on-surface-dark-strong dark:hover:bg-surface/5 cursor-grab active:cursor-grabbing"
                                        aria-label="{{ __('Reorder product') }}">
                                        <x-icons.bars-3 variant="outline" size="sm" />
                                    </button>
                                </td>
                                <td class="p-4">
                                    <div class="flex flex-col">
                                        <span
                                            class="text-sm font-medium text-on-surface-strong dark:text-on-surface-dark-strong">
                                            {{ $product->name }}
                                        </span>
                                        <span class="text-xs text-on-surface-muted dark:text-on-surface-dark-muted">
                                            {{ __('Variant ID: :id', ['id' => $product->lemon_squeezy_variant_id]) }}
                                        </span>
                                    </div>
                                </td>

                                <td class="p-4 hidden md:table-cell">
                                    <span class="font-mono text-sm">
                                        {{ Number::currency($product->price / 100, $product->currency) }}
                                    </span>
                                </td>
                                <td class="p-4 text-center">
                                    <x-toggle size="sm" labelPosition="none" :checked="$product->is_featured"
                                        wire:click="toggleProductFeatured({{ $product->id }})" :ariaLabel="__('Toggle featured for :name', ['name' => $product->name])" />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <x-blocks.empty-state icon="shopping-bag" class="h-[30svh]" title="{{ __('No products') }}"
                description="{{ __('There are no one-time products in the database yet. You can add them in LemonSqueezy and sync them here.') }}" />
        @endif
    </div>
</div>
