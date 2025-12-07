@push('head')
    <title>{{ __('Edit User') }}</title>
@endpush

<x-layouts.admin>

    <x-typography.admin-page-header :title="__('User Details')" :description="__('View and manage user details here.')" />


    <div class="flex flex-col gap-8 md:flex-row">
        <livewire:forms.admin.edit-user :user="$user" />


        <div class="flex w-full md:max-w-xs flex-col gap-8">
            <!-- Subscription Info -->
            <x-blocks.admin.users.subscription-details :user="$user" />

            <!-- Roles Management -->
            <div class="flex flex-col gap-4 panel">
                <livewire:admin.users.manage-user-roles :user="$user" />
            </div>

            <!-- Actions -->
            <div
                class="flex flex-col gap-4 panel">
                <h2 class="heading-5 mb-4 text-on-surface-strong dark:text-on-surface-dark-strong">
                    {{ __('Actions') }}
                </h2>

                <livewire:admin.users.delete-user :user="$user" />

                <livewire:admin.users.block-user :user="$user" />
            </div>
        </div>

    </div>

    <!-- Transactions Section -->
    <div class="mt-12 w-full">
        <h2 class="heading-5 mb-4 text-on-surface-strong dark:text-on-surface-dark-strong">
            {{ __('Transactions') }}
        </h2>
        <livewire:admin.users.transactions :user="$user" />
    </div>


    <!-- Orders Section -->
    <div class="mt-12">
        <h2 class="heading-5 mb-4 text-on-surface-strong dark:text-on-surface-dark-strong">
            {{ __('Orders') }}
        </h2>
        <livewire:admin.users.orders :user="$user" />
    </div>
</x-layouts.admin>
