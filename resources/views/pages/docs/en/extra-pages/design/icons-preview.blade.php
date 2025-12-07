@push('head')
    <title>Extra Pages - Icons Preview - {{ config('app.name') }}</title>
    <meta name="description"
        content="Document the /icons-preview gallery, the search + sizing controls, and how to add new Blade icons.">
@endpush

<x-layouts.docs :breadcrumbs="[
    ['label' => 'Extra Pages', 'url' => '#'],
    ['label' => 'Design', 'url' => '#'],
    ['label' => 'Icons Preview', 'url' => '#'],
]">

    <h1>Icons Preview Gallery</h1>
    <p class="text-on-surface-muted dark:text-on-surface-dark-muted">
        {{ @config('app.name') }} is using the <a href="https://heroicons.com/" target="_blank">Heroicons</a> and some
        of the icons from the <a href="https://icons.getbootstrap.com/" target="_blank">Bootstrap Icons</a> library. For
        your convenience we turned all thos icons into Blade components so you can use them in your project. You can browse the gallery below to see all the icons that are available.
    </p>

    <img src="{{ asset('images/docs/icons-preview-dark.webp') }}" alt="Icons Preview Gallery" class="hidden dark:block ">
    <img src="{{ asset('images/docs/icons-preview-light.webp') }}" alt="Icons Preview Gallery" class="dark:hidden ">

    <h2>Search + sizing controls</h2>
    <ul>
        <li>The search input filters cards on the client; there is no server request so typing stays instant.</li>
        <li>Size buttons simply reload the page with a new <code>?size=</code> param to keep the implementation simple
            and shareable.</li>
        <li>Copy affordances are handled with a light overlay, so feel free to restyle by changing the
            <code>.copy-wrap</code> CSS near the top of the file.
        </li>
    </ul>

    <h2>Example usage</h2>
    <p class="text-on-surface-muted dark:text-on-surface-dark-muted">
        Icons render through Blade components under the <code>x-icons.*</code> namespace so you can drop them anywhere
        in your templates while keeping size, variant, and color consistent.
    </p>

<pre><code class="language-html">&lt;!-- Heroicons support outline/solid/mini/micro variants + semantic sizes --&gt;
&lt;x-icons.question-mark-circle variant="solid" size="lg" class="text-primary dark:text-primary-dark"/&gt;
    </code></pre>

</x-layouts.docs>
