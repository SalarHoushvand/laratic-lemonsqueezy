@push('head')
    <title>Checkbox Component - {{ config('app.name') }}</title>
    <meta name="description"
        content="Learn how to use the Checkbox component. A flexible checkbox component with labels, descriptions, and container styles.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'UI Components', 'url' => '#'], ['label' => 'Checkbox', 'url' => '#']]">

    <h1>Checkbox Component</h1>
    <p>The Checkbox component provides a flexible way to create checkboxes with labels, descriptions, and optional container styling. It supports dark mode and integrates seamlessly with Livewire.</p>

    <h2>Basic Usage</h2>
    <p>The simplest checkbox with a label:</p>
    <pre><code class="language-html">&lt;x-checkbox label="Accept terms" /&gt;</code></pre>

    <div class="flex gap-3 my-6 not-prose">
        <x-checkbox label="Accept terms" />
    </div>

    <h2>Label Position</h2>
    <p>Control the label position (left or right). Note: containers always have labels on the left.</p>
    <pre><code class="language-html">&lt;x-checkbox label="Label on left" labelPosition="left" /&gt;
&lt;x-checkbox label="Label on right" labelPosition="right" /&gt;</code></pre>

    <div class="flex flex-col gap-3 my-6 not-prose">
        <x-checkbox label="Label on left" labelPosition="left" />
        <x-checkbox label="Label on right" labelPosition="right" />
    </div>

    <h2>With Description</h2>
    <p>Add a description below the checkbox label:</p>
    <pre><code class="language-html">&lt;x-checkbox 
    label="Enable notifications" 
    description="Receive email updates about your account activity"
/&gt;</code></pre>

    <div class="flex gap-3 my-6 not-prose">
        <x-checkbox 
            label="Enable notifications" 
            description="Receive email updates about your account activity"
        />
    </div>

    <h2>With Container</h2>
    <p>Use the container style for a more prominent appearance:</p>
    <pre><code class="language-html">&lt;x-checkbox 
    label="Premium features" 
    :withContainer="true"
/&gt;</code></pre>

    <div class="flex gap-3 my-6 not-prose">
        <x-checkbox 
            label="Premium features" 
            :withContainer="true"
        />
    </div>

    <h2>Disabled State</h2>
    <p>Disable user interaction:</p>
    <pre><code class="language-html">&lt;x-checkbox label="Disabled unchecked" :disabled="true" /&gt;
&lt;x-checkbox label="Disabled checked" :checked="true" :disabled="true" /&gt;</code></pre>

    <div class="flex flex-col gap-3 my-6 not-prose">
        <x-checkbox label="Disabled unchecked" :disabled="true" />
        <x-checkbox label="Disabled checked" :checked="true" :disabled="true" />
    </div>

    <h2>Livewire Integration</h2>
    <p>Use with Livewire's wire:model:</p>
    <pre><code class="language-html">&lt;x-checkbox 
    label="Remember me" 
    wire:model="rememberMe"
/&gt;</code></pre>

    <pre><code class="language-html">&lt;x-checkbox 
    label="Live update" 
    wire:model.live="liveUpdate"
/&gt;</code></pre>

    <h2>Multiple Checkboxes</h2>
    <p>Group multiple checkboxes together:</p>
    <pre><code class="language-html">&lt;div class="flex flex-col gap-3"&gt;
    &lt;x-checkbox label="Option 1" name="options[]" /&gt;
    &lt;x-checkbox label="Option 2" name="options[]" /&gt;
    &lt;x-checkbox label="Option 3" name="options[]" /&gt;
&lt;/div&gt;</code></pre>

    <div class="flex flex-col gap-3 my-6 not-prose">
        <x-checkbox label="Option 1" name="options[]" />
        <x-checkbox label="Option 2" name="options[]" />
        <x-checkbox label="Option 3" name="options[]" />
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
                <td>Unique identifier for the checkbox. Auto-generated if not provided.</td>
            </tr>
            <tr>
                <td><code>label</code></td>
                <td>string|null</td>
                <td><code>null</code></td>
                <td>Label text displayed next to the checkbox.</td>
            </tr>
            <tr>
                <td><code>description</code></td>
                <td>string|null</td>
                <td><code>null</code></td>
                <td>Description text displayed below the checkbox (only when provided).</td>
            </tr>
            <tr>
                <td><code>labelPosition</code></td>
                <td>string</td>
                <td><code>right</code></td>
                <td>Position of the label. Options: <code>left</code>, <code>right</code>. Note: When <code>withContainer</code> is true, label is always on the left.</td>
            </tr>
            <tr>
                <td><code>checked</code></td>
                <td>bool</td>
                <td><code>false</code></td>
                <td>Initial checked state of the checkbox.</td>
            </tr>
            <tr>
                <td><code>disabled</code></td>
                <td>bool|null</td>
                <td><code>null</code></td>
                <td>Disables the checkbox when true.</td>
            </tr>
            <tr>
                <td><code>withContainer</code></td>
                <td>bool</td>
                <td><code>false</code></td>
                <td>Applies container styling with border and padding.</td>
            </tr>
            <tr>
                <td><code>name</code></td>
                <td>string</td>
                <td>-</td>
                <td>Name attribute for form submission.</td>
            </tr>
            <tr>
                <td><code>wire:model</code></td>
                <td>string</td>
                <td>-</td>
                <td>Livewire model binding (also supports <code>wire:model.live</code> and <code>wire:model.defer</code>).</td>
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
                <td><strong>resources/views/components/checkbox.blade.php</strong></td>
                <td>Checkbox component file</td>
            </tr>
        </tbody>
    </table>

    <p class="pt-8 text-on-surface-muted dark:text-on-surface-muted-dark text-sm">For the detailed documentation, please
        visit the <a href="https://www.penguinui.com/components/checkbox" target="_blank">Penguin UI Checkboxes</a>.</p>

</x-layouts.docs>

