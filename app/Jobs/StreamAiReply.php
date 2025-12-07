<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Prism\Prism\Prism;
use Prism\Prism\Streaming\Events\StreamEndEvent;
use Prism\Prism\Streaming\Events\TextDeltaEvent;
use Prism\Prism\ValueObjects\Messages\AssistantMessage;
use Prism\Prism\ValueObjects\Messages\SystemMessage;
use Prism\Prism\ValueObjects\Messages\UserMessage;

/**
 * Stream AI replies using real-time streaming.
 *
 * This job processes conversation history and streams AI responses in real-time,
 * updating the cache buffer as text deltas arrive. Supports mid-stream cancellation
 * and tracks token usage for billing purposes.
 */
class StreamAiReply implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The model to use for the streaming reply.
     */
    public string $model = 'gpt-4o-mini';

    /**
     * Create a new job instance.
     *
     * @param  array<int, array{role: string, content: string}>  $conversation  The conversation history
     * @param  string  $assistantId  The ID of the assistant message
     * @param  int|null  $userId  The ID of the user who is streaming the reply
     */
    public function __construct(
        public array $conversation,
        public string $assistantId,
        public ?int $userId = null
    ) {
        $this->onQueue('ai');
    }

    /**
     * Execute the job.
     *
     * Processes the conversation history, streams AI responses in real-time,
     * updates the cache buffer with text deltas, handles cancellation, and
     * tracks token usage for billing.
     */
    public function handle(): void
    {
        $bufKey = "ai:buffer:{$this->assistantId}";
        $doneKey = "ai:done:{$this->assistantId}";
        $cancelKey = "ai:cancel:{$this->assistantId}";

        $messages = [];
        foreach ($this->conversation as $message) {
            $role = (string) ($message['role'] ?? 'user');
            $content = (string) ($message['content'] ?? '');

            if ($role === 'system') {
                $messages[] = new SystemMessage($content);
            } elseif ($role === 'assistant') {
                $messages[] = new AssistantMessage($content);
            } else {
                $messages[] = new UserMessage($content);
            }
        }

        Cache::put($bufKey, Cache::get($bufKey, ''), now()->addMinutes(10));

        $full = '';
        $provider = 'openai';
        $promptTokens = 0;
        $outputTokens = 0;

        $response = Prism::text()
            ->using($provider, $this->model)
            ->withSystemPrompt('You are a helpful assistant.')
            ->withMessages($messages)
            ->asStream();
            
        foreach ($response as $event) {
            if ($event instanceof StreamEndEvent && $event->usage) {
                $promptTokens = (int) $event->usage->promptTokens;
                $outputTokens = (int) $event->usage->completionTokens;
            }

            if (Cache::get($cancelKey, false)) {
                Cache::put($doneKey, true, now()->addMinutes(10));

                break;
            }

            if ($event instanceof TextDeltaEvent) {
                $delta = $event->delta;
                if ($delta !== '') {
                    $full .= $delta;
                    Cache::put($bufKey, $full, now()->addMinutes(10));
                }
            }
        }

        Cache::put($bufKey, $full, now()->addMinutes(10));
        Cache::put($doneKey, true, now()->addMinutes(10));

        ai_save_usage($this->userId, $this->model, $promptTokens, $outputTokens);
    }
}
