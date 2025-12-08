<?php

namespace App\Livewire\Forms\Admin;

use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

/**
 * Livewire component for editing user information.
 *
 * This component provides a form interface for administrators to update
 * user personal information and address details. It includes validation,
 * real-time updates through Livewire events, and user feedback notifications.
 */
class EditUser extends Component
{
    /**
     * The user instance being edited.
     */
    public User $user;

    /**
     * The avatar URL from Cloudinary.
     */
    #[Validate('nullable|string|url')]
    public ?string $avatar = null;

    /**
     * The user's full name.
     */
    #[Validate('required|string|max:255')]
    public string $name = '';

    /**
     * The user's email address.
     */
    #[Validate('required|email|max:255')]
    public string $email = '';

    /**
     * The user's phone number.
     */
    #[Validate('nullable|string|max:14')]
    public ?string $phone = '';

    /**
     * The user's country.
     */
    #[Validate('nullable|string|max:255')]
    public ?string $country = '';

    /**
     * The user's street address.
     */
    #[Validate('nullable|string|max:255')]
    public ?string $street = '';

    /**
     * The user's city.
     */
    #[Validate('nullable|string|max:255')]
    public ?string $city = '';

    /**
     * The user's state or province.
     */
    #[Validate('nullable|string|max:255')]
    public ?string $state = '';

    /**
     * The user's ZIP or postal code.
     */
    #[Validate('nullable|string|max:255')]
    public ?string $zip = '';

    /**
     * Initialize the component with the user instance and populate form fields.
     *
     * This method sets up the component by binding the user model and
     * populating all form fields with the current user data.
     *
     * @param  User  $user  The user instance to edit
     */
    public function mount(User $user): void
    {
        $this->user = $user;

        // Populate form fields with existing user data
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->country = $user->country;
        $this->street = $user->street;
        $this->city = $user->city;
        $this->state = $user->state;
        $this->zip = $user->zip;
        $this->avatar = $user->avatar;
    }

    /**
     * Save the updated user information.
     *
     * This method validates all form inputs, including a unique email check
     * that excludes the current user's ID. Upon successful validation, it
     * updates the user model and dispatches a notification event.
     */
    public function save(): void
    {
        // Validate all form inputs
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|max:255|unique:users,email,{$this->user->id}",
            'phone' => 'nullable|string|max:14',
            'country' => 'nullable|string|max:255',
            'street' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'zip' => 'nullable|string|max:255',
            'avatar' => 'nullable|string',
        ]);

        // Update the user with validated data
        $this->user->update($validated);

        // Notify the user of successful update
        $this->dispatch('notify',
            variant: 'success',
            title: __('User Updated'),
            message: __('User information has been updated successfully!')
        );
    }

    /**
     * Remove the user's avatar.
     */
    public function removeAvatar(): void
    {
        $this->user->update(['avatar' => null]);
        $this->avatar = null;
        $this->user = $this->user->fresh();

        $this->dispatch('notify',
            variant: 'success',
            title: __('Avatar removed'),
            message: __('The avatar has been removed successfully')
        );
    }

    /**
     * Refresh the user model when user-updated event is dispatched.
     *
     * This method listens for the 'user-updated' event (dispatched by other
     * components like ManageUserRoles) and refreshes the user model to ensure
     * the component has the latest user data. It also re-populates form fields
     * with the fresh data.
     */
    #[On('user-updated')]
    public function updatedUser(): void
    {
        // Refresh the user model from the database
        $this->user = $this->user->fresh();

        // Re-populate form fields with updated user data
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->phone = $this->user->phone;
        $this->country = $this->user->country;
        $this->street = $this->user->street;
        $this->city = $this->user->city;
        $this->state = $this->user->state;
        $this->zip = $this->user->zip;
        $this->avatar = $this->user->avatar;
    }

    /**
     * Render the component view.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.forms.admin.edit-user');
    }
}
