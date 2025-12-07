<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

/**
 * Livewire component for deleting user accounts.
 *
 * This component handles the permanent deletion of user accounts, including
 * cancellation of active subscriptions before deletion. It ensures proper
 * cleanup of subscription data and provides user feedback through notifications.
 */
class DeleteUser extends Component
{
    /**
     * The user instance to be deleted.
     */
    public User $user;

    /**
     * Delete the user account and handle associated subscriptions.
     *
     * This method performs the following operations:
     * 1. Cancels any active subscription the user may have
     * 2. Logs the subscription cancellation for audit purposes
     * 3. Permanently deletes the user account
     * 4. Provides user feedback and redirects to the users list
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete()
    {
        try {
            if ($this->user->subscribed()) {
                $this->user->subscription()->cancelNow();

                Log::info('Subscription cancelled during account deletion', [
                    'user_id' => $this->user->id,
                    'subscription_id' => $this->user->subscription()->id,
                ]);
            }

            $this->user->delete();

            session()->flash('notification', [
                'variant' => 'success',
                'title' => __('User Deleted'),
                'message' => __('The user has been deleted successfully.'),
            ]);

            return $this->redirect(route('admin.users', absolute: false), navigate: true);
        } catch (Exception $e) {
            Log::error('Failed to delete user', ['user_id' => $this->user->id, 'error' => $e->getMessage()]);
            session()->flash('notification', ['variant' => 'danger', 'title' => __('Error'), 'message' => __('Failed to delete user. Please try again.')]);

            return $this->redirect(route('admin.users.show', $this->user, absolute: false), navigate: true);
        }
    }

    /**
     * Render the component view.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.admin.users.delete-user');
    }
}
