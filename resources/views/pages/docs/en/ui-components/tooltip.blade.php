@push('head')
    <title>Tooltip Component - {{ config('app.name') }}</title>
    <meta name="description"
        content="Learn how to use the Tooltip component. A simple, accessible tooltip component that displays helpful information on hover or focus.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'UI Components', 'url' => '#'], ['label' => 'Tooltip', 'url' => '#']]">

    <h1>Tooltip Component</h1>
    <p>The Tooltip component provides a simple way to display helpful information when users hover over or focus on an
        element. It uses CSS peer selectors for hover states and includes proper ARIA attributes for accessibility.</p>

    <h2>Usage</h2>
    <p>Wrap any element with the tooltip component and provide the tooltip text:</p>
    <pre><code class="language-html">&lt;x-tooltip text="This is a helpful tooltip"&gt;
    &lt;x-button&gt;Hover me&lt;/x-button&gt;
&lt;/x-tooltip&gt;</code></pre>

    <div class="my-6 not-prose">
        <x-tooltip text="This is a helpful tooltip">
            <x-button>Hover me</x-button>
        </x-tooltip>
    </div>

    <h2>Positions</h2>
    <p>Control where the tooltip appears relative to the trigger element using the <code>position</code> prop:</p>
    <pre><code class="language-html">&lt;x-tooltip text="Top tooltip" position="top"&gt;
    &lt;x-button&gt;Top&lt;/x-button&gt;
&lt;/x-tooltip&gt;

&lt;x-tooltip text="Bottom tooltip" position="bottom"&gt;
    &lt;x-button&gt;Bottom&lt;/x-button&gt;
&lt;/x-tooltip&gt;

&lt;x-tooltip text="Left tooltip" position="left"&gt;
    &lt;x-button&gt;Left&lt;/x-button&gt;
&lt;/x-tooltip&gt;

&lt;x-tooltip text="Right tooltip" position="right"&gt;
    &lt;x-button&gt;Right&lt;/x-button&gt;
&lt;/x-tooltip&gt;</code></pre>

    <div class="my-6 not-prose flex flex-wrap gap-4 items-center justify-center">
        <x-tooltip text="Top tooltip" position="top">
            <x-button>Top</x-button>
        </x-tooltip>
        <x-tooltip text="Bottom tooltip" position="bottom">
            <x-button>Bottom</x-button>
        </x-tooltip>
        <x-tooltip text="Left tooltip" position="left">
            <x-button>Left</x-button>
        </x-tooltip>
        <x-tooltip text="Right tooltip" position="right">
            <x-button>Right</x-button>
        </x-tooltip>
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
                <td><code>text</code></td>
                <td>string</td>
                <td><code>''</code></td>
                <td>The text content to display in the tooltip</td>
            </tr>
            <tr>
                <td><code>position</code></td>
                <td>string</td>
                <td><code>top</code></td>
                <td>Position of the tooltip relative to the trigger. Options: <code>top</code>, <code>bottom</code>,
                    <code>left</code>, <code>right</code>
                </td>
            </tr>
            <tr>
                <td><code>id</code></td>
                <td>string</td>
                <td>Auto-generated</td>
                <td>Unique ID for the tooltip element. Auto-generates if not provided (format:
                    <code>tooltip-{unique}</code>)
                </td>
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
                <td><strong>resources/views/components/tooltip.blade.php</strong></td>
                <td>Tooltip component file</td>
            </tr>
        </tbody>
    </table>

    <p class="pt-8 text-on-surface-muted dark:text-on-surface-muted-dark text-sm">For the detailed documentation, please
        visit the <a href="https://www.penguinui.com/components/tooltip" target="_blank">Penguin UI Tooltips</a>.</p>
</x-layouts.docs>
