@push('head')
    <title>Blog - Post Management - {{ config('app.name') }}</title>
    <meta name="description" content="Learn how to create, edit, and manage blog posts in {{ config('app.name') }}.">
@endpush

<x-layouts.docs :breadcrumbs="[
    ['label' => 'Blog', 'url' => route('docs.show', ['topic' => 'blog/index'])],
    ['label' => 'Post Management', 'url' => '#'],
]">

    <h1>Post Management</h1>
    <p>The blog system provides an admin panel for creating, editing, and managing posts. Posts support markdown content, images, and multi-language translations.</p>

    <h2>Creating Posts</h2>
    <p>To create a new post, navigate to <code>/admin/posts/create</code>. You can create posts manually or use AI generation (see <a href="{{ route('docs.show', ['topic' => 'blog/ai-generation']) }}">AI Content Generation</a>).</p>

    <h3>Post Fields</h3>
    <ul>
        <li><strong>Title</strong> - The title of the post. This is required and will be used to generate a unique slug.</li>
        <li><strong>Description</strong> - A summary/teaser of the post.</li>
        <li><strong>Image</strong> - You have two options, you can use Cloudinary to upload an image or you can use a URL of an image. When generating a post with AI, the image will be generated automatically and uploaded to cloudinary.</li>
        <li><strong>Author</strong> - The author of the post.</li>
        <li><strong>Content</strong> - The content of the post. This will be in markdown format.</li>
        <li><strong>Active</strong> - Controls post visibility on public blog. If the post is not active, it will not be visible to the public.</li>
        <li><strong>Promoted</strong> - Featured posts appear prominently on blog index. If the post is promoted, it will be featured on the blog index.</li>
    </ul>

    <h2>Automatic Slug Generation</h2>
    <p>The <code>Post</code> model automatically generates URL-friendly slugs from titles. The generation handles edge cases:</p>

    <pre><code class="language-php">// Automatically called when creating/updating a post
Post::createUniqueSlug(string $title, ?string $language = null, ?string $referenceNumber = null): string
</code></pre>

    <h3>Slug Generation Rules</h3>
    <ul>
        <li>Titles are converted to URL-friendly slugs using <code>Str::slug()</code></li>
        <li>Non-English posts append the language code (e.g., <code>my-post-es</code>)</li>
        <li>If a title doesn't generate a valid slug (e.g., Korean, Chinese), the system:
            <ul>
                <li>First tries to use the English version's slug + language code</li>
                <li>Falls back to a hash-based slug: <code>post-{hash}-{lang}</code></li>
            </ul>
        </li>
        <li>If a slug already exists, a counter is appended (e.g., <code>my-post-1</code>)</li>
    </ul>

    <h2>Reference Numbers</h2>
    <p>Each post automatically receives a unique reference number (format: <code>REF-000001</code>) that groups all translations of the same post. Reference numbers are:</p>
    <ul>
        <li>Auto-generated when creating the first post</li>
        <li>Shared across all translations via the <code>reference_number</code> field</li>
        <li>Used to link related posts in different languages</li>
    </ul>

    <pre><code class="language-php">// Automatically called when creating a post
Post::createUniqueReferenceNumber(): string
</code></pre>

    <h2>Admin Interface</h2>
    
    <h3>Posts Table</h3>
    <p>The <code>PostsTable</code> Livewire component displays all posts with:</p>
    <ul>
        <li>Search functionality (searches title and description)</li>
        <li>Pagination (8 posts per page)</li>
        <li>Delete functionality</li>
        <li>Links to edit pages</li>
    </ul>

    <h3>Edit Form</h3>
    <p>The <code>EditPost</code> Livewire component provides:</p>
    <ul>
        <li>Markdown editor for content</li>
        <li>Image preview</li>
        <li>AI generation integration</li>
        <li>Translation management</li>
    </ul>

    <h2>Public Blog Views</h2>
    
    <h3>Blog Index</h3>
    <p>The public blog index (<code>/blog</code>) displays:</p>
    <ul>
        <li>Most recent promoted post (featured)</li>
        <li>Other promoted posts</li>
        <li>Regular posts (non-promoted)</li>
        <li>All filtered by current locale</li>
    </ul>

    <h3>Post Show Page</h3>
    <p>The post show page (<code>/blog/{slug}</code>) shows:</p>
    <ul>
        <li>Full post content (rendered from Markdown using prose classes)</li>
        <li>Related posts (same language, excluding current)</li>
    </ul>

    <h2>Related Routes</h2>
    <table>
        <thead>
            <tr>
                <th>Method</th>
                <th>Path</th>
                <th>Route name</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody class="font-mono">
            <tr>
                <td><x-badge variant="success">GET</x-badge></td>
                <td>/blog</td>
                <td>blog</td>
                <td>Public blog index</td>
            </tr>
            <tr>
                <td><x-badge variant="success">GET</x-badge></td>
                <td>/blog/{slug}</td>
                <td>posts.show</td>
                <td>Public post view</td>
            </tr>
            <tr>
                <td><x-badge variant="primary">GET</x-badge></td>
                <td>/admin/posts</td>
                <td>admin.posts.index</td>
                <td>Admin posts listing</td>
            </tr>
            <tr>
                <td><x-badge variant="primary">GET</x-badge></td>
                <td>/admin/posts/create</td>
                <td>admin.posts.create</td>
                <td>Create new post</td>
            </tr>
            <tr>
                <td><x-badge variant="primary">GET</x-badge></td>
                <td>/admin/posts/{post}/edit</td>
                <td>admin.posts.edit</td>
                <td>Edit existing post</td>
            </tr>
        </tbody>
    </table>

    <h2>Read Next</h2>
    <ul>
        <li><a href="{{ route('docs.show', ['topic' => 'blog/ai-generation']) }}">AI Content Generation</a> for generating posts with AI</li>
        <li><a href="{{ route('docs.show', ['topic' => 'blog/translations']) }}">Translations</a> for multi-language support</li>
    </ul>

</x-layouts.docs>

