<?php

namespace Database\Seeders;

use App\Models\AiUsage;
use App\Models\User;
use Illuminate\Database\Seeder;

class AiUsageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(int $minRecordsPerUser = 5, int $maxRecordsPerUser = 25): void
    {
        $userCount = User::count();
        $models = ['dall-e-3', 'gpt-4o', 'gpt-4o-mini', 'gpt-4.1-mini'];

        $totalRecords = 0;
        $chunkSize = 500;
        $recordsBuffer = [];
        $userChunkSize = 100;

        // Process users in chunks to avoid memory issues
        User::chunk($userChunkSize, function ($users) use (
            &$totalRecords,
            &$recordsBuffer,
            $chunkSize,
            $minRecordsPerUser,
            $maxRecordsPerUser,
            $models
        ) {
            foreach ($users as $user) {
                $recordCount = rand($minRecordsPerUser, $maxRecordsPerUser);

                for ($i = 0; $i < $recordCount; $i++) {
                    $model = $models[array_rand($models)];
                    $createdAt = now()->subDays(rand(0, 480));

                    if ($model === 'dall-e-3') {
                        // DALL-E 3 is per image, not per token
                        $promptTokens = 1;
                        $outputTokens = 1; // 1 image generated
                        $totalTokens = $promptTokens;
                    } else {
                        $promptTokens = rand(100, 500);
                        $outputTokens = rand(50, 200);
                        $totalTokens = $promptTokens + $outputTokens;
                    }

                    // Use the helper function to calculate cost with correct pricing
                    $totalCost = ai_cost_for_model_tokens($model, $promptTokens, $outputTokens);

                    $recordsBuffer[] = [
                        'user_id' => $user->id,
                        'model' => $model,
                        'prompt_tokens' => $promptTokens,
                        'output_tokens' => $outputTokens,
                        'total_tokens' => $totalTokens,
                        'total_cost' => round($totalCost, 4),
                        'currency' => 'USD',
                        'meta' => json_encode([
                            'feature' => collect(['blog_post_generation', 'image_generation', 'text_completion', 'translation'])->random(),
                            'status' => 'completed',
                        ]),
                        'created_at' => $createdAt,
                        'updated_at' => $createdAt,
                    ];

                    $totalRecords++;

                    if (count($recordsBuffer) >= $chunkSize) {
                        AiUsage::insert($recordsBuffer);
                        $recordsBuffer = [];
                        $this->command->info("Created $totalRecords AI usage records...");
                    }
                }
            }

            // Flush buffer at end of each user chunk
            if (! empty($recordsBuffer)) {
                AiUsage::insert($recordsBuffer);
                $recordsBuffer = [];
            }
        });

        $this->command->info("Total AI usage records created: $totalRecords");
    }
}
