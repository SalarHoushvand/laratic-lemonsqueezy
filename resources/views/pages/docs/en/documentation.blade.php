@push('head')
    <title>Documentation System - {{ config('app.name') }}</title>
    <meta name="description"
        content="Learn how the documentation system works in {{ config('app.name') }}, including layout, breadcrumbs, search, changelog, and translations.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'Basics', 'url' => '#'], ['label' => 'Documentation System', 'url' => '#']]">

    <h1>Documentation System</h1>
    <p class="text-on-surface-muted dark:text-on-surface-dark-muted">
        {{ config('app.name') }} ships with a full documentation system powered by Blade, a reusable docs layout, a
        searchable sidebar, and a versioned changelog. This page explains how everything fits together so you can extend
        the docs with your own topics.
    </p>

    <h2>Docs Layout &amp; Breadcrumbs</h2>
    <p>
        All documentation pages use the shared <code>&lt;x-layouts.docs /&gt;</code> layout. This layout renders the docs
        sidebar, the top navbar (including breadcrumbs and search), and the main content area styled with prose
        typography.
    </p>
    <p>
        To create a new documentation page, place a Blade file in
        <code>resources/views/pages/docs/en</code> and wrap its content with the docs layout:
    </p>

    <pre><code class="language-php">@push('head')
    &lt;title&gt;My Topic - {{ config('app.name') }}&lt;/title&gt;
    &lt;meta name=&quot;description&quot; content=&quot;Short description of this topic.&quot;&gt;
@endpush

&lt;x-layouts.docs :breadcrumbs=&quot;[['label' =&gt; 'Basics', 'url' =&gt; '#'], ['label' =&gt; 'My Topic', 'url' =&gt; '#']]&quot;&gt;
    &lt;h1&gt;My Topic&lt;/h1&gt;
    &lt;p&gt;Page content goes here...&lt;/p&gt;
&lt;/x-layouts.docs&gt;</code></pre>

    <p>
        The <code>$breadcrumbs</code> prop is passed into the docs layout and forwarded to the top navbar via
        <code>&lt;x-blocks.docs.top-navbar /&gt;</code>. You can customize the breadcrumb trail per page by adjusting the
        array passed to <code>:breadcrumbs</code>.
    </p>

    <h2>Docs Search</h2>
    <p>
        The documentation includes a lightweight client-side search powered by the
        <code>resources/views/components/blocks/docs/search.blade.php</code> component. This component renders the search
        input and builds a small index of all links inside the docs sidebar.
    </p>

    <p>Key details about the search behavior:</p>
    <ul>
        <li><strong>Index source</strong> &mdash; The script scans the sidebar navigation
            (<code>nav[aria-label=&quot;sidebar navigation&quot;]</code>) and collects all links under <code>/docs/</code>.
        </li>
        <li><strong>Search index</strong> &mdash; Each link text becomes a searchable title in
            <code>window.searchIndex</code>, which the Alpine.js search component uses.</li>
        <li><strong>Usage</strong> &mdash; The search component is included in the docs top navbar, so it is available on
            every documentation page automatically.</li>
    </ul>

    <p>
        If you add new topics to the sidebar, they are automatically included in the search index without any additional
        configuration.
    </p>

    <h2>Changelog</h2>
    <p>
        The changelog page lives at
        <code>resources/views/pages/docs/en/changelog.blade.php</code> and documents notable changes to
        {{ config('app.name') }}. Each release is rendered using the reusable
        <code>&lt;x-blocks.docs.changelog-section /&gt;</code> component.
    </p>

    <p>Each changelog section accepts the following props and slots:</p>
    <ul>
        <li><strong>title</strong> &mdash; Typically the release date (for example,
            <code>now()-&gt;format('F j, Y')</code>).</li>
        <li><strong>version</strong> &mdash; The semantic version (for example, <code>1.2.0</code>).</li>
        <li><strong>github</strong> &mdash; Optional URL to the release or pull request on GitHub.</li>
        <li><strong>&lt;x-slot:new&gt;</strong> &mdash; New features and additions.</li>
        <li><strong>&lt;x-slot:changed&gt;</strong> &mdash; Changes and improvements.</li>
        <li><strong>&lt;x-slot:fixed&gt;</strong> &mdash; Bug fixes and patches.</li>
    </ul>

    <p>Example usage from the changelog page:</p>

    <pre><code class="language-php">&lt;x-blocks.docs.changelog-section
    :title=&quot;now()-&gt;subDays(7)-&gt;format('F j, Y')&quot;
    version=&quot;1.2.0&quot;
    github=&quot;#&quot;&gt;
    &lt;x-slot:new&gt;
        &lt;ul class=&quot;space-y-1.5 text-sm&quot;&gt;
            &lt;li&gt;Enhanced admin dashboard with new revenue analytics widget&lt;/li&gt;
            &lt;li&gt;Real-time notification system with toast alerts&lt;/li&gt;
        &lt;/ul&gt;
    &lt;/x-slot:new&gt;
    &lt;x-slot:changed&gt;...&lt;/x-slot:changed&gt;
    &lt;x-slot:fixed&gt;...&lt;/x-slot:fixed&gt;
&lt;/x-blocks.docs.changelog-section&gt;</code></pre>

    <p>
        To add a new release, simply append another <code>&lt;x-blocks.docs.changelog-section /&gt;</code> block to the
        changelog page with the appropriate date, version, and content.
    </p>

    <h2>Changelog Translations</h2>
    <p>
        The documentation system supports localized versions of each docs page via
        <code>App\Http\Controllers\DocumentationController</code>. When a user switches the application locale, the
        controller will first try to load a locale-specific view and then fall back to English if needed.
    </p>

    <p>For the changelog page, the fallback order is:</p>
    <ol>
        <li><code>resources/views/pages/docs/&lt;locale&gt;/changelog.blade.php</code></li>
        <li><code>resources/views/pages/docs/en/changelog.blade.php</code></li>
        <li><code>resources/views/pages/docs/changelog.blade.php</code> (not used by default but supported)</li>
    </ol>

    <p>To add a translated changelog in another language (for example, Spanish):</p>
    <ol>
        <li>Create the directory <code>resources/views/pages/docs/es</code> if it does not exist.</li>
        <li>Copy the English changelog:
            <code>resources/views/pages/docs/en/changelog.blade.php</code> &rarr;
            <code>resources/views/pages/docs/es/changelog.blade.php</code>.
        </li>
        <li>Translate the headings, descriptions, and list items inside the new file while keeping the component structure
            the same.</li>
        <li>Ensure your app locale is set to <code>es</code> (via the language selector or configuration) to see the
            translated version.</li>
    </ol>

    <p>
        This approach keeps the Blade structure identical across languages while allowing you to fully translate the
        content for each release.
    </p>

    <h2>Summary</h2>
    <p>
        You can use the docs layout for any topic by creating a Blade file under <code>resources/views/pages/docs/en</code>,
        passing breadcrumbs into <code>&lt;x-layouts.docs /&gt;</code>, and linking to it from the docs sidebar. The search
        component and changelog system work automatically once your page is included in the sidebar navigation.
    </p>

</x-layouts.docs>


