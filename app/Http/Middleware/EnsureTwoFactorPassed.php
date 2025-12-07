<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTwoFactorPassed
{
    /**
     * Session key used to track if user has passed 2FA verification.
     */
    private const SESSION_KEY = '2fa_passed';

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var \App\Models\User|null $user */
        $user = $request->user();

        if ($user && $user->two_factor_enabled && ! $request->session()->get(self::SESSION_KEY)) {
            return redirect()->route('two-factor-auth');
        }

        return $next($request);
    }
}
