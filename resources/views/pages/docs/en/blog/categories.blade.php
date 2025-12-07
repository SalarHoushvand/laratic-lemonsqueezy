@push('head')
    <title>Blog - Categories - {{ config('app.name') }}</title>
    <meta name="description" content="Learn how to create and manage blog post categories in {{ config('app.name') }}.">
@endpush

<x-layouts.docs :breadcrumbs="[
    ['label' => 'Blog', 'url' => route('docs.show', ['topic' => 'blog/index'])],
    ['label' => 'Categories', 'url' => '#'],
]">

    <h1>Categories</h1>
    <p>Categories help you organize your blog posts into groups (e.g. <em>Laravel</em>, <em>News</em>,
        <em>Tutorials</em>). They use the <code>spatie/laravel-tags</code> package and support
        translations so each language can have its own name.</p>

    <p class="text-sm text-on-surface-muted dark:text-on-surface-dark-muted my-6 rounded-radius border border-warning/50 bg-warning/10 p-4 dark:bg-warning/5">
        When creating a new post, <strong>create the post first, then assign categories to it</strong>.
    </p>

    <h2>Creating & Editing Categories</h2>
    <p>You can create and edit categories from the <code>ManageCategories</code> modal.</p>
    <ul>
        <li>Create a new category by filling in at least the English name and clicking <strong>Save</strong>.</li>
        <li>Edit existing categories – simply select one from the list, adjust the translations and save.</li>
        <li>Delete a category (only if it is no longer needed). Deleting will also remove the relationship from all
            posts.</li>
    </ul>

    <p class="text-sm text-on-surface-muted dark:text-on-surface-dark-muted my-6 rounded-radius border border-warning/50 bg-warning/10 p-4 dark:bg-warning/5">
        Deleting a category will also remove that category and all its translations from all posts.
    </p>

    <h2>Assigning and Unassigning Categories to a Post</h2>
    <ul>
        <li>You can easily assign categories to a post by using the <strong>Categories</strong> multiselect field.</li>
        <li>When you assign or unassign a category, the changes are <strong>saved automatically.</strong></li>
    </ul>


    <h3>Translations</h3>
    <p>Each category can have a name for each available language (configured in <code>config/languages.php</code>).
        By default, when you create a new category, it will have the same English name in all languages. You can edit the
        translations later.
    </p>

    <p>When editing a post, category names will be displayed in the post's language (if that
        translation exists for the category).
    </p>



    <h2>Read Next</h2>
    <ul>
        <li><a href="{{ route('docs.show', ['topic' => 'blog/posts']) }}">Post Management</a> – Creating & editing posts
        </li>
        <li><a href="{{ route('docs.show', ['topic' => 'blog/translations']) }}">Translations</a> – Multi-language
            support</li>
    </ul>

</x-layouts.docs>
