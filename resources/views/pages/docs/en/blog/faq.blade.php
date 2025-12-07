@push('head')
    <title>Blog - FAQ - {{ config('app.name') }}</title>
    <meta name="description" content="Frequently asked questions about the blog system in {{ config('app.name') }}.">
@endpush

<x-layouts.docs :breadcrumbs="[
    ['label' => 'Blog', 'url' => route('docs.show', ['topic' => 'blog/index'])],
    ['label' => 'FAQ', 'url' => '#'],
]">

    <h1>FAQ</h1>
    <p>Common questions about the blog system and how it works.</p>

    <h2>General</h2>

    <h3>How do I create a new blog post?</h3>
    <p>Go to the admin panel and click "Create Post" from the sidebar. Fill in the title, description, and content. You can also use AI to generate the content automatically. Once you're done, make sure to set the post as "Published" and click "Save" to publish it.</p>


    <h2>Categories</h2>

    <h3>When generating or translating a posts with AI, would it create categories for it?</h3>
    <p>No, you need to manually add the categories to the post, AI will only generate or translate the title, description, cover image and the content of the post.</p>

    <h3>What happens if I delete a category?</h3>
    <p>Deleting a category removes it from all posts including the translations that were using it. This action cannot be undone, so make sure you really want to delete it before confirming.</p>

    <h3>Do categories support multiple languages?</h3>
    <p>Yes, each category can have a different name for each language. When you create a category, it starts with the same English name in all languages. You can edit the translations later to customize the name for each language.</p>

    <h2>Translations</h2>

    <h3>Can I use AI to translate my posts?</h3>
    <p>Yes, the system can automatically translate posts using AI. The AI preserves the formatting and structure while adapting the content to the target language. You can always edit the translation after it's generated.</p>

    <h3>Do translations share the same cover image?</h3>
    <p>Yes, all translations of the same post share the same cover image. This keeps the visual consistency across languages.</p>

    <h3>How many languages can I translate a post to?</h3>
    <p>You can translate a post to any language that's configured in <code>config/languages.php</code>. There's no limit on the number of translations you can create.</p>

    <h2>AI Generation</h2>

    <h3>How does AI content generation work?</h3>
    <p>When you use AI to generate a post, the system creates the title, description, and content based on your prompt. It can also generate a cover image automatically. The generation happens in the background, so you can continue working while it processes.</p>

    <h3>Can I edit AI-generated content?</h3>
    <p>Absolutely. AI-generated content is just a starting point. You can edit, refine, or completely rewrite any part of it to match your needs.</p>

    <h3>What models are used for the AI generation and translation?</h3>
    <p>The short answer is any model that you want, but make sure that you have the API access first. As default Laratic is using opan ai models to generate conetne.</p>

    <h2>SEO</h2>

    <h3>How does SEO work for blog posts?</h3>
    <p>The system automatically generates SEO-friendly meta descriptions and handles URL slugs. Posts also get automatic Open Graph tags for better social media sharing. You can customize the SEO settings for each post in the editor.</p>

    <h3>Can I customize the URL slug?</h3>
    <p>Slugs are automatically generated from the post title, but you can edit them manually in the post editor. Make sure the slug is unique and URL-friendly.</p>

    <h2>Post Visibility</h2>

    <h3>I just created a post, but I don't see it in the blog.</h3>
    <p>When you create a post either manually or with the help of AI, you need to publish it to make it publicly available.</p>

    <h3>What does "Promoted" mean?</h3>
    <p>Promoted posts appear prominently on the blog index page, usually at the top. This is useful for highlighting important or featured content.</p>


</x-layouts.docs>

