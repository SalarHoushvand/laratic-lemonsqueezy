@push('head')
    <title>Blog - SEO - {{ config('app.name') }}</title>
    <meta name="description"
        content="Learn how SEO is automatically optimized for blog posts in {{ config('app.name') }}.">
@endpush

<x-layouts.docs :breadcrumbs="[
    ['label' => 'Blog', 'url' => route('docs.show', ['topic' => 'blog/index'])],
    ['label' => 'SEO', 'url' => '#'],
]">

    <h1>SEO</h1>
    <p>{{ config('app.name') }} automatically optimizes SEO for all blog posts. You don't need to do anything - the system
        generates all necessary meta tags, Open Graph tags, canonical URLs, and structured data (JSON-LD) automatically
        using your post's title, description, image, and other metadata.</p>

    <h2>Automatic SEO Optimization</h2>
    <p>When you create or publish a blog post, the system automatically generates SEO-optimized meta tags and structured
        data. This includes:</p>
    <ul>
        <li><strong>Page Title</strong> - Automatically generated from post title</li>
        <li><strong>Meta Description</strong> - Uses the post's description field</li>
        <li><strong>Open Graph Tags</strong> - For social media sharing (Facebook, Twitter, LinkedIn, etc.)</li>
        <li><strong>Canonical URL</strong> - Prevents duplicate content issues</li>
        <li><strong>JSON-LD Structured Data</strong> - Article schema for search engines</li>
    </ul>

    <h2>How It Works</h2>
    <p>The SEO optimization is handled automatically in the <code>layouts/post.blade.php</code> component. Every time a
        post is displayed, the following SEO elements are generated:</p>

    <h3>Standard Meta Tags</h3>
    <ul>
        <li><code>&lt;title&gt;</code> - Post title with app name</li>
        <li><code>&lt;meta name="description"&gt;</code> - Post description</li>
    </ul>

    <h3>Open Graph Tags</h3>
    <p>Open Graph tags enable rich social media previews when your posts are shared:</p>
    <ul>
        <li><code>og:title</code> - Post title</li>
        <li><code>og:description</code> - Post description</li>
        <li><code>og:type</code> - Set to "article"</li>
        <li><code>og:url</code> - Current post URL</li>
        <li><code>og:image</code> - Post cover image (if available)</li>
        <li><code>og:image:alt</code> - Post title as alt text</li>
    </ul>

    <h3>Canonical URL</h3>
    <p>A canonical link is automatically added to prevent duplicate content issues and help search engines identify the
        preferred version of the page.</p>

    <h3>JSON-LD Structured Data</h3>
    <p>The system generates Article schema markup in JSON-LD format, which helps search engines understand your content
        better. This includes:</p>
    <ul>
        <li>Article headline and description</li>
        <li>Publication and modification dates</li>
        <li>Publisher information (Organization)</li>
        <li>Author information (Person, if specified)</li>
        <li>Featured image (if available)</li>
    </ul>

    <h2>Example Output</h2>
    <p>Here's an example of what gets automatically generated in the HTML <code>&lt;head&gt;</code> section for a blog
        post:</p>

    <pre><code class="language-html">&lt;title&gt;Getting Started with Laravel - {{ config('app.name') }}&lt;/title&gt;
&lt;meta name="description" content="Learn how to get started with Laravel framework and build amazing web applications."&gt;

&lt;!-- Open Graph Tags --&gt;
&lt;meta property="og:title" content="Getting Started with Laravel" /&gt;
&lt;meta property="og:description" content="Learn how to get started with Laravel framework and build amazing web applications." /&gt;
&lt;meta property="og:type" content="article" /&gt;
&lt;meta property="og:url" content="https://example.com/blog/getting-started-with-laravel" /&gt;
&lt;meta property="og:image" content="https://res.cloudinary.com/example/image/upload/v1234567890/post-image.jpg" /&gt;
&lt;meta property="og:image:alt" content="Getting Started with Laravel" /&gt;

&lt;!-- Canonical URL --&gt;
&lt;link rel="canonical" href="https://example.com/blog/getting-started-with-laravel" /&gt;

&lt;!-- JSON-LD Structured Data --&gt;
&lt;script type="application/ld+json"&gt;
{
    "@context": "https://schema.org",
    "@type": "Article",
    "headline": "Getting Started with Laravel",
    "description": "Learn how to get started with Laravel framework and build amazing web applications.",
    "url": "https://example.com/blog/getting-started-with-laravel",
    "datePublished": "2024-01-15T10:30:00+00:00",
    "dateModified": "2024-01-16T14:20:00+00:00",
    "publisher": {
        "@type": "Organization",
        "name": "{{ config('app.name') }}",
        "url": "https://example.com"
    },
    "author": {
        "@type": "Person",
        "name": "John Doe"
    },
    "image": "https://res.cloudinary.com/example/image/upload/v1234567890/post-image.jpg"
}
&lt;/script&gt;</code></pre>

    <h2>Multi-Language Support</h2>
    <p>All SEO meta tags and structured data automatically use translated content when viewing posts in different
        languages. The <code>__()</code> translation helper ensures that title, description, and other fields are
        properly translated based on the current locale.</p>

    <h2>Best Practices</h2>
    <p>While SEO is handled automatically, here are some tips for better results:</p>
    <ul>
        <li><strong>Write Descriptive Titles</strong> - Clear, descriptive titles help both users and search engines
        </li>
        <li><strong>Craft Good Descriptions</strong> - Write 150-160 character descriptions that summarize your post
            effectively</li>
        <li><strong>Use Quality Images</strong> - Add cover images to your posts for better social media sharing</li>
        <li><strong>Set Author Information</strong> - Include author names for better structured data</li>
        <li><strong>Keep Content Updated</strong> - The system tracks modification dates automatically</li>
    </ul>

    <h2>Read Next</h2>
    <ul>
        <li><a href="{{ route('docs.show', ['topic' => 'blog/posts']) }}">Post Management</a> - Learn how to create and
            manage posts</li>
        <li><a href="{{ route('docs.show', ['topic' => 'blog/translations']) }}">Translations</a> - Multi-language post
            support</li>
    </ul>

</x-layouts.docs>

