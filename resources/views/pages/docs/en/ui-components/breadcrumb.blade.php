@push('head')
    <title>Breadcrumb Component - {{ config('app.name') }}</title>
    <meta name="description"
        content="Learn how to use the Breadcrumb component. A simple navigation component for showing the current page location.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'UI Components', 'url' => '#'], ['label' => 'Breadcrumb', 'url' => '#']]">

    <h1>Breadcrumb Component</h1>
    <p>The Breadcrumb component displays a navigation trail showing the current page's location within the site hierarchy.</p>

    <h2>Usage</h2>
    <p>Pass an array of items with <code>label</code> and <code>url</code> keys:</p>
    <pre><code class="language-html">&lt;x-breadcrumb :items="[
    ['label' => 'Home', 'url' => '/'],
    ['label' => 'Products', 'url' => '/products'],
    ['label' => 'Details', 'url' => '#']
]" /&gt;</code></pre>

    <div class="my-6 not-prose">
        <x-breadcrumb :items="[
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Products', 'url' => '/products'],
            ['label' => 'Details', 'url' => '#']
        ]" />
    </div>

    <h2>Two Levels</h2>
    <p>Simple breadcrumb with just two levels:</p>
    <pre><code class="language-html">&lt;x-breadcrumb :items="[
    ['label' => 'Dashboard', 'url' => '/dashboard'],
    ['label' => 'Settings', 'url' => '#']
]" /&gt;</code></pre>

    <div class="my-6 not-prose">
        <x-breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => '/dashboard'],
            ['label' => 'Settings', 'url' => '#']
        ]" />
    </div>

    <h2>Multiple Levels</h2>
    <p>Breadcrumb with deep navigation hierarchy:</p>
    <pre><code class="language-html">&lt;x-breadcrumb :items="[
    ['label' => 'Home', 'url' => '/'],
    ['label' => 'Blog', 'url' => '/blog'],
    ['label' => 'Laravel', 'url' => '/blog/laravel'],
    ['label' => 'Getting Started', 'url' => '#']
]" /&gt;</code></pre>

    <div class="my-6 not-prose">
        <x-breadcrumb :items="[
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Blog', 'url' => '/blog'],
            ['label' => 'Laravel', 'url' => '/blog/laravel'],
            ['label' => 'Getting Started', 'url' => '#']
        ]" />
    </div>

    <h2>With Named Routes</h2>
    <p>You can use Laravel's named routes:</p>
    <pre><code class="language-html">&lt;x-breadcrumb :items="[
    ['label' => 'Home', 'url' => route('home')],
    ['label' => 'Docs', 'url' => route('docs.show', ['topic' => 'installation'])],
    ['label' => 'Components', 'url' => '#']
]" /&gt;</code></pre>

    <div class="my-6 not-prose">
        <x-breadcrumb :items="[
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Docs', 'url' => route('docs.show', ['topic' => 'installation'])],
            ['label' => 'Components', 'url' => '#']
        ]" />
    </div>

    <h2>Props Reference</h2>
    <table>
        <thead>
            <tr>
                <th>Prop</th>
                <th>Type</th>
                <th>Default</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><code>items</code></td>
                <td>array</td>
                <td>-</td>
                <td>Required. Array of breadcrumb items. Each item must have <code>label</code> (string) and
                    <code>url</code> (string) keys. The last item is automatically styled as the current page.</td>
            </tr>
        </tbody>
    </table>

    <h2>Item Structure</h2>
    <p>Each item in the <code>items</code> array should have the following structure:</p>
    <pre><code class="language-php">[
    'label' => 'Page Name',  // The text to display
    'url' => '/page-url'     // The URL to link to
]</code></pre>

    <h2>Behavior</h2>
    <ul>
        <li><strong>Responsive:</strong> Hidden on mobile devices (visible from <code>md</code> breakpoint and up)</li>
        <li><strong>Current Page:</strong> The last item is automatically styled as the current page with bold text and no link</li>
        <li><strong>Separator:</strong> Uses a chevron-right icon between items</li>
        <li><strong>Accessibility:</strong> Includes proper ARIA labels (<code>aria-label="breadcrumb"</code> and <code>aria-current="page"</code>)</li>
        <li><strong>Translation:</strong> Labels are automatically passed through Laravel's translation helper</li>
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
                <td><x-badge variant="outline-primary">Component</x-badge></td>
                <td><strong>resources/views/components/breadcrumb.blade.php</strong></td>
                <td>Breadcrumb component file</td>
            </tr>
        </tbody>
    </table>

    <p class="pt-8 text-on-surface-muted dark:text-on-surface-muted-dark text-sm">For the detailed documentation, please
        visit the <a href="https://www.penguinui.com/components/breadcrumb" target="_blank">Penguin UI Breadcrumbs</a>.</p>

</x-layouts.docs>

