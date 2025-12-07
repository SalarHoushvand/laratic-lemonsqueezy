@push('head')
    <title>Blog - {{ config('app.name') }}</title>
    <meta name="description" content="Overview of the blog system including post management, AI generation, translations, and multi-language support.">
@endpush


<x-layouts.docs :breadcrumbs="[['label' => 'Blog', 'url' => '#']]">

    <h1>Blog</h1>
    <p>{{ config('app.name') }} includes a comprehensive blog system with AI-powered content generation, AI-powered translations, multi-language support, and flexible post management.</p>
    <img src="{{ asset('images/docs/blog-en-dark.webp') }}" alt="Blog Index" class="hidden dark:block">
    <img src="{{ asset('images/docs/blog-inendex-light.webp') }}" alt="Blog Index" class="dark:hidden">

    <h2>Features</h2>
    <ul>
        <li><a href="{{ route('docs.show', ['topic' => 'blog/posts']) }}">Post Management</a> - Create, edit, and manage blog posts</li>
        <li><a href="{{ route('docs.show', ['topic' => 'blog/ai-generation']) }}">AI Content Generation</a> - Generate posts using AI with image generation</li>
        <li><a href="{{ route('docs.show', ['topic' => 'blog/translations']) }}">Translations</a> - Multi-language post support with AI translation</li>
        <li><a href="{{ route('docs.show', ['topic' => 'blog/categories']) }}">Categories</a> - Organize posts with multi-language category support</li>
        <li><a href="{{ route('docs.show', ['topic' => 'blog/seo']) }}">SEO</a> - Automatic SEO optimization for blog posts</li>
        <li><a href="{{ route('docs.show', ['topic' => 'blog/faq']) }}">FAQ</a> - Frequently asked questions about the blog system</li>
    </ul>

    <h2>Core Concepts</h2>
    
    <h3>Reference Numbers</h3>
    <p>Each post has a unique reference number (format: <code>REF-000001</code>) that groups all translations of the same post together. This allows the system to maintain relationships between posts in different languages.</p>

    <h3>Slugs</h3>
    <p>Posts automatically generate URL-friendly slugs from their titles. For non-English posts, the language code is appended to ensure unique slugs across languages. If a title doesn't generate a valid slug (e.g., non-Latin characters), the system uses a hash-based fallback.</p>

    <h3>Languages</h3>
    <p>The blog supports multiple languages configured in <code>config/languages.php</code>. Each post can have translations that share the same reference number but use different language codes.</p>

    <h3>Post States</h3>
    <ul>
        <li><strong>Active/Inactive</strong> - Controls post visibility on the public blog</li>
        <li><strong>Promoted</strong> - Featured posts appear prominently on the blog index</li>
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
                <td><strong>GET /blog (blog)</strong></td>
                <td>Public blog index page</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Routes</x-badge></td>
                <td><strong>GET /blog/{slug} (posts.show)</strong></td>
                <td>Public blog post view</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Routes</x-badge></td>
                <td><strong>GET /admin/posts (admin.posts.index)</strong></td>
                <td>Admin posts management page</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Routes</x-badge></td>
                <td><strong>GET /admin/posts/create (admin.posts.create)</strong></td>
                <td>Create new post page</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Routes</x-badge></td>
                <td><strong>GET /admin/posts/{post}/edit (admin.posts.edit)</strong></td>
                <td>Edit post page</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Controller</x-badge></td>
                <td><strong>PostController</strong></td>
                <td>Handles public blog viewing (index and show)</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Controller</x-badge></td>
                <td><strong>Admin\PostController</strong></td>
                <td>Handles admin post management pages</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Model</x-badge></td>
                <td><strong>Models\Post</strong></td>
                <td>Post model with automatic slug and reference number generation</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Livewire</x-badge></td>
                <td><strong>Forms\Admin\EditPost</strong></td>
                <td>Post editing form with AI generation and translation support</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Livewire</x-badge></td>
                <td><strong>Admin\Posts\PostsTable</strong></td>
                <td>Admin posts listing table with search</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Livewire</x-badge></td>
                <td><strong>Admin\Posts\PublishPostBanner</strong></td>
                <td>Banner component for unpublished posts in admin</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Livewire</x-badge></td>
                <td><strong>Admin\Posts\ManageCategories</strong></td>
                <td>Modal component for creating and editing categories with translations</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Livewire</x-badge></td>
                <td><strong>Admin\Posts\CategoriesSelect</strong></td>
                <td>Multiselect component for assigning categories to posts</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Jobs</x-badge></td>
                <td><strong>Jobs\GeneratePostWithAi</strong></td>
                <td>Queued job for AI-powered post generation with image creation</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Jobs</x-badge></td>
                <td><strong>Jobs\TranslatePostWithAi</strong></td>
                <td>Queued job for AI-powered post translation</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Migrations</x-badge></td>
                <td><strong>create_posts_table</strong></td>
                <td>Migration for posts table with reference_number, slug, language, etc.</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Migrations</x-badge></td>
                <td><strong>create_ai_usage_post_table</strong></td>
                <td>Pivot table linking posts to AI usage records</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Migrations</x-badge></td>
                <td><strong>create_tag_tables</strong></td>
                <td>Migration for tags/categories tables using spatie/laravel-tags package</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Views</x-badge></td>
                <td><strong>pages/blog/index.blade.php</strong></td>
                <td>Public blog listing page</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Views</x-badge></td>
                <td><strong>pages/blog/show.blade.php</strong></td>
                <td>Public blog post detail page</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Views</x-badge></td>
                <td><strong>pages/admin/posts/index.blade.php</strong></td>
                <td>Admin posts management page</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Views</x-badge></td>
                <td><strong>pages/admin/posts/edit.blade.php</strong></td>
                <td>Admin post edit/create page</td>
            </tr>
        </tbody>
    </table>

</x-layouts.docs>

