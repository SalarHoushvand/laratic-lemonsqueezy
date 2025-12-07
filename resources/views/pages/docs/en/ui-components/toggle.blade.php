@push('head')
    <title>Toggle Component - {{ config('app.name') }}</title>
    <meta name="description"
        content="Learn how to use the Toggle component. A customizable toggle switch component with multiple sizes and Livewire support.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'UI Components', 'url' => '#'], ['label' => 'Toggle', 'url' => '#']]">

    <h1>Toggle Component</h1>
    <p>The Toggle component provides a switch-style input with customizable sizes, label positions, and full Livewire
        support.</p>

    <h2>Usage</h2>
    <p>Create a simple toggle with a label:</p>

    <pre><code class="language-html">&lt;x-toggle label="Enable notifications" /&gt;</code></pre>

    <div class="my-6 not-prose">
        <x-toggle label="Enable notifications" />
    </div>

    <h2>Sizes</h2>
    <p>The toggle component supports four sizes: <code>sm</code>, <code>md</code>, <code>lg</code>, and
        <code>xl</code>:
    </p>

    <pre><code class="language-html">&lt;x-toggle size="sm" label="Small" /&gt;
&lt;x-toggle size="md" label="Medium" /&gt;
&lt;x-toggle size="lg" label="Large" /&gt;
&lt;x-toggle size="xl" label="Extra Large" /&gt;</code></pre>

    <div class="my-6 not-prose flex flex-col gap-4">
        <x-toggle size="sm" label="Small" />
        <x-toggle size="md" label="Medium" />
        <x-toggle size="lg" label="Large" />
        <x-toggle size="xl" label="Extra Large" />
    </div>

    <h2>Label Position</h2>
    <p>Position the label on the left, right, or hide it completely:</p>

    <pre><code class="language-html">&lt;x-toggle label="Label on right" labelPosition="right" /&gt;
&lt;x-toggle label="Label on left" labelPosition="left" /&gt;
&lt;x-toggle label="Hidden label" labelPosition="none" /&gt;</code></pre>

    <div class="my-6 not-prose flex flex-col gap-4">
        <x-toggle label="Label on right" labelPosition="right" />
        <x-toggle label="Label on left" labelPosition="left" />
        <x-toggle label="Hidden label" labelPosition="none" />
    </div>

    <h2>States</h2>
    <p>Control the toggle's checked and disabled states:</p>

    <pre><code class="language-html">&lt;x-toggle label="Checked" :checked="true" /&gt;
&lt;x-toggle label="Disabled" :disabled="true" /&gt;
&lt;x-toggle label="Checked & Disabled" :checked="true" :disabled="true" /&gt;</code></pre>

    <div class="my-6 not-prose flex flex-col gap-4">
        <x-toggle label="Checked" :checked="true" />
        <x-toggle label="Disabled" :disabled="true" />
        <x-toggle label="Checked & Disabled" :checked="true" :disabled="true" />
    </div>

    <h2>Container Style</h2>
    <p>Use <code>withContainer</code> to wrap the toggle in a styled container:</p>

    <pre><code class="language-html">&lt;x-toggle label="With container" :withContainer="true" /&gt;</code></pre>

    <div class="my-6 not-prose">
        <x-toggle label="Enable dark mode" :withContainer="true" />
    </div>

    <h2>Livewire Integration</h2>
    <p>Use with Livewire for reactive state management:</p>

    <pre><code class="language-html">&lt;x-toggle 
    label="Enable notifications" 
    wire:model.live="notifications"
/&gt;</code></pre>

    <pre><code class="language-php">use Livewire\Component;
use Illuminate\View\View;

class Settings extends Component
{
    public bool $notifications = false;

    public function render(): View
    {
        return view('livewire.settings');
    }
}</code></pre>

    <h2>Props</h2>
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
                <td>Unique identifier. Auto-generated if not provided</td>
            </tr>
            <tr>
                <td><code>label</code></td>
                <td>string|null</td>
                <td><code>null</code></td>
                <td>Toggle label text</td>
            </tr>
            <tr>
                <td><code>labelPosition</code></td>
                <td>string</td>
                <td><code>'right'</code></td>
                <td>Label position: <code>right</code>, <code>left</code>, or <code>none</code></td>
            </tr>
            <tr>
                <td><code>size</code></td>
                <td>string</td>
                <td><code>'md'</code></td>
                <td>Toggle size: <code>sm</code>, <code>md</code>, <code>lg</code>, or <code>xl</code></td>
            </tr>
            <tr>
                <td><code>checked</code></td>
                <td>bool|null</td>
                <td><code>null</code></td>
                <td>Whether the toggle is checked</td>
            </tr>
            <tr>
                <td><code>disabled</code></td>
                <td>bool|null</td>
                <td><code>null</code></td>
                <td>Whether the toggle is disabled</td>
            </tr>
            <tr>
                <td><code>ariaLabel</code></td>
                <td>string|null</td>
                <td><code>null</code></td>
                <td>ARIA label for accessibility. Auto-set when <code>labelPosition="none"</code></td>
            </tr>
            <tr>
                <td><code>withContainer</code></td>
                <td>bool</td>
                <td><code>false</code></td>
                <td>Whether to wrap the toggle in a styled container</td>
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
                <td><strong>resources/views/components/toggle.blade.php</strong></td>
                <td>Toggle component file</td>
            </tr>
        </tbody>
    </table>

    <p class="pt-8 text-on-surface-muted dark:text-on-surface-muted-dark text-sm">For the detailed documentation, please
        visit the <a href="https://www.penguinui.com/components/toggle" target="_blank">Penguin UI Toggles</a>.</p>
</x-layouts.docs>
