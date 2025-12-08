<?php

namespace App\Livewire\Auth;

use App\Support\TwoFactor as TwoFactorService;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('components.layouts.auth')]
class VerifyTwoFactorAuthCode extends Component
{
    /**
     * Session key used to track if user has passed 2FA verification.
     */
    private const SESSION_KEY = '2fa_passed';

    /**
     * Code TTL in minutes.
     */
    private const CODE_TTL_MINUTES = 10;

    #[Validate('required|string|size:6|regex:/^[0-9]{6}$/')]
    public string $code = '';

    /**
     * Mount the component and send initial verification code.
     */
    public function mount(): void
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if (! $user || ! $user->two_factor_enabled) {
            $this->redirect(route('login', absolute: false), navigate: false);

            return;
        }

        // If user already passed 2FA, redirect to dashboard
        if (Session::get(self::SESSION_KEY)) {
            $this->redirectIntended(default: $this->getDefaultRedirectRoute(), navigate: false);

            return;
        }

        // Send initial verification code if one doesn't exist
        if (! TwoFactorService::hasActiveCode($user->id)) {
            $this->sendCode();
        }
    }

    /**
     * Verify the 2FA code.
     */
    public function verify(): void
    {
        $this->validate();

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Verify the code
        if (! TwoFactorService::verify($user->id, $this->code)) {
            $this->addError('code', __('Invalid or expired verification code. Please try again.'));

            return;
        }

        // Mark 2FA as passed in session
        Session::put(self::SESSION_KEY, true);

        // Regenerate session for security
        Session::regenerate();

        // Redirect to intended destination
        $this->redirectIntended(default: $this->getDefaultRedirectRoute(), navigate: false);
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

        $this->sendCode();

        $message = __('A new verification code has been sent to your email');

        $this->dispatch(
            'notify',
            variant: 'success',
            title: __('Code resent'),
            message: $message
        );
    }

    /**
     * Send verification code to user's email.
     */
    protected function sendCode(): void
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if (! $user) {
            return;
        }

        // Send verification code (handles generation, rate limiting, and email)
        try {
            TwoFactorService::sendVerificationCodeViaEmail($user->id, $user->email, self::CODE_TTL_MINUTES);
            $this->dispatch(
                'notify',
                variant: 'success',
                title: __('Code sent'),
                message: __('A verification code has been sent to your email')
            );
        } catch (ThrottleRequestsException $e) {
            $this->dispatch(
                'notify',
                variant: 'warning',
                title: __('Please wait'),
                message: $e->getMessage()
            );
        }
    }

    /**
     * Get the default redirect route based on user role.
     */
    protected function getDefaultRedirectRoute(): string
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if ($user && $user->hasRole('admin')) {
            return route('admin.dashboard', absolute: false);
        }

        return route('dashboard', absolute: false);
    }

    /**
     * Logout and return to login page.
     */
    public function logout(): void
    {
        Auth::guard('web')->logout();

        Session::invalidate();
        Session::regenerateToken();

        $this->redirect(route('login', absolute: false), navigate: false);
    }

    public function render()
    {
        return view('livewire.auth.verify-two-factor-auth-code');
    }
}
