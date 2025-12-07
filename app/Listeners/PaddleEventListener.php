<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use Laravel\Paddle\Events\WebhookReceived;

class PaddleEventListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(WebhookReceived $event): void
    {
        match ($event->payload['event_type']) {
            'price.created' => handle_paddle_price_created($event->payload),
            'price.updated' => handle_paddle_price_updated($event->payload),
            'transaction.completed' => handle_paddle_transaction_completed($event->payload),

            default => Log::info('Unhandled Paddle Webhook:', $event->payload),
        };
    }
}
