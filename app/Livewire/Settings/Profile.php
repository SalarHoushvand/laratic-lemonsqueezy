<?php

namespace App\Livewire\Settings;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Profile extends Component
{
    public string $name = '';

    public string $email = '';

    public ?string $avatar = null;

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->avatar = $user->avatar;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user->id),
            ],

            'avatar' => ['nullable', 'string'],

        ]);

        // Check if email is changing before updating
        $emailChanged = $user->email !== $validated['email'];

        $user->update($validated);

        if ($emailChanged) {
            $user->email_verified_at = null;
            $user->save();
        }

        // Refresh the avatar property to show the saved value
        $this->avatar = $user->avatar;

        $this->dispatch(
            'notify',
            variant: 'success',
            title: __('Profile updated'),
            message: __('Your profile has been updated successfully')
        );
    }

    /**
     * Remove the user's avatar.
     */
    public function removeAvatar(): void
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $user->update(['avatar' => null]);
        $this->avatar = null;

        $this->dispatch(
            'notify',
            variant: 'success',
            title: __('Avatar removed'),
            message: __('Your avatar has been removed successfully')
        );
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function resendVerificationNotification(): void
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}
