<?php

namespace App\Livewire\Settings;

use App\Support\TwoFactor as TwoFactorService;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TwoFactor extends Component
{
    public ?string $phone = '';

    public string $verification_code = '';

    public bool $sms_consent = false;

    public string $password = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $this->phone = $user->phone ?? '+1 '; // Default to US country code if no phone number is set
    }

    /**
     * Send verification code after user enters phone number.
     */
    public function sendVerificationCode(): void
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Validate phone and consent
        $this->validate([
            'phone' => ['required', 'string', 'min:9', 'max:20'],
            'sms_consent' => ['accepted'],
        ], [
            'sms_consent.accepted' => __('You must consent to receive SMS messages to enable two-factor authentication.'),
        ]);

        // Rate limiting - check if user recently requested a code
        if (! TwoFactorService::canRequestCode($user->id)) {
            $secondsRemaining = TwoFactorService::getSecondsUntilNextRequest($user->id);

            $this->dispatch(
                'notify',
                variant: 'warning',
                title: __('Please wait'),
                message: __('You can request a new code in :seconds seconds', ['seconds' => $secondsRemaining])
            );

            return;
        }

        // Send verification code (handles generation, rate limiting, and SMS)
        try {
            TwoFactorService::sendVerificationCode($user->id, $this->phone, 15);
        } catch (ThrottleRequestsException $e) {
            $this->dispatch(
                'notify',
                variant: 'warning',
                title: __('Please wait'),
                message: $e->getMessage()
            );

            return;
        }

        // Close enable modal and open verification modal
        $this->dispatch('close-modal', name: 'enable-2fa');
        $this->dispatch('open-modal', name: 'verify-phone');

        $this->dispatch(
            'notify',
            variant: 'success',
            title: __('Verification code sent'),
            message: __('A 6-digit code has been sent to your phone number')
        );
    }

    /**
     * Verify the phone number and enable 2FA.
     */
    public function verifyAndEnable(): void
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $this->validate([
            'verification_code' => ['required', 'string', 'size:6'],
        ]);

        // Verify the code
        if (! TwoFactorService::verify($user->id, $this->verification_code)) {
            $this->addError('verification_code', __('Invalid or expired verification code. Please try again.'));

            return;
        }

        // Enable 2FA and save phone number
        $user->phone = $this->phone;
        $user->phone_verified_at = now();
        $user->two_factor_enabled = true;
        $user->save();

        // Close modal and reset
        $this->dispatch('close-modal');
        $this->verification_code = '';
        $this->phone = $user->phone;

        $this->dispatch(
            'notify',
            variant: 'success',
            title: __('Two-Factor Authentication enabled'),
            message: __('Your account is now protected with SMS-based two-factor authentication')
        );
    }

    /**
     * Resend verification code.
     */
    public function resendCode(): void
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Rate limiting
        if (! TwoFactorService::canRequestCode($user->id)) {
            $secondsRemaining = TwoFactorService::getSecondsUntilNextRequest($user->id);

            $this->dispatch(
                'notify',
                variant: 'warning',
                title: __('Please wait'),
                message: __('You can request a new code in :seconds seconds', ['seconds' => $secondsRemaining])
            );

            return;
        }

        // Send verification code (handles generation, rate limiting, and SMS)
        try {
            TwoFactorService::sendVerificationCode($user->id, $this->phone, 15);
        } catch (ThrottleRequestsException $e) {
            $this->dispatch(
                'notify',
                variant: 'warning',
                title: __('Please wait'),
                message: $e->getMessage()
            );

            return;
        }

        $this->dispatch(
            'notify',
            variant: 'success',
            title: __('Code resent'),
            message: __('A new verification code has been sent to your phone')
        );
    }

    /**
     * Disable 2FA after confirmation.
     */
    public function disableTwoFactor(): void
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $user->two_factor_enabled = false;
        $user->phone = null;
        $user->phone_verified_at = null;
        $user->save();

        $this->phone = '';
        $this->password = '';
        $this->dispatch('close-modal');

        $this->dispatch(
            'notify',
            variant: 'success',
            title: __('Two-Factor Authentication disabled'),
            message: __('Your account is no longer using two-factor authentication')
        );
    }

    public function render()
    {
        return view('livewire.settings.two-factor');
    }
}
