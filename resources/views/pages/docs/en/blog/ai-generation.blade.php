@push('head')
    <title>Blog - AI Content Generation - {{ config('app.name') }}</title>
    <meta name="description"
        content="Learn how AI-powered post generation works with image creation in {{ config('app.name') }}.">
@endpush

<x-layouts.docs :breadcrumbs="[
    ['label' => 'Blog', 'url' => route('docs.show', ['topic' => 'blog/index'])],
    ['label' => 'AI Content Generation', 'url' => '#'],
]">

    <h1>AI Content Generation</h1>
    <video src="{{ asset('images/docs/admin-post-generation-light.webm') }}" autoplay loop muted playsinline
        class="w-full rounded-radius border border-outline dark:border-outline-dark  dark:hidden"
        aria-label="Admin Post Generation demo"></video>
    <video src="{{ asset('images/docs/admin-post-generation-dark.webm') }}" autoplay loop muted playsinline
        class="w-full rounded-radius border border-outline dark:border-outline-dark hidden dark:block"
        aria-label="Admin Post Generation demo"></video>
    <p>{{ config('app.name') }} includes AI-powered blog post generation that creates complete posts with titles,
        descriptions, content, and cover images. The generation runs in a background queue for better performance.</p>

    <p
        class="text-sm text-on-surface-muted dark:text-on-surface-dark-muted my-6 rounded-radius border border-warning/50 bg-warning/10 p-4 dark:bg-warning/5">
        Before using AI content generation, you need to configure the Laravel AI SDK and have an OpenAI API key set.
        Please see <a href="{{ route('docs.show', ['topic' => 'ai/index']) }}">AI Integration</a> for more details.
    </p>




    <h2>How it Works</h2>
    <ol>
        <li>Live wire components gets the text prompt from the prompt input field</li>
        <li>Live wire components dispatches a <code>GeneratePostWithAi</code> job to the <code>ai</code> queue</li>
        <li>The job will recive the prompt input and adds more details to the prompt to generate a more accurate post
        </li>
        <li>The job generates structured post content (title, description, content) using OpenAI via the Laravel AI SDK</li>
        <li>The job will generate a cover image using DALL-E 3 via the Laravel AI SDK, you can change the model in the job</li>
        <li>The job automatically creates a draft post (unpublished by default) with the generated content and saves it
        </li>
        <li>AI usage is tracked and linked to the created post</li>
        <li>The Livewire component polls for completion every 8 seconds</li>
        <li>Upon completion, the user is automatically redirected to the edit page of the newly created post and the
            Livewire component is updated to show the post details</li>
    </ol>

    <h2>Setting Up the Queue</h2>
    <p>AI generation uses a background queue to handle long-running operations. The job is dispatched to the
        <code>ai</code> queue, which runs asynchronously.
    </p>

    <p>To start processing the queue, run:</p>
    <pre><code>php artisan queue:work --queue=ai</code></pre>

    <h2>Generating Posts</h2>
    <p>In the admin post creation form, click the floating AI orb button to open the AI prompt interface. All you need
        to do is enter a prompt and click the generate button.</p>



    <p>The system uses the Laravel AI SDK's structured output feature via <code>BlogPostAgent</code> to generate well-formed blog posts:</p>

    <pre><code class="language-php">$response = (new BlogPostAgent)->prompt(
    $fullPrompt,
    provider: Lab::OpenAI,
    model: $this->model,
    timeout: $this->timeout
);

$title   = $response['title'];
$description = $response['description'];
$content = $response['content'];</code></pre>


    <h2>Image Generation</h2>
    <p
        class="text-sm text-on-surface-muted dark:text-on-surface-dark-muted my-6 rounded-radius border border-warning/50 bg-warning/10 p-4 dark:bg-warning/5">
        You need to setup cloudinary to save the generated images. Please see <a
            href="{{ route('docs.show', ['topic' => 'cloudinary/index']) }}">Cloudinary</a> for more details.
    </p>

    <p>The system automatically generates cover images using DALL-E 3. The generation process:</p>
    <ul>
        <li>Creates a hyper-realistic image based on the post topic</li>
        <pre><code class="language-php">$imageResponse = Image::of($userPrompt)
    ->square()
    ->quality('medium')
    ->timeout($this->timeout)
    ->generate(provider: Lab::OpenAI, model: 'dall-e-3');

$generatedImage = $imageResponse->firstImage();
$dataUri = 'data:' . $generatedImage->mime() . ';base64,' . $generatedImage->image;
        </code></pre>
        <li>Uploads the generated image to Cloudinary for hosting</li>
        <pre><code class="language-php">  $uploadResult = Cloudinary::uploadApi()->upload($imageUrl, [
    'resource_type' => 'image',
]);
</code></pre>
        <li>Retries up to 3 times (you can change this in the job) if the image generation fails</li>
        <li>Tracks image generation usage separately. You can define the pricing in the ai helpers function</li>
        <pre><code class="language-php">$pricing = [
            // Prices are per 1,000,000 tokens in USD
            'gpt-4o-mini' => ['in' => (0.4 / 1000000), 'out' => (1.6 / 1000000)],
            'gpt-4.1-mini' => ['in' => (0.4 / 1000000), 'out' => (1.6 / 1000000)],
            'dall-e-3' => ['in' => 0, 'out' => (0.04 / 1)],
        ];
        </code></pre>
    </ul>





    <h2>Cache-Based Communication</h2>
    <p>The system uses Laravel's cache to communicate between the background job and the Livewire component. When
        generation starts, a unique request ID is created and the job writes status updates to cache keys:</p>
    <ul>
        <li><strong><code>post_ai:{requestId}:done</code></strong> - Set to <code>true</code> when generation completes
        </li>
        <li><strong><code>post_ai:{requestId}:result</code></strong> - Contains <code>post_id</code> on success</li>
        <li><strong><code>post_ai:{requestId}:error</code></strong> - Contains error message on failure</li>
    </ul>

    <p>The Livewire component polls these cache keys every 8 seconds using <code>wire:poll.8s</code>. When
        <code>done</code> is detected, it reads the result or error, shows a notification, and redirects to the edit
        page. All cache entries expire after 20 minutes.</p>

    <p>You can clear these cache entries manually using:</p>
    <pre><code>php artisan cache:clear</code></pre>

    <h2>Usage Tracking</h2>
    <p>AI generation automatically tracks usage:</p>
    <ul>
        <li>Text generation tokens (prompt + output)</li>
        <li>Image generation (counted as 1 image generation)</li>
        <li>Linked to the created post via <code>ai_usage_post</code> pivot table</li>
        <li>Stored in <code>ai_usages</code> table with cost calculation</li>
    </ul>


    <h2>Read Next</h2>
    <ul>
        <li><a href="{{ route('docs.show', ['topic' => 'ai/index']) }}">AI Overview</a> to configure the AI integration
        </li>
        <li><a href="{{ route('docs.show', ['topic' => 'blog/translations']) }}">Translations</a> for AI-powered post
            translation</li>
        <li><a href="{{ route('docs.show', ['topic' => 'blog/posts']) }}">Post Management</a> for manual post creation
        </li>
    </ul>

</x-layouts.docs>
