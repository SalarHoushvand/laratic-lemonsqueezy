@push('head')
    <title>Docs - Translations - {{ config('app.name') }}</title>
    <meta name="description"
        content="Learn how to translate your documentation pages using Laratic's locale-aware docs controller.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'Documentation', 'url' => '#'], ['label' => 'Translations', 'url' => '#']]">

    <h1>Docs Translations</h1>
    <p class="text-on-surface-muted dark:text-on-surface-dark-muted">
        {{ config('app.name') }} makes it simple to localize your docs. The documentation controller automatically looks
        for a translation in the active language and falls back to English if one isn’t available.
    </p>

    <h2>How Locale Fallback Works</h2>
    <p>
        All docs pages are handled by <code>App\Http\Controllers\DocumentationController</code>.  
        When someone visits <code>/docs/{topic}</code>, the controller:
    </p>

    <ol>
        <li>Gets the current locale using <code>app()-&gt;getLocale()</code>.</li>
        <li>Turns the topic (e.g. <code>blog/translations</code>) into a dot-path.</li>
        <li>Tries to load  
            <code>resources/views/pages/docs/&lt;locale&gt;/&lt;topic&gt;.blade.php</code>.
        </li>
        <li>If it doesn’t exist and the locale isn’t <code>en</code>, it falls back to the English version under  
            <code>resources/views/pages/docs/en</code>.
        </li>
    </ol>

    <p>For the <strong>changelog</strong> topic, the lookup order is:</p>

    <ol>
        <li><code>resources/views/pages/docs/&lt;locale&gt;/changelog.blade.php</code></li>
        <li><code>resources/views/pages/docs/en/changelog.blade.php</code></li>
        <li><code>resources/views/pages/docs/changelog.blade.php</code> (supported, but not used by default)</li>
    </ol>

    <h2>Adding a Translation</h2>
    <p>To add a translated docs page (for example, Spanish <code>es</code>):</p>

    <ol>
        <li>Create the locale folder if it doesn't exist:  
            <code>resources/views/pages/docs/es</code>.
        </li>
        <li>Copy the English page into that folder. For example:<br>
            <code>resources/views/pages/docs/en/changelog.blade.php</code> →  
            <code>resources/views/pages/docs/es/changelog.blade.php</code>
        </li>
        <li>Translate the text in the new file while keeping the same layout and Blade components.</li>
        <li>Switch the app locale to <code>es</code>, then visit <code>/docs/changelog</code> to see the result.</li>
    </ol>

    <div class="my-6 not-prose">
        <x-alert variant="warning" text="The translated file name and path structure must exactly match the English version. Only the locale folder changes (e.g., from 'en' to 'es'). The file name and any subdirectories must remain identical for the locale fallback to work correctly." />
    </div>

    <p>For example, if you have an English file at:</p>
    <pre><code class="language-plaintext">resources/views/pages/docs/en/documentation/translations.blade.php</code></pre>

    <p>The Spanish translation must be at:</p>
    <pre><code class="language-plaintext">resources/views/pages/docs/es/documentation/translations.blade.php</code></pre>

    <p>Notice that only <code>en</code> changes to <code>es</code>—the <code>documentation/translations.blade.php</code> part stays exactly the same.</p>


</x-layouts.docs>
