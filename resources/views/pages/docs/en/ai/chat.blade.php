@push('head')
    <title>AI Integration - Chat (Streaming) - {{ config('app.name') }}</title>
    <meta name="description" content="Learn how streaming AI chat works with Livewire and a queued job using the Laravel AI SDK.">
@endpush


<x-layouts.docs :breadcrumbs="[
    ['label' => 'AI Integration', 'url' => route('docs.show', ['topic' => 'ai/index'])],
    ['label' => 'AI Chat with streaming', 'url' => '#'],
]">

    <h1>AI Chat with streaming</h1>
    
    <p>{{ config('app.name') }} provides a nice AI chat implementation with livewire and a background job that can
        stream responses in real-time. Similar to AI agents like Chat GPT, Claude, etc. </p>
    <video src="{{ asset('images/docs/ai-streaming-light.webm') }}" autoplay loop muted playsinline class="w-full rounded-radius border border-outline dark:border-outline-dark  dark:hidden" aria-label="AI Streaming demo"></video>
    <video src="{{ asset('images/docs/ai-streaming-dark.webm') }}" autoplay loop muted playsinline class="w-full rounded-radius border border-outline dark:border-outline-dark hidden dark:block" aria-label="AI Streaming demo"></video>

    <h2>How it works</h2>
    <ol>
        <li>User submits a prompt in the chat interface.</li>
        <li>The Livewire component (<code>App\\Livewire\\AiChat</code>) processes the prompt, creates the message
            history, prepares it for the API, and dispatches the streaming job.</li>
        <li>A background job (<code>App\\Jobs\\StreamAiReply</code>) is created and queued. It sends the request to
            OpenAI using the Laravel AI SDK and saves the response chunks in cache as they arrive.</li>
        <li>The Livewire component polls the cache every 250ms using <code>wire:poll</code> to get the updated buffer,
            enabling real-time streaming in the UI.</li>
        <li>Once generation completes, the AI helper calculates and saves the usage data (tokens, model, user ID) for
            tracking and cost analysis.</li>
    </ol>


    <h2>Setting Up the Queue</h2>
    <p>This implementation uses a background queue to handle AI streaming. The job is dispatched to the <code>ai</code>
        queue, which runs asynchronously.</p>

    <p>To start processing the queue, run:</p>
    <pre><code>php artisan queue:work --queue=ai</code></pre>

    <h2>Changing the AI Model</h2>
    <p>To change the AI model, edit the <code>$model</code> variable in the <code>StreamAiReply</code> job's
        <code>handle()</code> method</p>
    <pre><code class="language-php">$provider = 'openai';
$model = 'gpt-4o-mini'; 
</code></pre>

    <p>Make sure that you have the API key for the provider in your <code>.env</code> file. Update the pricing in
        <code>app/Helpers/ai_helpers.php</code> to match your chosen model for accurate cost tracking.</p>

    <h2>Message History</h2>
    <p>The chat keeps the entire conversation history. Each message in the <code>$messages</code> array is sent to the
        API, so the AI has full context of the conversation.</p>

    <p>The message history is stored in the <code>$this->messages</code> array in the Livewire component. Each time you
        send a message, it's added to this array along with the assistant's response.</p>

    <p>You can use this to store the conversation history in a database or a file.</p>

    <pre><code class="language-php">array (
    0 => 
    array (
    'role' => 'user',
    'content' => 'tell me a joke',
    ),
    1 => 
    array (
    'id' => '01K8KE7GABGJHE2XFVK9GFXDEF',
    'role' => 'assistant',
    'content' => 'Why don\'t skeletons fight each other? 

Because they don\'t have the guts!',
    )
)  
      </code></pre>

    <h2>Stopping the Stream</h2>
    <p>Users can stop streaming at any time by clicking the "Stop" button. This works by setting two cache flags:</p>
    <pre><code class="language-php">Cache::put("ai:cancel:{$this->streamingId}", true, now()->addMinutes(10));
Cache::put("ai:done:{$this->streamingId}", true, now()->addMinutes(10));
</code></pre>

    <p>The job checks for the cancel flag on each chunk and exits early if set. The UI stops polling when the done flag
        is detected.</p>

    <h2>Formatting the AI Response</h2>
    <p>The AI response is rendered using Markdown. The view uses the <code>renderMarkdown()</code> function from
        <code>chat.js</code> which:</p>
    <ul>
        <li>Parses Markdown using the <a href="https://marked.js.org/" target="_blank">Marked Library</a></li>
        <li>Highlights code blocks with <a href="https://highlightjs.org/" target="_blank">highlight.js</a></li>
        <li>Adds copy buttons to code blocks</li>
        <li>Sanitizes the HTML for safety using <a href="https://github.com/cure53/DOMPurify"
                target="_blank">DOMPurify</a></li>
    </ul>



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
                <td>/ai-chat</td>
                <td>ai.chat</td>
            </tr>

        </tbody>
    </table>

    <h2>Next Steps</h2>
    <ul>
        <li>See <a href="{{ route('docs.show', ['topic' => 'ai/usage']) }}">AI Usage</a> for tracking and costs.</li>
    </ul>



</x-layouts.docs>
