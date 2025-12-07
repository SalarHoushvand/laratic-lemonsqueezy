@push('head')
    <title>Docs - Search - {{ config('app.name') }}</title>
    <meta name="description"
        content="Learn how the Laratic docs search works and how it stays updated automatically.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'Documentation', 'url' => '#'], ['label' => 'Search', 'url' => '#']]">

    <h1>Docs Search</h1>
    <p class="text-on-surface-muted dark:text-on-surface-dark-muted">
        The documentation includes a fast, client-side search that works out of the box. There’s nothing you need to
        set up—whenever you add new pages or sidebar links, the search updates itself.
    </p>

    <h2>How It Works</h2>
    <p>
        The search component lives in  
        <code>resources/views/components/blocks/docs/search.blade.php</code>.  
        It uses Alpine.js for state handling and a small script that generates a
        <code>window.searchIndex</code> from the sidebar links.
    </p>

</x-layouts.docs>
