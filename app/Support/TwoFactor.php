<?php

namespace App\Support;

use App\Notifications\EmailVerificationNotification;
use App\Notifications\PhoneVerificationNotification;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\RateLimiter;
use RuntimeException;

/**
 * Two-Factor Authentication service for generating and verifying SMS codes.
 */
class TwoFactor
{
    /**
     * Default rate limit: 1 request per 60 seconds.
     */
    private const RATE_LIMIT_DECAY_SECONDS = 60;

    /**
     * Default maximum verification attempts.
     */
    private const DEFAULT_MAX_ATTEMPTS = 5;

    /**
     * Generate a 6-digit verification code for a user.
     *
     * @param  int  $userId  The user ID
     * @param  int  $ttlMinutes  Time to live in minutes (default: 10)
     * @return string The generated 6-digit code
     */
    public static function generateFor(int $userId, int $ttlMinutes = 10): string
    {
        $code = (string) random_int(100000, 999999);
        $key = self::cacheKey($userId);

        Cache::put($key, password_hash($code, PASSWORD_BCRYPT), now()->addMinutes($ttlMinutes));
        Cache::put(self::attemptsKey($userId), 0, now()->addMinutes($ttlMinutes));

        return $code;
    }

    /**
     * Verify a 6-digit code for a user.
     *
     * @param  int  $userId  The user ID
     * @param  string  $code  The code to verify
     * @param  int  $maxAttempts  Maximum verification attempts (default: 5)
     * @return bool True if code is valid, false otherwise
     */
    public static function verify(int $userId, string $code, int $maxAttempts = self::DEFAULT_MAX_ATTEMPTS): bool
    {
        // Validate code format
        if (! preg_match('/^\d{6}$/', $code)) {
            return false;
        }

        $hash = Cache::get(self::cacheKey($userId));
        if (! $hash) {
            return false;
        }

        // Check current attempts before incrementing
        $currentAttempts = Cache::get(self::attemptsKey($userId), 0);
        if ($currentAttempts >= $maxAttempts) {
            Cache::forget(self::cacheKey($userId));
            Cache::forget(self::attemptsKey($userId));

            return false;
        }

        // Verify the code
        if (password_verify($code, $hash)) {
            Cache::forget(self::cacheKey($userId));
            Cache::forget(self::attemptsKey($userId));

            return true;
        }

        // Only increment attempts on failed verification
        Cache::increment(self::attemptsKey($userId));

        return false;
    }

    /**
     * Check if a user can request a new verification code.
     *
     * @param  int  $userId  The user ID
     * @return bool True if user can request a code, false if rate limited
     */
    public static function canRequestCode(int $userId): bool
    {
        return ! RateLimiter::tooManyAttempts(self::rateLimitKey($userId), 1);
    }

    /**
     * Get the number of seconds until the user can request a new code.
     *
     * @param  int  $userId  The user ID
     * @return int Number of seconds until next request is allowed (0 if allowed now)
     */
    public static function getSecondsUntilNextRequest(int $userId): int
    {
        $key = self::rateLimitKey($userId);

        if (! RateLimiter::tooManyAttempts($key, 1)) {
            return 0;
        }

        return RateLimiter::availableIn($key);
    }

    /**
     * Set rate limit for code requests (1 per 60 seconds).
     *
     * @param  int  $userId  The user ID
     */
    public static function setRateLimit(int $userId): void
    {
        RateLimiter::increment(self::rateLimitKey($userId), decaySeconds: self::RATE_LIMIT_DECAY_SECONDS);
    }

