@push('head')
    <title>Accordion Component - {{ config('app.name') }}</title>
    <meta name="description"
        content="Learn how to use the Accordion component. A collapsible content component with smooth animations and full accessibility support.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'UI Components', 'url' => '#'], ['label' => 'Accordion', 'url' => '#']]">

    <h1>Accordion Component</h1>
    <p>The Accordion component is a collapsible content panel that allows users to expand and collapse sections.</p>

    <h2>Usage</h2>
    <p>The simplest way to use the accordion component:</p>
    <pre><code class="language-html">&lt;x-accordion&gt;
    &lt;x-slot:header&gt;What is Laravel?&lt;/x-slot:header&gt;
    &lt;x-slot:content&gt;
        Laravel is a PHP web application framework.
    &lt;/x-slot:content&gt;
&lt;/x-accordion&gt;</code></pre>

    <div class="my-6">
        <x-accordion>
            <x-slot:header>What is Laravel?</x-slot:header>
            <x-slot:content>
                Laravel is a PHP web application framework.
            </x-slot:content>
        </x-accordion>
    </div>

    <h2>Using Slots</h2>
    <p>You can use either named slots or the default slot for content:</p>
    <pre><code class="language-html">&lt;x-accordion&gt;
    &lt;x-slot:header&gt;Question Title&lt;/x-slot:header&gt;
    &lt;x-slot:content&gt;
        This is the answer content.
    &lt;/x-slot:content&gt;
&lt;/x-accordion&gt;

&lt;x-accordion&gt;
    &lt;x-slot:header&gt;Another Question&lt;/x-slot:header&gt;
    &lt;x-slot:content&gt;
        This content uses the default slot.
    &lt;/x-slot:content&gt;
&lt;/x-accordion&gt;</code></pre>

    <div class="my-6 space-y-4">
        <x-accordion>
            <x-slot:header>Question Title</x-slot:header>
            <x-slot:content>
                This is the answer content.
            </x-slot:content>
        </x-accordion>
        <x-accordion>
            <x-slot:header>Another Question</x-slot:header>
            This content uses the default slot.
        </x-accordion>
    </div>

    <h2>Initially Expanded</h2>
    <p>Set the <code>expanded</code> prop to <code>true</code> to have the accordion open by default:</p>
    <pre><code class="language-html">&lt;x-accordion :expanded="true"&gt;
    &lt;x-slot:header&gt;Open by Default&lt;/x-slot:header&gt;
    &lt;x-slot:content&gt;
        This accordion starts expanded.
    &lt;/x-slot:content&gt;
&lt;/x-accordion&gt;</code></pre>

    <div class="my-6">
        <x-accordion :expanded="true">
            <x-slot:header>Open by Default</x-slot:header>
            <x-slot:content>
                This accordion starts expanded.
            </x-slot:content>
        </x-accordion>
    </div>

    <div class="my-6 space-y-4">
        <x-accordion>
            <x-slot:header>First Question</x-slot:header>
            <x-slot:content>First answer.</x-slot:content>
        </x-accordion>
        <x-accordion>
            <x-slot:header>Second Question</x-slot:header>
            <x-slot:content>Second answer.</x-slot:content>
        </x-accordion>
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
                <td><code>id</code></td>
                <td>string|null</td>
                <td><code>null</code></td>
                <td>Custom ID for the accordion. If not provided, a random ID will be generated.</td>
            </tr>
            <tr>
                <td><code>expanded</code></td>
                <td>bool</td>
                <td><code>false</code></td>
                <td>Whether the accordion should be expanded by default.</td>
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
                <td><code>header</code> or <code>title</code></td>
                <td>The header text displayed in the accordion button. You can use either
                    <code>&lt;x-slot:header&gt;</code> or <code>&lt;x-slot:title&gt;</code>.
                </td>
            </tr>
            <tr>
                <td><code>content</code> or default slot</td>
                <td>The content displayed when the accordion is expanded. You can use
                    <code>&lt;x-slot:content&gt;</code> or place content in the default slot.
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
                <td><strong>resources/views/components/accordion.blade.php</strong></td>
                <td>Accordion component file</td>
            </tr>
        </tbody>
    </table>

    <p class="pt-8 text-on-surface-muted dark:text-on-surface-muted-dark text-sm">For the detailed documentation, please
        visit the <a href="https://www.penguinui.com/components/alert" target="_blank">Penguin UI Alerts</a>.</p>

</x-layouts.docs>
