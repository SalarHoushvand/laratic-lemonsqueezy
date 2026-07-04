<?php

namespace App\Jobs;

use App\Ai\Agents\ChatAgent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Laravel\Ai\Responses\StreamedAgentResponse;
use Laravel\Ai\Streaming\Events\TextDelta;

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

        Cache::put($bufKey, Cache::get($bufKey, ''), now()->addMinutes(10));

        $allMessages = $this->conversation;

        // Remove the trailing empty assistant placeholder added by the UI before dispatching.
        $lastMessage = end($allMessages);
        if (($lastMessage['role'] ?? '') === 'assistant' && ($lastMessage['content'] ?? '') === '') {
            array_pop($allMessages);
        }

        // Separate the current user prompt from the context messages.
        $prompt = '';
        $contextMessages = $allMessages;

        for ($i = count($allMessages) - 1; $i >= 0; $i--) {
            if ($allMessages[$i]['role'] === 'user') {
                $prompt = (string) $allMessages[$i]['content'];
                $contextMessages = array_slice($allMessages, 0, $i);
                break;
            }
        }

        $chatAgent = new ChatAgent($contextMessages);
        $stream = $chatAgent->stream($prompt, model: $this->model);

        $promptTokens = 0;
        $outputTokens = 0;

        $stream->then(function (StreamedAgentResponse $response) use (&$promptTokens, &$outputTokens): void {
            $promptTokens = (int) ($response->usage?->promptTokens ?? 0);
            $outputTokens = (int) ($response->usage?->completionTokens ?? 0);
        });

        $full = '';

        foreach ($stream as $event) {
            if (Cache::get($cancelKey, false)) {
                Cache::put($doneKey, true, now()->addMinutes(10));

                break;
            }

            if ($event instanceof TextDelta && $event->delta !== '') {
                $full .= $event->delta;
                Cache::put($bufKey, $full, now()->addMinutes(10));
            }
        }

        Cache::put($bufKey, $full, now()->addMinutes(10));
        Cache::put($doneKey, true, now()->addMinutes(10));

        ai_save_usage($this->userId, $this->model, $promptTokens, $outputTokens);
    }
}