    /**
     * Send a verification code to the given phone number.
     * Checks rate limiting, generates code, sets rate limit, and sends SMS.
     *
     * @param  int  $userId  The user ID
     * @param  string  $phone  The phone number to send the code to
     * @param  int  $ttlMinutes  Time to live in minutes (default: 10)
     *
     * @throws ThrottleRequestsException If rate limit is exceeded
     * @throws RuntimeException If notification sending fails
     */
    public static function sendVerificationCode(int $userId, string $phone, int $ttlMinutes = 10): void
    {
        // Check rate limiting
        if (! self::canRequestCode($userId)) {
            $secondsRemaining = self::getSecondsUntilNextRequest($userId);

            throw new ThrottleRequestsException(
                __('You can request a new code in :seconds seconds', ['seconds' => $secondsRemaining]),
                null,
                [],
                $secondsRemaining
            );
        }

        // Generate verification code
        $code = self::generateFor($userId, $ttlMinutes);

        // Set rate limit (60 seconds cooldown)
        self::setRateLimit($userId);

        // Send SMS notification
        try {
            Notification::route('vonage', $phone)
                ->notify(new PhoneVerificationNotification($code));
        } catch (\Exception $e) {
            Log::error('Failed to send 2FA verification code via SMS', [
                'user_id' => $userId,
                'phone' => $phone,
                'error' => $e->getMessage(),
            ]);

            // Clear the generated code since notification failed
            self::clear($userId);
        }
    }

    /**
     * Send a verification code to the user's email address.
     * Checks rate limiting, generates code, sets rate limit, and sends email.
     *
     * @param  int  $userId  The user ID
     * @param  string  $email  The email address to send the code to
     * @param  int  $ttlMinutes  Time to live in minutes (default: 10)
     *
     * @throws ThrottleRequestsException If rate limit is exceeded
     * @throws RuntimeException If notification sending fails
     */
    public static function sendVerificationCodeViaEmail(int $userId, string $email, int $ttlMinutes = 10): void
    {
        // Check rate limiting
        if (! self::canRequestCode($userId)) {
            $secondsRemaining = self::getSecondsUntilNextRequest($userId);

            throw new ThrottleRequestsException(
                __('You can request a new code in :seconds seconds', ['seconds' => $secondsRemaining]),
                null,
                [],
                $secondsRemaining
            );
        }

        // Generate verification code
        $code = self::generateFor($userId, $ttlMinutes);

        // Set rate limit (60 seconds cooldown)
        self::setRateLimit($userId);

        // Send email notification
        try {
            Notification::route('mail', $email)
                ->notify(new EmailVerificationNotification($code));
        } catch (\Exception $e) {
            Log::error('Failed to send 2FA verification code via email', [
                'user_id' => $userId,
                'email' => $email,
                'error' => $e->getMessage(),
            ]);

            // Clear the generated code since notification failed
            self::clear($userId);
        }
    }

    /**
     * Check if a user has an active verification code.
     *
     * @param  int  $userId  The user ID
     * @return bool True if an active code exists, false otherwise
     */
    public static function hasActiveCode(int $userId): bool
    {
        return Cache::has(self::cacheKey($userId));
    }

    /**
     * Clear all 2FA data for a user (code, attempts, rate limit).
     *
     * @param  int  $userId  The user ID
     */
    public static function clear(int $userId): void
    {
        Cache::forget(self::cacheKey($userId));
        Cache::forget(self::attemptsKey($userId));
        RateLimiter::clear(self::rateLimitKey($userId));
    }

    /**
     * Get the cache key for storing verification code.
     *
     * @param  int  $userId  The user ID
     * @return string Cache key
     */
    private static function cacheKey(int $userId): string
    {
        return "2fa:{$userId}:code";
    }

    /**
     * Get the cache key for storing verification attempts.
     *
     * @param  int  $userId  The user ID
     * @return string Cache key
     */
    private static function attemptsKey(int $userId): string
    {
        return "2fa:{$userId}:attempts";
    }

    /**
     * Get the rate limiter key for code requests.
     *
     * @param  int  $userId  The user ID
     * @return string Rate limiter key
     */
    private static function rateLimitKey(int $userId): string
    {
        return "2fa:{$userId}:rate-limit";
    }
}
