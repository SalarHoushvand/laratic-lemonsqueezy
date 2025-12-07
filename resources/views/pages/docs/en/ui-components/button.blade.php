@push('head')
    <title>Button Component - {{ config('app.name') }}</title>
    <meta name="description"
        content="Learn how to use the Button component. A flexible, accessible button component with multiple variants, sizes, and styles for all your UI needs.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'UI Components', 'url' => '#'], ['label' => 'Button', 'url' => '#']]">

    <h1>Button Component</h1>
    <p>The Button component is a flexible, accessible component that can render as either a button or a link. It
        supports multiple variants, sizes, and color schemes with full dark mode support.</p>

    <h2>Usage</h2>
    <p>The simplest way to use the button component:</p>
    <pre><code class="language-html">&lt;x-button&gt;Click me&lt;/x-button&gt;</code></pre>

    <div class="flex gap-3 my-6">
        <x-button>Click me</x-button>
    </div>

    <h2>Variants</h2>
    <p>The button component supports a wide range of visual variants to suit different UI contexts:</p>

    <h3>Primary Variants</h3>
    <pre><code class="language-html">&lt;x-button variant="primary"&gt;Primary&lt;/x-button&gt;
&lt;x-button variant="secondary"&gt;Secondary&lt;/x-button&gt;
&lt;x-button variant="alternative"&gt;Alternative&lt;/x-button&gt;
&lt;x-button variant="inverse"&gt;Inverse&lt;/x-button&gt;</code></pre>

    <div class="flex flex-wrap gap-3 my-6">
        <x-button variant="primary">Primary</x-button>
        <x-button variant="secondary">Secondary</x-button>
        <x-button variant="alternative">Alternative</x-button>
        <x-button variant="inverse">Inverse</x-button>
    </div>

    <h3>Outline Variants</h3>
    <pre><code class="language-html">&lt;x-button variant="outline"&gt;Outline&lt;/x-button&gt;
&lt;x-button variant="outline-primary"&gt;Outline Primary&lt;/x-button&gt;
&lt;x-button variant="outline-secondary"&gt;Outline Secondary&lt;/x-button&gt;</code></pre>

    <div class="flex flex-wrap gap-3 my-6">
        <x-button variant="outline">Outline</x-button>
        <x-button variant="outline-primary">Outline Primary</x-button>
        <x-button variant="outline-secondary">Outline Secondary</x-button>
    </div>

    <h3>Status Variants</h3>
    <pre><code class="language-html">&lt;x-button variant="info"&gt;Info&lt;/x-button&gt;
&lt;x-button variant="success"&gt;Success&lt;/x-button&gt;
&lt;x-button variant="warning"&gt;Warning&lt;/x-button&gt;
&lt;x-button variant="danger"&gt;Danger&lt;/x-button&gt;</code></pre>

    <div class="flex flex-wrap gap-3 my-6">
        <x-button variant="info">Info</x-button>
        <x-button variant="success">Success</x-button>
        <x-button variant="warning">Warning</x-button>
        <x-button variant="danger">Danger</x-button>
    </div>

    <h3>Outline Status Variants</h3>
    <pre><code class="language-html">&lt;x-button variant="outline-info"&gt;Outline Info&lt;/x-button&gt;
&lt;x-button variant="outline-success"&gt;Outline Success&lt;/x-button&gt;
&lt;x-button variant="outline-warning"&gt;Outline Warning&lt;/x-button&gt;
&lt;x-button variant="outline-danger"&gt;Outline Danger&lt;/x-button&gt;</code></pre>

    <div class="flex flex-wrap gap-3 my-6">
        <x-button variant="outline-info">Outline Info</x-button>
        <x-button variant="outline-success">Outline Success</x-button>
        <x-button variant="outline-warning">Outline Warning</x-button>
        <x-button variant="outline-danger">Outline Danger</x-button>
    </div>

    <h3>Ghost Variant</h3>
    <pre><code class="language-html">&lt;x-button variant="ghost"&gt;Ghost&lt;/x-button&gt;</code></pre>

    <div class="flex gap-3 my-6">
        <x-button variant="ghost">Ghost</x-button>
    </div>

    <h2>Sizes</h2>
    <p>The button component supports four different sizes:</p>
    <pre><code class="language-html">&lt;x-button size="xs"&gt;Extra Small&lt;/x-button&gt;
&lt;x-button size="sm"&gt;Small&lt;/x-button&gt;
&lt;x-button size="md"&gt;Medium&lt;/x-button&gt;
&lt;x-button size="lg"&gt;Large&lt;/x-button&gt;</code></pre>

    <div class="flex flex-wrap items-center gap-3 my-6">
        <x-button size="xs">Extra Small</x-button>
        <x-button size="sm">Small</x-button>
        <x-button size="md">Medium</x-button>
        <x-button size="lg">Large</x-button>
    </div>

    <h2>As Link</h2>
    <p>When you provide an <code>href</code> attribute, the button will render as an anchor tag:</p>
    <pre><code class="language-html">&lt;x-button href="/dashboard"&gt;Go to Dashboard&lt;/x-button&gt;
&lt;x-button href="https://example.com" target="_blank"&gt;External Link&lt;/x-button&gt;</code></pre>

    <div class="flex gap-3 my-6">
        <x-button href="/dashboard">Go to Dashboard</x-button>
        <x-button href="https://example.com" target="_blank">External Link</x-button>
    </div>

    <h2>With Icons</h2>
    <p>You can easily include icons within buttons. The component uses flexbox with gap spacing:</p>
    <pre><code class="language-html">&lt;x-button&gt;
    &lt;x-icons.plus /&gt;
    Add New
