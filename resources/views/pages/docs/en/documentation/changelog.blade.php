@push('head')
    <title>Docs - Changelog - {{ config('app.name') }}</title>
    <meta name="description"
        content="Learn how Laratic makes it easy to add a clean, readable changelog to your docs.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'Documentation', 'url' => '#'], ['label' => 'Changelog', 'url' => '#']]">

    <h1>Changelog</h1>
    <p class="text-on-surface-muted dark:text-on-surface-dark-muted">
        {{ config('app.name') }} includes a ready-made changelog page so you can quickly show what’s new, what changed,
        and what was fixed in each release.
    </p>

    <p>
        The main changelog file lives at  
        <code>resources/views/pages/docs/en/changelog.blade.php</code>.  
        Just add new sections whenever you ship a new update.
    </p>

    <h2>How to Add a New Release</h2>
    <p>Adding a new release is straightforward:</p>
    <ol>
        <li>Open <code>resources/views/pages/docs/en/changelog.blade.php</code>.</li>
        <li>Copy an existing <code>&lt;x-blocks.docs.changelog-section /&gt;</code> block.</li>
        <li>Update the <code>title</code>, <code>version</code>, optional <code>github</code> link, and the items inside each slot. 
            You can add as many items as you want to each slot. They don't have to be a list of items, you can add anything you want.</li>
    </ol>

    <p>Example:</p>

    <pre><code class="language-html">&lt;x-blocks.docs.changelog-section
    :title=&quot;now()-&gt;format('F j, Y')&quot;
    version=&quot;1.3.0&quot;
    github=&quot;https://github.com/your-org/your-repo/releases/tag/v1.3.0&quot;&gt;

    &lt;x-slot:new&gt;
        &lt;ul class=&quot;space-y-1.5 text-sm&quot;&gt;
            &lt;li&gt;Added AI-powered documentation search&lt;/li&gt;
            &lt;li&gt;Improved admin dashboard widgets&lt;/li&gt;
        &lt;/ul&gt;
    &lt;/x-slot:new&gt;

    &lt;x-slot:changed&gt;
        &lt;ul class=&quot;space-y-1.5 text-sm&quot;&gt;
            &lt;li&gt;Updated typography in docs layout&lt;/li&gt;
        &lt;/ul&gt;
        &lt;img src=&quot;/images/admin-dashboard-dark.webp&quot; alt=&quot;Admin Dashboard&quot; class=&quot;w-full&quot; /&gt;
    &lt;/x-slot:changed&gt;

    &lt;x-slot:fixed&gt;
        &lt;ul class=&quot;space-y-1.5 text-sm&quot;&gt;
            &lt;li&gt;Fixed dark mode persistence issue&lt;/li&gt;
        &lt;/ul&gt;
    &lt;/x-slot:fixed&gt;

&lt;/x-blocks.docs.changelog-section&gt;</code></pre>

    <p>
        Since everything runs through a shared component, all release entries stay consistent—spacing, colors, and
        structure are handled automatically.
    </p>

</x-layouts.docs>
