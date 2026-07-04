<?php

namespace App\Jobs;

use App\Ai\Agents\TranslationAgent;
use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Laravel\Ai\Enums\Lab;
use Laravel\Ai\Responses\StructuredAgentResponse;
use RuntimeException;

/**
 * Translate a blog post using AI.
 *
 * This job translates an existing blog post from one language to another using
 * AI models. The translated post is created as inactive and can be activated
 * later by administrators. Translation maintains formatting, structure, and
 * technical accuracy.
 */
class TranslatePostWithAi implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The AI model to use for the translation.
     */
    public string $model = 'gpt-4.1';

    /**
     * The timeout for the translation job in seconds.
     */
    public int $timeout = 120;

    /**
     * Create a new job instance.
     *
     * @param  string  $requestId  Unique identifier for the translation request
     * @param  Post  $sourcePost  The source post to translate
     * @param  string  $targetLanguage  The target language code to translate the post to
     * @param  int|null  $userId  The user ID of the user who initiated the translation
     */
    public function __construct(
        public string $requestId,
        public Post $sourcePost,
        public string $targetLanguage,
        public ?int $userId = null
    ) {
        $this->onQueue('ai');
    }

    /**
     * Execute the job.
     *
     * Translates the source post to the target language using AI, creates a new
     * Post record with the translated content, tracks AI usage for billing,
     * and caches the result for retrieval.
     */
    public function handle(): void
    {
        $baseKey = 'translate_post_ai:'.$this->requestId;
        $usageIds = [];

        try {
            $languages = config('languages', []);
            $targetLanguageName = (isset($languages[$this->targetLanguage]) ? $languages[$this->targetLanguage]['name'] : null) ?? $this->targetLanguage;
            $sourceLanguageName = (isset($languages[$this->sourcePost->language]) ? $languages[$this->sourcePost->language]['name'] : null) ?? $this->sourcePost->language;

            $userPrompt = "Translate the following blog post from {$sourceLanguageName} to {$targetLanguageName}:\n\n"
                ."Title: {$this->sourcePost->title}\n\n"
                ."Description: {$this->sourcePost->description}\n\n"
                ."Content:\n{$this->sourcePost->content}\n\n"
                .'Provide a complete translation maintaining all formatting and structure.';

            $response = (new TranslationAgent)->prompt(
                $userPrompt,
                provider: Lab::OpenAI,
                model: $this->model,
                timeout: $this->timeout
            );

            assert($response instanceof StructuredAgentResponse);

            if (! isset($response['title'], $response['description'], $response['content'])) {
                throw new RuntimeException('Structured response missing required fields.');
            }

            $translatedPost = Post::create([
                'reference_number' => $this->sourcePost->reference_number,
                'title' => (string) $response['title'],
                'description' => (string) $response['description'],
                'content' => (string) $response['content'],
                'image_url' => $this->sourcePost->image_url,
                'author' => $this->sourcePost->author ?? 'Laratic AI Engine',
                'language' => $this->targetLanguage,
                'is_active' => false,
                'is_promoted' => false,
            ]);

            $promptTokens = (int) $response->usage->promptTokens;
            $outputTokens = (int) $response->usage->completionTokens;
            $textGenerationUsage = ai_save_usage($this->userId, $this->model, $promptTokens, $outputTokens);
            $usageIds[] = $textGenerationUsage->id;

            if (! empty($usageIds)) {
                $translatedPost->aiUsages()->attach($usageIds);
            }

            Cache::put("{$baseKey}:result", ['post_id' => $translatedPost->id], now()->addMinutes(20));
            Cache::put("{$baseKey}:done", true, now()->addMinutes(20));
        } catch (\Throwable $e) {
            Log::error('TranslatePostWithAi failed: '.$e->getMessage());
            Cache::put("{$baseKey}:error", $e->getMessage(), now()->addMinutes(20));
            Cache::put("{$baseKey}:done", true, now()->addMinutes(20));
        }
    }
}
