<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SocialLogin;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class SocialAuthController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirectToGoogle(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle the Google authentication callback.
     */
    public function handleGoogleCallback(): RedirectResponse
    {
        return $this->handleProviderCallback('google');
    }

    /**
     * Redirect the user to the GitHub authentication page.
     */
    public function redirectToGithub(): RedirectResponse
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * Handle the GitHub authentication callback.
     */
    public function handleGithubCallback(): RedirectResponse
    {
        return $this->handleProviderCallback('github');
    }

    /**
     * Shared handler for all OAuth provider callbacks.
     *
     * @param  string  $provider  The OAuth provider name (e.g., 'google', 'github')
     */
    protected function handleProviderCallback(string $provider): RedirectResponse
    {
        try {
            $socialiteUser = Socialite::driver($provider)->user();
        } catch (Throwable $e) {
            report($e);

            return redirect()
                ->route('login')
                ->withErrors([$provider => 'Unable to log in with '.ucfirst($provider).'. Please try again.']);
        }

        $providerId = $socialiteUser->getId();
        $providerEmail = $socialiteUser->getEmail();
        $avatar = $socialiteUser->getAvatar();

        // 1) Try to find existing social login
        $socialLogin = SocialLogin::query()
            ->where('provider', $provider)
            ->where('provider_id', $providerId)
            ->first();

        if ($socialLogin && $socialLogin->user) {
            Auth::login($socialLogin->user, remember: true);

            return redirect()->intended(route('dashboard'));
        }

        // 2) No social_login yet → match or create user by email (if we have one)
        $user = null;

        if ($providerEmail) {
            $user = User::query()->where('email', $providerEmail)->first();
        }

        if (! $user) {
            $user = User::create([
                'name' => $socialiteUser->getName()
                    ?: $socialiteUser->getNickname()
                    ?: ($providerEmail ?? ucfirst($provider).' User'),
                'email' => $providerEmail,
                'password' => Hash::make(Str::random(32)),
                'email_verified_at' => $providerEmail ? now() : null,
            ]);

            $user->assignRole('user');
        }

        // 3) Create or update social_login record
        $socialLogin = SocialLogin::updateOrCreate(
            [
                'provider' => $provider,
                'provider_id' => $providerId,
            ],
            [
                'user_id' => $user->id,
                'avatar' => $avatar,
                'access_token' => $socialiteUser->token ?? null,
                'refresh_token' => $socialiteUser->refreshToken ?? null,
                'token_expires_at' => isset($socialiteUser->expiresIn)
                    ? now()->addSeconds($socialiteUser->expiresIn)
                    : null,
            ],
        );

        Auth::login($user, remember: true);

        return redirect()->intended(route('dashboard'));
    }
}
