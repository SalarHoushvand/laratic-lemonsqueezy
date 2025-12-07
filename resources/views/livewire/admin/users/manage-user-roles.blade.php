<div class="flex flex-col gap-4">
    <h2 class="heading-5 text-on-surface-strong dark:text-on-surface-dark-strong">
        {{ __('Roles') }}
    </h2>

    <!-- Current Roles -->
    <div class="flex flex-col gap-2">
        <label class="text-sm text-on-surface dark:text-on-surface-dark">
            {{ __('Current Roles') }}
        </label>
        @if ($user->roles->count() > 0)
            <div class="flex flex-wrap gap-2">
                @foreach ($user->roles as $role)
                    <x-badge size="sm" variant="outline-primary" 
                            wire:loading.attr="disabled" wire:target="removeRole"
                            class="cursor-pointer hover:opacity-75 focus:outline-none"
                            aria-label="{{ __('Remove :role role', ['role' => $role->name]) }}">
                            {{ ucfirst($role->name) }}
                            <x-icons.x-mark size="md" variant="micro"  wire:click="removeRole('{{ $role->name }}')" />
                        </x-badge>
                @endforeach
            </div>
        @else
            <p class="text-sm text-on-surface/60 dark:text-on-surface-dark/60">
                {{ __('No roles assigned') }}
            </p>
        @endif
    </div>

    <!-- Add Role Dropdown -->
    @if (count($this->availableRoles) > 0)
        <div class="flex flex-col gap-2">
            <label for="role-select" class="text-sm text-on-surface dark:text-on-surface-dark">
                {{ __('Add Role') }}
            </label>
            <x-select id="role-select" name="role-select" wire:model.live="selectedRole" width="w-full"
                wire:loading.attr="disabled" wire:target="selectedRole">
                <option value="">{{ __('Select a role to add') }}</option>
                @foreach ($this->availableRoles as $role)
                    <option value="{{ $role['value'] }}">
                        {{ $role['label'] }}
                    </option>
                @endforeach
            </x-select>
        </div>
    @else
        <div class="flex flex-col gap-2">
            <p class="text-sm text-on-surface/60 dark:text-on-surface-dark/60">
                {{ __('All available roles have been assigned to this user.') }}
            </p>
        </div>
    @endif
</div>
