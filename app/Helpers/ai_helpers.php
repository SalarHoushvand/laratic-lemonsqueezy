<?php

use App\Models\AiUsage;

if (! function_exists('ai_model_pricing')) {
    /**
     * OpenAI model pricing lookup.
     *
     * Text models: rates are USD per token (derived from official per-1M-token prices).
     * Image models: set output to the per-image USD cost; pass outputTokens = 1 for one image.
     * Embedding models: input-only; output rate is 0.
     *
     * @return array<string, array{in: float, out: float}>
     */
    function ai_model_pricing(): array
    {
        $perMillion = static fn (float $input, float $output): array => [
            'in' => $input / 1_000_000,
            'out' => $output / 1_000_000,
        ];

        $perImage = static fn (float $cost): array => [
            'in' => 0,
            'out' => $cost,
        ];

        return [
            // GPT-5 family (Standard tier — developers.openai.com/api/docs/pricing)
            'gpt-5.5' => $perMillion(5, 30),
            'gpt-5.5-pro' => $perMillion(30, 180),
            'gpt-5.4' => $perMillion(2.5, 15),
            'gpt-5.4-mini' => $perMillion(0.75, 4.5),
            'gpt-5.4-nano' => $perMillion(0.2, 1.25),
            'gpt-5.4-pro' => $perMillion(30, 180),
            'gpt-5.2' => $perMillion(1.75, 14),
            'gpt-5.2-pro' => $perMillion(21, 168),
            'gpt-5.1' => $perMillion(1.25, 10),
            'gpt-5' => $perMillion(1.25, 10),
            'gpt-5-mini' => $perMillion(0.25, 2),
            'gpt-5-nano' => $perMillion(0.05, 0.4),
            'gpt-5-pro' => $perMillion(15, 120),

            // GPT-4.1 family
            'gpt-4.1' => $perMillion(2, 8),
            'gpt-4.1-mini' => $perMillion(0.4, 1.6),
            'gpt-4.1-nano' => $perMillion(0.1, 0.4),

            // GPT-4o family
            'gpt-4o' => $perMillion(2.5, 10),
            'gpt-4o-2024-05-13' => $perMillion(5, 15),
            'gpt-4o-mini' => $perMillion(0.15, 0.6),

            // o-series reasoning models
            'o1' => $perMillion(15, 60),
            'o1-pro' => $perMillion(150, 600),
            'o1-mini' => $perMillion(1.1, 4.4),
            'o3' => $perMillion(2, 8),
            'o3-pro' => $perMillion(20, 80),
            'o3-mini' => $perMillion(1.1, 4.4),
            'o4-mini' => $perMillion(1.1, 4.4),
            'o3-deep-research' => $perMillion(10, 40),
            'o4-mini-deep-research' => $perMillion(2, 8),

            // Legacy GPT-4 / GPT-3.5
            'gpt-4-turbo-2024-04-09' => $perMillion(10, 30),
            'gpt-4-0125-preview' => $perMillion(10, 30),
            'gpt-4-1106-preview' => $perMillion(10, 30),
            'gpt-4-1106-vision-preview' => $perMillion(10, 30),
            'gpt-4-0613' => $perMillion(30, 60),
            'gpt-4-0314' => $perMillion(30, 60),
            'gpt-4-32k' => $perMillion(60, 120),
            'gpt-3.5-turbo' => $perMillion(0.5, 1.5),
            'gpt-3.5-turbo-0125' => $perMillion(0.5, 1.5),
            'gpt-3.5-turbo-1106' => $perMillion(1, 2),
            'gpt-3.5-turbo-0613' => $perMillion(1.5, 2),
            'gpt-3.5-0301' => $perMillion(1.5, 2),
            'gpt-3.5-turbo-instruct' => $perMillion(1.5, 2),
            'gpt-3.5-turbo-16k-0613' => $perMillion(3, 4),
            'davinci-002' => $perMillion(2, 2),
            'babbage-002' => $perMillion(0.4, 0.4),

            // Embeddings (input tokens only)
            'text-embedding-3-small' => $perMillion(0.02, 0),
            'text-embedding-3-large' => $perMillion(0.13, 0),
            'text-embedding-ada-002' => $perMillion(0.1, 0),

            // Other specialized models
            'computer-use-preview' => $perMillion(3, 12),

            // Image models — per image when outputTokens = 1
            'dall-e-2' => $perImage(0.02),
            'dall-e-3' => $perImage(0.04),
            'dall-e-3-hd' => $perImage(0.08),
            'gpt-image-1' => $perImage(0.042),
            'gpt-image-1-low' => $perImage(0.011),
            'gpt-image-1-high' => $perImage(0.167),
            'gpt-image-1-mini' => $perImage(0.011),
            'gpt-image-1.5' => $perImage(0.042),
            'gpt-image-2' => $perImage(0.006),
        ];
    }
}

if (! function_exists('ai_cost_for_model_tokens')) {
    /**
     * Calculate the cost for AI model token usage.
     *
     * @param  string  $model  The AI model identifier (e.g., 'gpt-4o-mini', 'dall-e-3')
     * @param  int  $promptTokens  Number of input/prompt tokens used
     * @param  int  $outputTokens  Number of output tokens generated
     * @return float The calculated cost in USD, rounded to 4 decimal places. Returns 0.0 for unsupported models.
     */
    function ai_cost_for_model_tokens(string $model, int $promptTokens, int $outputTokens): float
    {
        $costPerToken = ai_model_pricing()[$model] ?? null;

        if (! $costPerToken) {
            return 0.0;
        }

        $inputCost = $promptTokens * $costPerToken['in'];
        $outputCost = $outputTokens * $costPerToken['out'];

        return round($inputCost + $outputCost, 4);
    }
}

if (! function_exists('ai_save_usage')) {
    /**
     * Save AI usage tracking record to the database.
     *
     * @param  int|null  $userId  The user ID associated with the AI usage, or null for system usage
     * @param  string  $model  The AI model identifier used
     * @param  int  $promptTokens  Number of input/prompt tokens used
     * @param  int  $outputTokens  Number of output tokens generated
     * @param  string  $currency  The currency code (defaults to 'USD')
     * @param  array<string, mixed>  $meta  Additional metadata to store with the usage record
     * @return \App\Models\AiUsage The created AiUsage model instance
     */
    function ai_save_usage(?int $userId, string $model, int $promptTokens, int $outputTokens, string $currency = 'USD', array $meta = []): AiUsage
    {
        $totalTokens = $promptTokens + $outputTokens;
        $totalCost = ai_cost_for_model_tokens($model, $promptTokens, $outputTokens);

        return AiUsage::create([
            'user_id' => $userId,
            'model' => $model,
            'prompt_tokens' => $promptTokens,
            'output_tokens' => $outputTokens,
            'total_tokens' => $totalTokens,
            'total_cost' => $totalCost,
            'currency' => $currency,
            'meta' => empty($meta) ? null : $meta,
        ]);
    }
}
