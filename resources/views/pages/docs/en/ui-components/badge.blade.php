@push('head')
    <title>Badge Component - {{ config('app.name') }}</title>
    <meta name="description"
        content="Learn how to use the Badge component. A flexible badge component for labels, tags, and status indicators.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'UI Components', 'url' => '#'], ['label' => 'Badge', 'url' => '#']]">

    <h1>Badge Component</h1>
    <p>The Badge component displays small labels, tags, or status indicators. It supports multiple sizes, styles, and color variants.</p>

    <h2>Usage</h2>
    <p>The simplest way to use the badge component:</p>
    <pre><code class="language-html">&lt;x-badge&gt;New&lt;/x-badge&gt;</code></pre>

    <div class="flex gap-3 my-6 not-prose">
        <x-badge>New</x-badge>
    </div>

    <h2>Sizes</h2>
    <p>The badge component supports five different sizes:</p>
    <pre><code class="language-html">&lt;x-badge size="xxs"&gt;Extra Extra Small&lt;/x-badge&gt;
&lt;x-badge size="xs"&gt;Extra Small&lt;/x-badge&gt;
&lt;x-badge size="sm"&gt;Small&lt;/x-badge&gt;
&lt;x-badge size="md"&gt;Medium&lt;/x-badge&gt;
&lt;x-badge size="lg"&gt;Large&lt;/x-badge&gt;</code></pre>

    <div class="flex flex-wrap items-center gap-3 my-6 not-prose">
        <x-badge size="xxs">Extra Extra Small</x-badge>
        <x-badge size="xs">Extra Small</x-badge>
        <x-badge size="sm">Small</x-badge>
        <x-badge size="md">Medium</x-badge>
        <x-badge size="lg">Large</x-badge>
    </div>

    <h2>Solid Variants</h2>
    <p>Solid badges with background colors:</p>
    <pre><code class="language-html">&lt;x-badge variant="default"&gt;Default&lt;/x-badge&gt;
&lt;x-badge variant="primary"&gt;Primary&lt;/x-badge&gt;
&lt;x-badge variant="secondary"&gt;Secondary&lt;/x-badge&gt;
&lt;x-badge variant="info"&gt;Info&lt;/x-badge&gt;
&lt;x-badge variant="success"&gt;Success&lt;/x-badge&gt;
&lt;x-badge variant="warning"&gt;Warning&lt;/x-badge&gt;
&lt;x-badge variant="danger"&gt;Danger&lt;/x-badge&gt;</code></pre>

    <div class="flex flex-wrap gap-3 my-6 not-prose">
        <x-badge variant="default">Default</x-badge>
        <x-badge variant="primary">Primary</x-badge>
        <x-badge variant="secondary">Secondary</x-badge>
        <x-badge variant="info">Info</x-badge>
        <x-badge variant="success">Success</x-badge>
        <x-badge variant="warning">Warning</x-badge>
        <x-badge variant="danger">Danger</x-badge>
    </div>

    <h2>Outline Variants</h2>
    <p>Outline badges with colored borders and text:</p>
    <pre><code class="language-html">&lt;x-badge variant="outline-default"&gt;Default&lt;/x-badge&gt;
&lt;x-badge variant="outline-primary"&gt;Primary&lt;/x-badge&gt;
&lt;x-badge variant="outline-secondary"&gt;Secondary&lt;/x-badge&gt;
&lt;x-badge variant="outline-info"&gt;Info&lt;/x-badge&gt;
&lt;x-badge variant="outline-success"&gt;Success&lt;/x-badge&gt;
&lt;x-badge variant="outline-warning"&gt;Warning&lt;/x-badge&gt;
&lt;x-badge variant="outline-danger"&gt;Danger&lt;/x-badge&gt;</code></pre>

    <div class="flex flex-wrap gap-3 my-6 not-prose">
        <x-badge variant="outline-default">Default</x-badge>
        <x-badge variant="outline-primary">Primary</x-badge>
        <x-badge variant="outline-secondary">Secondary</x-badge>
        <x-badge variant="outline-info">Info</x-badge>
        <x-badge variant="outline-success">Success</x-badge>
        <x-badge variant="outline-warning">Warning</x-badge>
        <x-badge variant="outline-danger">Danger</x-badge>
    </div>

    <h2>With Icons</h2>
    <p>Badges can include icons alongside text:</p>
    <pre><code class="language-html">&lt;x-badge variant="success"&gt;
    &lt;x-icons.check variant="micro" size="xs" /&gt;
    Verified
&lt;/x-badge&gt;

&lt;x-badge variant="outline-warning"&gt;
    &lt;x-icons.exclamation-triangle variant="micro" size="xs" /&gt;
    Warning
&lt;/x-badge&gt;

&lt;x-badge variant="info"&gt;
    &lt;x-icons.information-circle variant="micro" size="xs" /&gt;
    Info
&lt;/x-badge&gt;</code></pre>

    <div class="flex flex-wrap gap-3 my-6 not-prose">
        <x-badge variant="success">
            <x-icons.check variant="micro" size="xs" />
            Verified
        </x-badge>
        <x-badge variant="outline-warning">
            <x-icons.exclamation-triangle variant="micro" size="xs" />
            Warning
        </x-badge>
        <x-badge variant="info">
            <x-icons.information-circle variant="micro" size="xs" />
            Info
        </x-badge>
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
                <td><code>variant</code></td>
                <td>string</td>
                <td><code>default</code></td>
                <td>Style variant. Options: <code>default</code>, <code>primary</code>, <code>secondary</code>,
                    <code>info</code>, <code>success</code>, <code>warning</code>, <code>danger</code>. Prefix with
                    <code>outline-</code> for outline style (e.g., <code>outline-primary</code>).</td>
            </tr>
            <tr>
                <td><code>size</code></td>
                <td>string</td>
                <td><code>xs</code></td>
                <td>Badge size. Options: <code>xxs</code>, <code>xs</code>, <code>sm</code>, <code>md</code>,
                    <code>lg</code></td>
            </tr>
        </tbody>
    </table>

    <h2>Slots</h2>
    <table>
        <thead>
            <tr>
                <th>Slot</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Default slot</td>
                <td>Badge content. Can contain text, icons, or both. The component automatically handles spacing between
                    elements.</td>
            </tr>
        </tbody>
    </table>

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
                <td><strong>resources/views/components/badge.blade.php</strong></td>
                <td>Badge component file</td>
            </tr>
        </tbody>
    </table>

    <p class="pt-8 text-on-surface-muted dark:text-on-surface-muted-dark text-sm">For the detailed documentation, please
        visit the <a href="https://www.penguinui.com/components/avatars" target="_blank">Penguin UI Avatars</a>.</p>

</x-layouts.docs>

