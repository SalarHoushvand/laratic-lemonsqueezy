@push('head')
    <title>AI Integration - {{ config('app.name') }}</title>
    <meta name="description" content="Overview of AI integration including installation, setup, and links to features.">
@endpush


<x-layouts.docs :breadcrumbs="[['label' => 'AI Integration', 'url' => '#']]">

    <h1>AI Integration</h1>
    <p>{{ app('config')['app.name'] }} provides some usefull AI integrations to help you get started with implementing
        AI in your application. We are using <a href="https://laravel.com/docs/ai-sdk" target="_blank">Laravel AI SDK</a> to power our AI
        integrations.</p>

    <h2>Requirements</h2>
    <p>To use the AI integrations, ensure the following:</p>
    <ul>
        <li>Laravel AI SDK is installed. Refer to the <a href="https://laravel.com/docs/ai-sdk"
                target="_blank">Laravel AI SDK documentation</a> for details.</li>
        <li>
            OpenAI API key is set in your <code>.env</code> file:
            <pre><code class="language-ini">OPENAI_API_KEY=your-openai-api-key
</code></pre>
        </li>
    </ul>

    <h2>Queue Setup</h2>
    <p>AI operations are resource-intensive and run as background jobs in a queue to avoid blocking the web request. The AI chat and blog generation use the <code>ai</code> queue for streaming responses.</p>
    <p>To start processing the queue, run:</p>
    <pre><code>php artisan queue:work --queue=ai</code></pre>
    <p>For more details on queue configuration for specific features, see the individual feature documentation.</p>

    <h2>Features</h2>
    <ul>
        <li><a href="{{ route('docs.show', ['topic' => 'ai/simple']) }}">Simple AI Integration</a></li>
        <li><a href="{{ route('docs.show', ['topic' => 'ai/chat']) }}">AI Chat with streaming</a></li>
        <li><a href="{{ route('docs.show', ['topic' => 'ai/usage']) }}">AI Usage</a></li>
    </ul>

    <h2>References</h2>
    <table>
        <thead>
            <tr>
                <th>Category</th>
                <th>Path / Name</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><x-badge variant="outline-primary">Routes</x-badge></td>
                <td><strong>GET /ai-simple (ai.simple)</strong></td>
                <td>-</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Routes</x-badge></td>
                <td><strong>GET /ai-chat (ai.chat)</strong></td>
                <td>-</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Controller</x-badge></td>
                <td><strong>AiController</strong></td>
                <td>Returns AI pages. Entry point for AI routes.</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Model</x-badge></td>
                <td><strong>Models\AiUsage</strong></td>
                <td>Model for AI usage tracking and cost calculation.</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Livewire</x-badge></td>
                <td><strong>Livewire\AiSimple</strong></td>
                <td>Controls a simple AI request</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Livewire</x-badge></td>
                <td><strong>Livewire\AiChat</strong></td>
                <td>Controlls AI chat streaming</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Helpers</x-badge></td>
                <td><strong>Helpers/ai_helpers.php</strong></td>
                <td>Helper functions for AI usage tracking and cost calculation.</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Jobs</x-badge></td>
                <td><strong>Jobs/StreamAiReply.php</strong></td>
                <td>Job for streaming AI replies.</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Migrations</x-badge></td>
                <td><strong>create_ai_usages_table</strong></td>
                <td>Migration for AI usage tracking and cost calculation.</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Views</x-badge></td>
                <td><strong>pages/ai-simple.blade.php</strong></td>
                <td>Page used by /ai-simple route.</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Views</x-badge></td>
                <td><strong>pages/ai-chat.blade.php</strong></td>
                <td>Page used by /ai-chat route.</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">JavaScript</x-badge></td>
                <td><strong>js/chat.js</strong></td>
                <td>Some frontend logic + highlight for the chat component.</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Tests</x-badge></td>
                <td><strong>Feature/AiSimpleTest.php</strong></td>
                <td>Tests for the AiSimple component.</td>
            </tr>

        </tbody>
    </table>

</x-layouts.docs>
