@push('head')
    <title>Blog - Translations - {{ config('app.name') }}</title>
    <meta name="description"
        content="Learn how multi-language post translations work with AI translation in {{ config('app.name') }}.">
@endpush

<x-layouts.docs :breadcrumbs="[
    ['label' => 'Blog', 'url' => route('docs.show', ['topic' => 'blog/index'])],
    ['label' => 'Translations', 'url' => '#'],
]">

    <h1>Translations</h1>

    <video autoplay loop muted playsinline preload="none"
        class="w-full rounded-radius border border-outline dark:border-outline-dark dark:hidden"
        aria-label="AI Translation demo (light)">
        <source src="{{ asset('images/docs/ai-translation-light.webm') }}" type="video/webm">
    </video>
    <video autoplay loop muted playsinline preload="none"
        class="w-full rounded-radius border border-outline dark:border-outline-dark hidden dark:block"
        aria-label="AI Translation demo (dark)">
        <source src="{{ asset('images/docs/ai-translation-dark.webm') }}" type="video/webm">
    </video>

    <p>{{ config('app.name') }} supports multi-language blog posts through a translation system. Posts can be translated
        using AI or created manually. All translations of the same post share a common reference number.</p>
    <h2>How Translations Work</h2>

    <h3>Reference Number System</h3>
    <p>Each English post gets a unique reference number (e.g., <code>REF-000001</code>) upon creation, when you create a
        translation for the post, the translation will have the same reference number. This allows the system to
        maintain relationships between posts in different languages.</p>


    <h3>Language Configuration</h3>
    <p>Supported languages are configured in <code>config/languages.php</code>. The default languages are English and
        Spanish. You can add more languages to the configuration file. Each language has a code, name, local name, and
        flag. We are using flags from <a href="https://flagcdn.com/" target="_blank">Flag CDN</a> to display the
        language
        flag in the UI.</p>
    <ul>
        <li>Language code (e.g., <code>en</code>, <code>es</code>)</li>
        <li>Language name</li>
        <li>Flag emoji or icon</li>
    </ul>

    <pre><code class="language-php">return [
    'en' => [
        'code' => 'en',
        'name' => 'English',
        'local_name' => 'English',
        'flag' => 'gb',
    ],
    'es' => [
        'code' => 'es',
        'name' => 'Spanish',
        'local_name' => 'Español',
        'flag' => 'es',
    ],
];</code></pre>

    <h2>Creating Translations</h2>
    <p>To create a translation for an existing post, navigate to the post editor and use the translations tab. The
        process involves:</p>
    <ol>
        <li>Go to the translations tab in the post editor</li>
        <li>Select the target language from the available languages (languages that don't already have translations for
            this post)</li>
        <li>Choose between manual translation or AI-powered translation</li>
        <li>You are redirected to edit the newly created translation and the Livewire component is updated to show the
            translation details</li>
        <li>The translated post shares the same cover image and is created as inactive (unpublished) by default</li>
    </ol>

    <h2>Manual Translation</h2>
    <p>Manual translation allows you to manually create a new post with the same reference number and cover image as the
        original but with the target language:</p>
    <ol>
        <li>Select a target language in the post editor's translations tab</li>
        <li>Click "Create Manual Translation"</li>
        <li>A new draft post is created with the same reference number and cover image as the original but with the
            target language and empty title, description, and content fields</li>
        <li>You manually fill in the translated title, description, and content</li>
        <li>The post is created as inactive (unpublished) by default, remember to publish and save once you are done
            editing.</li>
        <li>You are redirected to edit the newly created translation.</li>
    </ol>

    <h2>AI Translation</h2>
    <p>The system can automatically translate posts using AI. Translation preserves formatting, structure, and tone
        while adapting content to the target language.</p>

    <h2>AI Translation Process</h2>
    <ol>
        <li>User selects target language in the post editor</li>
        <li>The <code>EditPost</code> component dispatches a <code>TranslatePostWithAi</code> job</li>
        <li>The job translates title, description, and content using OpenAI</li>
        <li>The translation will use the same cover image as the original post</li>
        <li>A new post is created with the same reference number but different language</li>
        <li>AI usage is tracked and linked to the translated post</li>
        <li>The translated post is created as inactive (unpublished) by default</li>
        <li>User is redirected to edit the translated post</li>
    </ol>

    <p>The process is similar to the AI content generation process, but instead of generating a new post, it will
        translate the existing post. Please see <a href="{{ route('docs.show', ['topic' => 'blog/ai-generation']) }}">AI
            Content Generation</a> for more details.</p>

    <h2>Translation Management</h2>

    <h2>Slug Generation for Translations</h2>
    <p>Translations automatically generate slugs using the following logic:</p>
    <ul>
        <li>First, attempt to generate a slug from the translation's title using <code>Str::slug()</code></li>
        <li>If the title cannot generate a valid slug (e.g., Korean, Chinese, Japanese characters), and a reference
            number exists, the system will use the English version's slug from the same reference number</li>
        <li>If the slug already exists for another post, a counter is appended to make it unique (e.g.,
            <code>my-post</code> becomes <code>my-post-1</code>, <code>my-post-2</code>, etc.)
        </li>
    </ul>
    <p><strong>Manual Slug Editing:</strong> You can manually set or edit the slug for any post, including translations,
        in the post editor. The slug field is available in the sidebar when editing a post. Manually set slugs will not
        be overridden by automatic generation when you update the post title, allowing you full control over your post
        URLs.</p>



    <h2>Public Blog Display</h2>
    <p>The public blog automatically displays (PUBLISHED) posts in the user's current locale, this can be set using the
        language
        switcher in the header.</p>


    <h2>Read Next</h2>
    <ul>
        <li><a href="{{ route('docs.show', ['topic' => 'blog/ai-generation']) }}">AI Content Generation</a> for creating
            posts with AI</li>
        <li><a href="{{ route('docs.show', ['topic' => 'blog/posts']) }}">Post Management</a> for creating posts
            manually
        </li>
    </ul>

</x-layouts.docs>
