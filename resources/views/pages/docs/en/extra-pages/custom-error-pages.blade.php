@push('head')
    <title>Extra Pages - Custom Error Pages - {{ config('app.name') }}</title>
    <meta name="description"
        content="See how each HTTP error page is styled, where the Blade files live, and how to preview them quickly.">
@endpush

<x-layouts.docs :breadcrumbs="[
    ['label' => 'Extra Pages', 'url' => '#'],
    ['label' => 'Custom Error Pages', 'url' => '#'],
]">

    <h1>Custom Error Pages</h1>
    <p class="text-on-surface-muted dark:text-on-surface-dark-muted">
        {{ config('app.name') }} provides pre-built error pages for some ofthe common HTTP errors. These pages share the guest layout so branding, typography, and gradients match every other marketing page.
       
    </p>

    <img src="{{ asset('images/docs/errors-dark.webp') }}" alt="Custom Error Pages" class="hidden dark:block border-0!">
    <img src="{{ asset('images/docs/errors-light.webp') }}" alt="Custom Error Pages" class="dark:hidden border-0!">

    <h2>Where everything lives</h2>
    <ul>
        <li><x-badge variant="outline-primary">Views</x-badge>
            <code>resources/views/errors/{code}.blade.php</code>
        </li>
        <li><x-badge variant="outline-primary">Layout</x-badge>
            <code>x-layouts.guest</code> with the same polka-dot background used on public pages.
        </li>
        <li><x-badge variant="outline-primary">Preview routes</x-badge>
            <code>routes/web.php</code> &rarr; <code>/test/errors/{code}</code> group
            (400, 401, 403, 404, 419, 429, 500, 503).</li>
    </ul>


</x-layouts.docs>


