<?php

use App\Models\AiUsage;

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
        // Prices are per 1,000,000 tokens in USD
        $pricing = [
            'gpt-4o-mini' => ['in' => (0.4 / 1000000), 'out' => (1.6 / 1000000)],
            'gpt-4.1-mini' => ['in' => (0.4 / 1000000), 'out' => (1.6 / 1000000)],
            'dall-e-3' => ['in' => 0, 'out' => (0.04 / 1)],
            'gpt-4o' => ['in' => (2.5 / 1000000), 'out' => (10 / 1000000)],
        ];

        $costPerToken = $pricing[$model] ?? null;

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
