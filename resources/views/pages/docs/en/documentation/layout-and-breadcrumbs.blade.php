@push('head')
    <title>Docs - Layout &amp; Breadcrumbs - {{ config('app.name') }}</title>
    <meta name="description"
        content="Learn how Laratic provides a ready-made documentation layout with breadcrumbs and a clean reading experience.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'Documentation', 'url' => '#'], ['label' => 'Layout & Breadcrumbs', 'url' => '#']]">

    <h1>Docs Layout &amp; Breadcrumbs</h1>
    <p class="text-on-surface-muted dark:text-on-surface-dark-muted">
        {{ config('app.name') }} gives you a complete documentation layout out of the box—sidebar, the one you are
        seeing right now, so you don’t have to build any of it yourself.
    </p>

    <h2>Ready-Made Docs Layout</h2>
    <p>
        All docs pages use the shared <code>&lt;x-layouts.docs /&gt;</code> component, found in
        <code>resources/views/components/layouts/docs.blade.php</code>.
        This layout automatically:
    </p>
    
    <p>Here’s an example of using it in a docs page:</p>

    <pre><code class="language-html">&commat;push('head')
    &lt;title&gt;My Topic - {{ config('app.name') }}&lt;/title&gt;
    &lt;meta name=&quot;description&quot; content=&quot;Short description of this topic.&quot;&gt;
&commat;endpush

&lt;x-layouts.docs :breadcrumbs=&quot;[['label' =&gt; 'Basics', 'url' =&gt; '#'], ['label' =&gt; 'My Topic', 'url' =&gt; '#']]&quot;&gt;
    &lt;h1&gt;My Topic&lt;/h1&gt;
    &lt;p&gt;Your documentation content goes here...&lt;/p&gt;
&lt;/x-layouts.docs&gt;</code></pre>

    <h2>Breadcrumbs</h2>
    <p>
        The <code>:breadcrumbs</code> prop you pass into <code>&lt;x-layouts.docs /&gt;</code> is sent to the top
        navbar.
        Each breadcrumb is a simple array with a <code>label</code> and <code>url</code>, helping readers understand
        where they are.
    </p>

    <pre><code class="language-php">[['label' =&gt; 'Basics', 'url' =&gt; '#'], ['label' =&gt; 'Installation', 'url' =&gt; '#']]</code></pre>

</x-layouts.docs>
