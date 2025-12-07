@push('head')
    <title>AI Integration - Simple - {{ config('app.name') }}</title>
    <meta name="description"
        content="Learn how to call an AI model using Prism and capture token usage in {{ config('app.name') }}.">
@endpush

<x-layouts.docs :breadcrumbs="[
    ['label' => 'AI Integration', 'url' => route('docs.show', ['topic' => 'ai/index'])],
    ['label' => 'Simple AI Integration', 'url' => '#'],
]">

    <h1>Simple AI Integration</h1>
    <p>We have provided a simple example of how to use the AI integration in your application. This example is a simple
        text generation request to the OpenAI API. </p>
    <p>It's a <strong>Livewire</strong> component that will send a request to the OpenAI API and dump the response to
        the browser.</p>

    <h2>Response Handling</h2>
    <p>The component will send a request to the OpenAI API and dump the response to the browser using Prism's provided
        methods. </p>
    <p>You can use system prompts to guide the AI model to behave in a certain way. For example, you can use a system
        prompt to tell the AI model to <i>behave like a Laravel developer who explains concepts simply</i>.</p>

    <pre><code class="language-php">$response = Prism::text()
    ->using('openai', $this->model)
    // Adjust this as needed to guide the AI model to behave in a certain way.
    ->withSystemPrompt('You are an expert Laravel developer who explains concepts simply.')
    ->withPrompt($this->prompt)
    ->asText();
</code></pre>


    <h2>Usage Tracking</h2>
    <p>Token usage is stored using helpers in <code>app/Helpers/ai_helpers.php</code> and the <code>AiUsage</code>
        model (Learn more about <a href="{{ route('docs.show', ['topic' => 'ai/usage']) }}">AI Usage</a>):</p>

    <pre><code class="language-php">ai_save_usage($userId, $model, $promptTokens, $outputTokens);
// Calculates cost with ai_cost_for_model_tokens() and stores a row in ai_usages
</code></pre>

    <h2>Related Routes</h2>
    <table>
        <thead>
            <tr>
                <th>Method</th>
                <th>Path</th>
                <th>Route name</th>
            </tr>
        </thead>
        <tbody class="font-mono">
            <tr>
                <td><x-badge variant="success">GET</x-badge></td>
                <td>/ai-simple</td>
                <td>ai.simple</td>
            </tr>

        </tbody>
    </table>

    <h2>Read Next</h2>
    <ul>
        <li><a href="{{ route('docs.show', ['topic' => 'ai/chat']) }}">AI Chat with streaming</a> for streamed
            responses.</li>
        <li><a href="{{ route('docs.show', ['topic' => 'ai/usage']) }}">AI Usage</a> for cost and reporting
            details.</li>
    </ul>

</x-layouts.docs>
