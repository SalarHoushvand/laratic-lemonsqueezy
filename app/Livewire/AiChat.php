<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Jobs\StreamAiReply;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class AiChat extends Component
{
    // Conversation messages, used to store the conversation history
    public array $messages = [];

    // Current user input (prompt) bound to the UI
    public string $input = '';

    // The id of the assistant message currently receiving streamed tokens
    public ?string $streamingId = null;

    public function mount(): void
    {
        $this->messages = [];
    }

    public function render()
    {
        return view('livewire.ai-chat');
    }

    public function send(): void
    {

        // Clean up the input
        $promptText = trim($this->input);
        if ($promptText === '') {
            return;
        }

        // Add the user message to the message history
        $this->messages[] = [
            'role' => 'user',
            'content' => $promptText,
        ];

        $assistantId = (string) Str::ulid();

        // Add the assistant message to the message history
        $this->messages[] = [
            'id' => $assistantId,
            'role' => 'assistant',
            'content' => '',
        ];

        $this->streamingId = $assistantId;

        // Clear prompt input after sending
        $this->input = '';

        $this->resetStreamCache($assistantId);

        $conversation = array_map(function ($message) {
            return [
                'role' => (string) $message['role'],
                'content' => (string) $message['content'],
                'id' => isset($message['id']) ? (string) $message['id'] : null,
            ];
        }, $this->messages);

        StreamAiReply::dispatch(
            conversation: $conversation,
            assistantId: $assistantId,
            userId: Auth::id()
        );

    }

    /**
     * Request cancellation of the current stream and stop polling.
     */
    public function stop(): void
    {
        if (! $this->streamingId) {
            return;
        }

        // Flip cancel flag; job will exit on next tick
        Cache::put($this->cancelKey($this->streamingId), true, now()->addMinutes(10));

        // Also mark done so UI stops polling quickly
        Cache::put($this->doneKey($this->streamingId), true, now()->addMinutes(10));

        $this->streamingId = null;
    }

    /**
     * Initialize all cache keys used for streaming for a given assistant id.
     */
    protected function resetStreamCache(string $assistantId): void
    {
        Cache::put($this->bufKey($assistantId), '', now()->addMinutes(10));
        Cache::put($this->doneKey($assistantId), false, now()->addMinutes(10));
        Cache::put($this->cancelKey($assistantId), false, now()->addMinutes(10));
    }

    /**
     * Cache key for the streaming buffer for an assistant message.
     */
    protected function bufKey(string $assistantId): string
    {
        return "ai:buffer:{$assistantId}";
    }

    /**
     * Cache key indicating that streaming is finished for an assistant message.
     */
    protected function doneKey(string $assistantId): string
    {
        return "ai:done:{$assistantId}";
    }

    /**
     * Cache key used by the job to detect a user cancellation request.
     */
    protected function cancelKey(string $assistantId): string
    {
        return "ai:cancel:{$assistantId}";
    }

    /**
     * Pull the latest streamed buffer and update the last assistant message.
     * If the stream is marked done, stop polling.
     */
    public function pullChunks(): void
    {
        if (! $this->streamingId) {
            return;
        }

        $buf = Cache::get($this->bufKey($this->streamingId), '');
        $done = Cache::get($this->doneKey($this->streamingId), false);

        // Update last assistant message content
        foreach (array_reverse($this->messages, true) as $i => $message) {
            if (($message['role'] ?? null) === 'assistant' && ($message['id'] ?? null) === $this->streamingId) {
                $this->messages[$i]['content'] = $buf;
                break;
            }
        }

        if ($done) {
            $this->streamingId = null;
        }
    }
}
