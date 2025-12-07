<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;

/**
 * Livewire component for blocking and unblocking user accounts.
 *
 * This component provides functionality for administrators to toggle the
 * blocked status of users by assigning or removing the 'blocked' role.
 * It listens for user update events to keep the component state synchronized.
 */
class BlockUser extends Component
{
    /**
     * The user instance whose blocked status is being managed.
     */
    public User $user;

    /**
     * Toggle the blocked status of the user.
     *
     * This method checks if the user currently has the 'blocked' role and
     * either removes it (unblocking) or assigns it (blocking). After the
     * operation, it provides user feedback and redirects back to the user
     * detail page.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleBlock()
    {
        try {
            if ($this->user->hasRole('blocked')) {
                $this->user->removeRole('blocked');
            } else {
                $this->user->assignRole('blocked');
            }
            $this->dispatch('user-updated');
            $this->dispatch('notify', variant: 'success', title: __('User Block Status Updated'), message: __('The user\'s block status has been updated successfully.'));
            $this->dispatch('close-modal', name: 'block-user-'.$this->user->id);
            
        } catch (Exception $e) {
            Log::error('Failed to toggle user block status', ['user_id' => $this->user->id, 'error' => $e->getMessage()]);
            session()->flash('notification', ['variant' => 'danger', 'title' => __('Error'), 'message' => __('Failed to update user status. Please try again.')]);

            return $this->redirect(route('admin.users.show', $this->user, absolute: false), navigate: true);
        }
    }

    /**
     * Refresh the user model when user-updated event is dispatched.
     *
     * This method listens for the 'user-updated' event (dispatched by other
     * components like ManageUserRoles) and refreshes the user model to ensure
     * the component has the latest user data, including updated roles.
     *
     * @return void
     */
    #[On('user-updated')]
    public function updatedUser()
    {
        $this->user = $this->user->fresh();

    }

    /**
     * Render the component view.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.admin.users.block-user');
    }
}