&lt;/x-button&gt;

&lt;x-button variant="outline-danger"&gt;
    &lt;x-icons.trash /&gt;
    Delete
&lt;/x-button&gt;</code></pre>

    <div class="flex gap-3 my-6">
        <x-button>
            <x-icons.plus />
            Add New
        </x-button>
        <x-button variant="outline-danger">
            <x-icons.trash />
            Delete
        </x-button>
    </div>


    <h2>Livewire Usage</h2>
    <p>You can use the button component with Livewire. Just pass the <code>wire:click</code> attribute to the component:
    </p>
    <pre><code class="language-html">&lt;x-button wire:click="submit"&gt;Delete&lt;/x-button&gt;</code></pre>

    <h2>Circle Button</h2>
    <p>The <code>button-circle</code> component is a special circular button variant with a plus icon, perfect for floating action buttons and add actions.</p>

    <h3>Basic Circle Button</h3>
    <pre><code class="language-html">&lt;x-button-circle /&gt;
&lt;x-button-circle variant="secondary" /&gt;
&lt;x-button-circle variant="info" /&gt;</code></pre>

    <div class="flex gap-3 my-6 not-prose">
        <x-button-circle />
        <x-button-circle variant="secondary" />
        <x-button-circle variant="info" />
    </div>

    <h3>Circle Button Sizes</h3>
    <p>Circle buttons support six sizes from small to 3xl:</p>
    <pre><code class="language-html">&lt;x-button-circle size="sm" /&gt;
&lt;x-button-circle size="md" /&gt;
&lt;x-button-circle size="lg" /&gt;
&lt;x-button-circle size="xl" /&gt;
&lt;x-button-circle size="2xl" /&gt;
&lt;x-button-circle size="3xl" /&gt;</code></pre>

    <div class="flex flex-wrap items-center gap-3 my-6 not-prose">
        <x-button-circle size="sm" />
        <x-button-circle size="md" />
        <x-button-circle size="lg" />
        <x-button-circle size="xl" />
        <x-button-circle size="2xl" />
        <x-button-circle size="3xl" />
    </div>

    <h3>Circle Button Variants</h3>
    <p>All color variants are supported:</p>
    <pre><code class="language-html">&lt;x-button-circle variant="primary" /&gt;
&lt;x-button-circle variant="secondary" /&gt;
&lt;x-button-circle variant="alternate" /&gt;
&lt;x-button-circle variant="inverse" /&gt;
&lt;x-button-circle variant="info" /&gt;
&lt;x-button-circle variant="success" /&gt;
&lt;x-button-circle variant="warning" /&gt;
&lt;x-button-circle variant="danger" /&gt;</code></pre>

    <div class="flex flex-wrap gap-3 my-6 not-prose">
        <x-button-circle variant="primary" />
        <x-button-circle variant="secondary" />
        <x-button-circle variant="alternate" />
        <x-button-circle variant="inverse" />
        <x-button-circle variant="info" />
        <x-button-circle variant="success" />
        <x-button-circle variant="warning" />
        <x-button-circle variant="danger" />
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
                <td><code>primary</code></td>
                <td>Visual style variant. Options: <code>primary</code>, <code>secondary</code>,
                    <code>alternative</code>, <code>inverse</code>, <code>outline</code>, <code>outline-primary</code>,
                    <code>outline-secondary</code>, <code>outline-alternative</code>, <code>ghost</code>,
                    <code>info</code>, <code>outline-info</code>, <code>danger</code>, <code>outline-danger</code>,
                    <code>success</code>, <code>outline-success</code>, <code>warning</code>,
                    <code>outline-warning</code></td>
            </tr>
            <tr>
                <td><code>size</code></td>
                <td>string</td>
                <td><code>md</code></td>
                <td>Button size. Options: <code>xs</code>, <code>sm</code>, <code>md</code>, <code>lg</code></td>
            </tr>
            <tr>
                <td><code>href</code></td>
                <td>string|null</td>
                <td><code>null</code></td>
                <td>If provided, renders as an anchor tag instead of a button</td>
            </tr>
        </tbody>
    </table>

    <h2>Circle Button Props Reference</h2>
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
                <td><code>primary</code></td>
                <td>Visual style variant. Options: <code>primary</code>, <code>secondary</code>,
                    <code>alternate</code>, <code>inverse</code>, <code>info</code>, <code>danger</code>,
                    <code>success</code>, <code>warning</code></td>
            </tr>
            <tr>
                <td><code>size</code></td>
                <td>string</td>
                <td><code>md</code></td>
                <td>Button size. Options: <code>sm</code>, <code>md</code>, <code>lg</code>, <code>xl</code>,
                    <code>2xl</code>, <code>3xl</code></td>
            </tr>
            <tr>
                <td><code>href</code></td>
                <td>string|null</td>
                <td><code>null</code></td>
                <td>If provided, renders as an anchor tag instead of a button</td>
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
                <td><strong>resources/views/components/button.blade.php</strong></td>
                <td>Standard button component</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Component</x-badge></td>
                <td><strong>resources/views/components/button-circle.blade.php</strong></td>
                <td>Circular button with plus icon</td>
            </tr>
        </tbody>
    </table>

    <p class="pt-8 text-on-surface-muted dark:text-on-surface-muted-dark text-sm">For the detailed documentation, please
        visit the <a href="https://www.penguinui.com/components/button" target="_blank">Penguin UI Buttons</a>.</p>

</x-layouts.docs>
