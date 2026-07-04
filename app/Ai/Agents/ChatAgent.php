<?php

namespace App\Ai\Agents;

use Laravel\Ai\Attributes\Provider;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\Conversational;
use Laravel\Ai\Enums\Lab;
use Laravel\Ai\Messages\Message;
use Laravel\Ai\Promptable;
use Stringable;

/**
 * Agent for multi-turn streaming chat conversations.
 *
 * Accepts pre-built context messages to populate conversation history.
 */
#[Provider(Lab::OpenAI)]
class ChatAgent implements Agent, Conversational
{
    use Promptable;

    /**
     * @param  array<int, array{role: string, content: string}>  $contextMessages
     */
    public function __construct(protected array $contextMessages = []) {}

    public function instructions(): Stringable|string
    {
        return 'You are a helpful assistant.';
    }

    /**
     * Build context messages from the conversation array, excluding system messages.
     *
     * @return Message[]
     */
    public function messages(): iterable
    {
        $messages = [];

        foreach ($this->contextMessages as $message) {
            $role = (string) ($message['role'] ?? 'user');
            $content = (string) ($message['content'] ?? '');

            if (! in_array($role, ['user', 'assistant'], strict: true)) {
                continue;
            }

            $messages[] = new Message($role, $content);
        }

        return $messages;
    }
}
