<?php

namespace App\Listeners;

use App\Notifications\WelcomeNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class SendWelcomeNotification
{
    /**
     * Handle the event.
     */
    public function handle(Registered $event): void
    {
        $user = $event->user;

        if (! $user || ! isset($user->id)) {
            return;
        }

        $cacheKey = "welcome_notification_sent_{$user->id}";

        // Check if we've already sent a welcome notification to this user
        // Use cache to prevent duplicate sends within a short time window
        if (! Cache::has($cacheKey)) {
            try {
                $user->notify(new WelcomeNotification);

                // Mark as sent for 1 hour to prevent duplicates
                Cache::put($cacheKey, true, now()->addHour());
            } catch (\Exception $e) {
                Log::error('Failed to send welcome notification', [
                    'user_id' => $user->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }
}
