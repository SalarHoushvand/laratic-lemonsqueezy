<?php

namespace App\Jobs;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Prism\Prism\Enums\Provider;
use Prism\Prism\Prism;
use Prism\Prism\Schema\ObjectSchema;
use Prism\Prism\Schema\StringSchema;
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

            $schema = new ObjectSchema(
                name: 'translated_post',
                description: 'A translated blog post payload',
                properties: [
                    new StringSchema('title', 'Translated H1 title for the blog post'),
                    new StringSchema('description', 'Translated 1-2 sentence summary/teaser for the post, should be 200 characters or less'),
                    new StringSchema('content', 'Full translated post body in GitHub-flavored well styled Markdown'),
                ],
                requiredFields: ['title', 'description', 'content']
            );

            $systemPrompt = "You are a professional translator specializing in blog post translation. Your task is to translate blog posts accurately while maintaining:\n".
                "- The original meaning and tone\n".
                "- The structure and formatting (headings, lists, code blocks)\n".
                "- The author's voice and style\n".
                "- Technical accuracy for any code examples or technical terms\n".
                "- Preserve all Markdown formatting (H2/H3 headings, lists, code blocks, etc.)\n";

            $userPrompt = "Translate the following blog post from {$sourceLanguageName} to {$targetLanguageName}:\n\n".
                "Title: {$this->sourcePost->title}\n\n".
                "Description: {$this->sourcePost->description}\n\n".
                "Content:\n{$this->sourcePost->content}\n\n".
                'Provide a complete translation maintaining all formatting and structure.';

            $response = Prism::structured()
                ->using(Provider::OpenAI, $this->model)
                ->withSchema($schema)
                ->withSystemPrompt($systemPrompt)
                ->withPrompt($userPrompt)
                ->withProviderOptions([
                    'schema' => ['strict' => true],
                ])
                ->withClientOptions([
                    'timeout' => $this->timeout,
                ])
                ->asStructured();

            if ($response->structured === null) {
                throw new RuntimeException('AI did not return structured data. Please try again.');
            }

            $data = $response->structured;

            if (! isset($data['title'], $data['description'], $data['content'])) {
                throw new RuntimeException('Structured response missing required fields.');
            }

            $translatedPost = Post::create([
                'reference_number' => $this->sourcePost->reference_number,
                'title' => (string) $data['title'],
                'description' => (string) $data['description'],
                'content' => (string) $data['content'],
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
