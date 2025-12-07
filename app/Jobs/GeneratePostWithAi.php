<?php

namespace App\Jobs;

use App\Models\Post;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
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
    public string $imageModel = 'dall-e-3';

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

            $schema = new ObjectSchema(
                name: 'blog_post',
                description: 'A structured blog post payload',
                properties: [
                    new StringSchema('title', 'Compelling H1 title for the blog post'),
                    new StringSchema('description', '1-2 sentence summary/teaser for the post, should be 200 characters or less'),
                    new StringSchema('content', 'Full blog post body in well formatted Markdown'),
                ],
                requiredFields: ['title', 'description', 'content']
            );

            $response = Prism::structured()
                ->using(Provider::OpenAI, $this->model)
                ->withSchema($schema)
                ->withSystemPrompt(
                    'You are a travel and Laravel web development blog writer. Write in story like 
                    but simple and natural English some very short and interesting code snippets, if required, 
                    and are related to the destination or the topic of the post. '.
                        'No buzzwords, corporate tone, or self-references. Use clear transitions between sections.'
                )
                ->withPrompt(
                    "{$userPrompt}\n\n".
                        'Write a blog post (~1200-1800 words) with a clear narrative arc. '.

                        'Description must be 200 characters or less.'
                )
                ->withProviderOptions([
                    'schema' => [
                        'strict' => true,
                    ],
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

            $promptTokens = (int) $response->usage->promptTokens;
            $outputTokens = (int) $response->usage->completionTokens;
            $textGenerationUsage = ai_save_usage($this->userId, $this->model, $promptTokens, $outputTokens);
            $usageIds[] = $textGenerationUsage->id;

            $post = Post::create([
                'title' => (string) $data['title'],
                'description' => (string) $data['description'],
                'content' => (string) $data['content'],
                'image_url' => $imageUrl ?? null,
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
     * Generate a cover image using AI and upload it to Cloudinary.
     *
     * Attempts to generate an image using DALL-E with retry logic. If successful,
     * uploads the image (URL or base64) to Cloudinary and returns the secure URL.
     * Tracks AI usage for billing purposes.
     *
     * @param  string  $userPrompt  The prompt to use for image generation
     * @param  array<int>  $usageIds  Array reference to collect AI usage IDs
     * @return string The Cloudinary secure URL of the uploaded image, or empty string on failure
     */
    protected function generateImage(string $userPrompt, array &$usageIds): string
    {
        $maxAttempts = $this->maxAttempts;
        $attempt = 0;

        while ($attempt < $maxAttempts) {
            $attempt++;

            try {
                $response = Prism::image()
                    ->using('openai', $this->imageModel)
                    ->withPrompt(
                        'Hyper-realistic photograph, 
                        soft light, Canon EOS R5 and 50mm f/1.2 lens,
                        detailed textures, extremely sharp realism, shallow depth of field. subject: '.
                            $userPrompt.
                            '. No text. Not too much details or too many items.'
                    )
                    ->withProviderOptions([
                        'size' => '1024x1024',
                        'quality' => 'standard',
                        'style' => 'vivid',
                    ])
                    ->withClientOptions([
                        'timeout' => $this->timeout,
                    ])
                    ->generate();

                $image = $response->firstImage();
                $imageUrl = $image?->url ?? '';

                if ($imageUrl !== '') {
                    $uploadResult = Cloudinary::uploadApi()->upload($imageUrl, [
                        'resource_type' => 'image',
                    ]);
                } else {
                    $fileParam = ($image?->base64 ? ('data:image/webp;base64,'.$image->base64) : null);

                    if ($fileParam === null) {
                        return '';
                    }

                    $uploadResult = Cloudinary::uploadApi()->upload($fileParam, [
                        'resource_type' => 'image',
                    ]);
                }

                $imageGenerationUsage = ai_save_usage($this->userId, 'dall-e-3', 0, 1);
                $usageIds[] = $imageGenerationUsage->id;

                return $uploadResult['secure_url'] ?? '';
            } catch (\Throwable $e) {
                if ($attempt < $maxAttempts) {
                    Log::warning("Image generation failed (attempt {$attempt}/{$maxAttempts}): ".$e->getMessage().' Retrying...');
                    sleep(min($attempt * 2, 4));
                } else {
                    Log::error("Image generation failed after {$maxAttempts} attempts: ".$e->getMessage());
                }
            }
        }

        return '';
    }
}
