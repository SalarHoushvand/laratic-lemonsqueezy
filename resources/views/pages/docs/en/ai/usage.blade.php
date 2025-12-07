@push('head')
    <title>AI Integration - Usage - {{ config('app.name') }}</title>
    <meta name="description"
        content="Understand how token usage and costs are calculated and stored in {{ config('app.name') }}.">
@endpush


<x-layouts.docs :breadcrumbs="[['label' => 'AI Integration', 'url' => route('docs.show', ['topic' => 'ai/index'])], ['label' => 'AI Usage', 'url' => '#']]">

    <h1>AI Usage</h1>
    <p>We track token usage and estimated costs per user and model. This enables analytics, quotas, and billing.</p>
    <img src="{{ asset('images/docs/admin-aiusage-dark.webp') }}" alt="AI Usage" class="hidden dark:block">
    <img src="{{ asset('images/docs/admin-aiusage-light.webp') }}" alt="AI Usage" class="dark:hidden">

    <h2>Helpers</h2>
    <p>Helpers in <code>app/Helpers/ai_helpers.php</code> provide a simple API:</p>

    <pre><code class="language-php">ai_save_usage(?int $userId, string $model, int $promptTokens, int $outputTokens, string $currency = 'USD', array $meta = []): AiUsage
ai_cost_for_model_tokens(string $model, int $promptTokens, int $outputTokens): float
</code></pre>

    <p>You can add your own pricing for models in the <code>ai_cost_for_model_tokens()</code> function.</p>
    <pre><code class="language-php">$pricing = [
    // Prices are per 1,000,000 tokens in USD
    'gpt-4o-mini' => ['in' => (0.4 / 1000000), 'out' => (1.6 / 1000000)],
];
</code></pre>

    <h2>Stored fields</h2>
    <p>We persist a record with:</p>
    <ul>
        <li><code>user_id</code>, <code>model</code>, <code>prompt_tokens</code>, <code>output_tokens</code></li>
        <li><code>total_tokens</code> and computed <code>total_cost</code> in <code>currency</code></li>
        <li>Optional <code>meta</code> JSON for custom attributes</li>
    </ul>

    <h2>Saving usage</h2>
    <pre><code class="language-php">$promptTokens = (int) $response->usage->promptTokens;
$outputTokens = (int) $response->usage->completionTokens;
ai_save_usage(Auth::id(), 'gpt-4o-mini', $promptTokens, $outputTokens);
</code></pre>


</x-layouts.docs>


