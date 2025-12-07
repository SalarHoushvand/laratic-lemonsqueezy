<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Spatie\Permission\Models\Role;

/**
 * Livewire component for managing user roles.
 *
 * This component provides functionality for administrators to add and remove
 * roles from users. It automatically filters out roles that are already assigned
 * to the user and provides real-time updates through Livewire events.
 */
class ManageUserRoles extends Component
{
    /**
     * The user instance whose roles are being managed.
     */
    public User $user;

    /**
     * The currently selected role from the dropdown.
     * Automatically triggers addRole() when a value is selected.
     */
    public ?string $selectedRole = null;

    /**
     * Initialize the component with the user instance.
     *
     * @param  User  $user  The user whose roles will be managed
     */
    public function mount(User $user): void
    {
        $this->user = $user;
    }

    /**
     * Handle the automatic role assignment when a role is selected from the dropdown.
     *
     * This method is triggered by Livewire's property update hook when
     * selectedRole changes. It validates the selection and calls addRole()
     * to assign the role to the user.
     *
     * @param  string|null  $value  The role name that was selected
     */
    public function updatedSelectedRole(?string $value): void
    {
        if ($value && ! empty($value)) {
            $this->addRole($value);
        }
    }

    /**
     * Assign a role to the user.
     *
     * This method checks if the user already has the role before assigning it,
     * preventing duplicate role assignments. After successful assignment, it
     * refreshes the user model, resets the selection, and dispatches events
     * to notify other components and show user feedback.
     *
     * @param  string  $roleName  The name of the role to assign
     */
    public function addRole(string $roleName): void
    {
        try {
            if (! $this->user->hasRole($roleName)) {
                $this->user->assignRole($roleName);
                $this->user->refresh();
                $this->selectedRole = null;

                $this->dispatch('notify',
                    variant: 'success',
                    title: __('Role Added'),
                    message: __('The role has been added successfully.')
                );

                $this->dispatch('user-updated');
            }
        } catch (Exception $e) {
            Log::error('Failed to add role to user', ['user_id' => $this->user->id, 'role_name' => $roleName, 'error' => $e->getMessage()]);
            $this->dispatch('notify', variant: 'danger', title: __('Error'), message: __('Failed to add role. Please try again.'));
        }
    }

    /**
     * Remove a role from the user.
     *
     * This method verifies the user has the role before removing it, then
     * refreshes the user model and dispatches events for UI updates and
     * user notifications.
     *
     * @param  string  $roleName  The name of the role to remove
     */
    public function removeRole(string $roleName): void
    {
        try {
            if ($this->user->hasRole($roleName)) {
                $this->user->removeRole($roleName);
                $this->user->refresh();

                $this->dispatch('notify',
                    variant: 'success',
                    title: __('Role Removed'),
                    message: __('The role has been removed successfully.')
                );

                $this->dispatch('user-updated');
            }
        } catch (Exception $e) {
            Log::error('Failed to remove role from user', ['user_id' => $this->user->id, 'role_name' => $roleName, 'error' => $e->getMessage()]);
            $this->dispatch('notify', variant: 'danger', title: __('Error'), message: __('Failed to remove role. Please try again.'));
        }
    }

    /**
     * Get the list of available roles that can be assigned to the user.
     *
     * This computed property filters out roles that are already assigned to
     * the user, returning only roles that can be added. The result is formatted
     * as an array suitable for use in dropdown components.
     *
     * @return array<int, array{value: string, label: string}>
     */
    public function getAvailableRolesProperty(): array
    {
        $allRoles = Role::orderBy('name')->get();
        $userRoleNames = $this->user->roles->pluck('name')->toArray();

        return $allRoles->reject(function ($role) use ($userRoleNames) {
            return in_array($role->name, $userRoleNames);
        })->map(function ($role) {
            return [
                'value' => $role->name,
                'label' => ucfirst($role->name),
            ];
        })->values()->toArray();
    }

    /**
     * Render the component view.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.admin.users.manage-user-roles');
    }
}
