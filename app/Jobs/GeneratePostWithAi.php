<?php

namespace App\Jobs;

use App\Ai\Agents\BlogPostAgent;
use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Ai\Enums\Lab;
use Laravel\Ai\Image;
use Laravel\Ai\Responses\StructuredAgentResponse;
use RuntimeException;

/**
 * Generate a blog post using AI.
 *
 * This job generates a complete blog post including title, description, content,
 * and cover image using AI models. The post is created as inactive and can be
 * activated later by administrators.
 */
class GeneratePostWithAi implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * OpenAI model to use for the text generation.
     */
    public string $model = 'gpt-4o';

    /**
     * OpenAI model to use for the image generation.
     */
    public string $imageModel = 'gpt-image-1';

    /**
     * Timeout for the AI generation in seconds.
     */
    public int $timeout = 120;

    /**
     * Maximum number of attempts to generate the image.
     */
    public int $maxAttempts = 3;

    /**
     * Create a new job instance.
     *
     * @param  string  $requestId  Unique identifier for the generation request
     * @param  string  $aiPrompt  User-provided prompt for the generation
     * @param  string  $title  Title of the post
     * @param  string  $description  Description of the post
     * @param  int|null  $userId  User ID used to track the usage of the generation
     */
    public function __construct(
        public string $requestId,
        public string $aiPrompt = '',
        public string $title = '',
        public string $description = '',
        public ?int $userId = null
    ) {
        $this->onQueue('ai');
    }

    /**
     * Execute the job.
     *
     * Generates a blog post with AI, including text content and cover image.
     * Creates the post as inactive and caches the result for retrieval.
     */
    public function handle(): void
    {
        $baseKey = 'post_ai:'.$this->requestId;
        $usageIds = [];

        try {
            $userPrompt = trim($this->aiPrompt);
            $topic = trim($this->title) !== '' ? $this->title : 'a useful, everyday topic people care about';
            $desc = trim($this->description) !== '' ? $this->description : 'Write a clear blog post with a connected story arc, specific examples, and a friendly wrap-up. Keep it plain, no buzzwords.';

            if ($userPrompt === '') {
                $userPrompt = "Topic: {$topic}\nWhat to write about: {$desc}";
            }

            $imageUrl = $this->generateImage($userPrompt, $usageIds);

            $fullPrompt = "{$userPrompt}\n\n"
                .'Write a blog post (~1200-1800 words) with a clear narrative arc. '
                .'Description must be 200 characters or less.';

            $response = (new BlogPostAgent)->prompt(
                $fullPrompt,
                provider: Lab::OpenAI,
                model: $this->model,
                timeout: $this->timeout
            );

            assert($response instanceof StructuredAgentResponse);

            if (! isset($response['title'], $response['description'], $response['content'])) {
                throw new RuntimeException('Structured response missing required fields.');
            }

            $promptTokens = (int) $response->usage->promptTokens;
            $outputTokens = (int) $response->usage->completionTokens;
            $textGenerationUsage = ai_save_usage($this->userId, $this->model, $promptTokens, $outputTokens);
            $usageIds[] = $textGenerationUsage->id;

            $post = Post::create([
                'title' => (string) $response['title'],
                'description' => (string) $response['description'],
                'content' => (string) $response['content'],
                'image_url' => $imageUrl ?: null,
                'author' => 'Laratic Team',
                'language' => 'en',
                'is_active' => false,
                'is_promoted' => false,
            ]);

            if (! empty($usageIds)) {
                $post->aiUsages()->attach($usageIds);
            }

            Cache::put("{$baseKey}:result", ['post_id' => $post->id], now()->addMinutes(20));
            Cache::put("{$baseKey}:done", true, now()->addMinutes(20));
        } catch (\Throwable $e) {
            Log::error('GeneratePostWithAi failed: '.$e->getMessage());
            Cache::put("{$baseKey}:error", $e->getMessage(), now()->addMinutes(20));
            Cache::put("{$baseKey}:done", true, now()->addMinutes(20));
        }
    }

    /**
     * Generate a cover image using AI and upload it to S3.
     *
     * Attempts to generate an image using gpt-image-1 with retry logic. If successful,
     * uploads the image to S3 and returns the public URL.
     * Tracks AI usage for billing purposes.
     *
     * @param  string  $userPrompt  The prompt to use for image generation
     * @param  array<int>  $usageIds  Array reference to collect AI usage IDs
     * @return string The S3 public URL of the uploaded image, or empty string on failure
     */
    protected function generateImage(string $userPrompt, array &$usageIds): string
    {
        $attempt = 0;

        while ($attempt < $this->maxAttempts) {
            $attempt++;

            try {
                $imageResponse = Image::of(
                    'Hyper-realistic photograph, '
                    .'soft light, Canon EOS R5 and 50mm f/1.2 lens, '
                    .'detailed textures, extremely sharp realism, shallow depth of field. subject: '
                    .$userPrompt
                    .'. No text. Not too much details or too many items.'
                )
                    ->square()
                    ->quality('medium')
                    ->timeout($this->timeout)
                    ->generate(provider: Lab::OpenAI, model: $this->imageModel);

                $generatedImage = $imageResponse->firstImage();
                $imageContent = base64_decode($generatedImage->image);
                $path = 'posts/'.Str::uuid().'-test.png';

                Storage::disk('s3')->put($path, $imageContent);

                $imageGenerationUsage = ai_save_usage($this->userId, $this->imageModel, 0, 1);
                $usageIds[] = $imageGenerationUsage->id;

                return Storage::disk('s3')->url($path);
            } catch (\Throwable $e) {
                if ($attempt < $this->maxAttempts) {
                    Log::warning("Image generation failed (attempt {$attempt}/{$this->maxAttempts}): ".$e->getMessage().' Retrying...');
                    sleep(min($attempt * 2, 4));
                } else {
                    Log::error("Image generation failed after {$this->maxAttempts} attempts: ".$e->getMessage());
                }
            }
        }

        return '';
    }
}
