<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Laravel\Ai\Enums\Lab;
use Livewire\Component;

use function Laravel\Ai\agent;

class AiSimple extends Component
{
    public string $prompt = 'Say hello to Laravel developer in 5 words.';

    public string $model = 'gpt-4o-mini';

    public function tryRequest(): void
    {
        try {
            $response = agent(
                instructions: 'You are an expert Laravel developer who explains concepts simply.',
            )->prompt($this->prompt, provider: Lab::OpenAI, model: $this->model);

            $promptTokens = (int) $response->usage->promptTokens;
            $outputTokens = (int) $response->usage->completionTokens;

            ai_save_usage(Auth::id(), $this->model, $promptTokens, $outputTokens);

            dd($response);
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function render()
    {
        return view('livewire.ai-simple');
    }
}
