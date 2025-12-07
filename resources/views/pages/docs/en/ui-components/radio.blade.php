@push('head')
    <title>Radio Component - {{ config('app.name') }}</title>
    <meta name="description"
        content="Learn how to use the Radio component. A flexible radio button component with support for descriptions, containers, and dark mode.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'UI Components', 'url' => '#'], ['label' => 'Radio', 'url' => '#']]">

    <h1>Radio Component</h1>
    <p>The Radio component provides styled radio buttons for selecting a single option from multiple choices.</p>

    <h2>Basic Usage</h2>
    <p>Create a group of radio buttons with the same name:</p>
    <pre><code class="language-html">&lt;div class="space-y-2"&gt;
    &lt;x-radio name="plan" value="free" label="Free Plan" /&gt;
    &lt;x-radio name="plan" value="pro" label="Pro Plan" :checked="true" /&gt;
    &lt;x-radio name="plan" value="enterprise" label="Enterprise Plan" /&gt;
&lt;/div&gt;</code></pre>

    <div class="my-6 not-prose">
        <div class="space-y-2">
            <x-radio name="plan" value="free" label="Free Plan" />
            <x-radio name="plan" value="pro" label="Pro Plan" :checked="true" />
            <x-radio name="plan" value="enterprise" label="Enterprise Plan" />
        </div>
    </div>

    <h2>With Description</h2>
    <p>Add descriptive text to provide more context:</p>
    <pre><code class="language-html">&lt;div class="space-y-4"&gt;
    &lt;x-radio 
        name="size" 
        value="small" 
        label="Small" 
        description="Perfect for personal projects" /&gt;
    &lt;x-radio 
        name="size" 
        value="medium" 
        label="Medium" 
        description="Great for small teams"
        :checked="true" /&gt;
    &lt;x-radio 
        name="size" 
        value="large" 
        label="Large" 
        description="Built for large organizations" /&gt;
&lt;/div&gt;</code></pre>

    <div class="my-6 not-prose">
        <div class="space-y-4">
            <x-radio 
                name="size" 
                value="small" 
                label="Small" 
                description="Perfect for personal projects" />
            <x-radio 
                name="size" 
                value="medium" 
                label="Medium" 
                description="Great for small teams"
                :checked="true" />
            <x-radio 
                name="size" 
                value="large" 
                label="Large" 
                description="Built for large organizations" />
        </div>
    </div>

    <h2>Container Style</h2>
    <p>Use the container style for a more prominent appearance:</p>
    <pre><code class="language-html">&lt;div class="flex flex-col gap-2 max-w-xs"&gt;
    &lt;x-radio name="theme" value="light" label="Light Mode" :withContainer="true" /&gt;
    &lt;x-radio name="theme" value="dark" label="Dark Mode" :withContainer="true" :checked="true" /&gt;
    &lt;x-radio name="theme" value="auto" label="Auto" :withContainer="true" /&gt;
&lt;/div&gt;</code></pre>

    <div class="my-6 not-prose">
        <div class="flex flex-col gap-2 max-w-xs">
            <x-radio name="theme" value="light" label="Light Mode" :withContainer="true" />
            <x-radio name="theme" value="dark" label="Dark Mode" :withContainer="true" :checked="true" />
            <x-radio name="theme" value="auto" label="Auto" :withContainer="true" />
        </div>
    </div>

    <h2>Disabled State</h2>
    <p>Disable radio buttons when needed:</p>
    <pre><code class="language-html">&lt;div class="space-y-2"&gt;
    &lt;x-radio name="payment" value="card" label="Credit Card" /&gt;
    &lt;x-radio name="payment" value="paypal" label="PayPal" :disabled="true" /&gt;
&lt;/div&gt;</code></pre>

    <div class="my-6 not-prose">
        <div class="space-y-2">
            <x-radio name="payment" value="card" label="Credit Card" />
            <x-radio name="payment" value="paypal" label="PayPal" :disabled="true" />
        </div>
    </div>

    <h2>Livewire Integration</h2>
    <p>Use with Livewire for reactive forms:</p>
    <pre><code class="language-html">&lt;div class="space-y-2"&gt;
    &lt;x-radio name="billing" value="monthly" label="Monthly" wire:model.live="billingPeriod" /&gt;
    &lt;x-radio name="billing" value="yearly" label="Yearly" wire:model.live="billingPeriod" /&gt;
&lt;/div&gt;</code></pre>

    <p>In your Livewire component:</p>
    <pre><code class="language-php">class SubscriptionForm extends Component
{
    public string $billingPeriod = 'monthly';

    public function updatedBillingPeriod()
    {
        // React to changes
    }
}</code></pre>

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
                <td>Auto-generated</td>
                <td>Unique ID for the radio button. Auto-generates if not provided.</td>
            </tr>
            <tr>
                <td><code>name</code></td>
                <td>string</td>
                <td>-</td>
                <td>Required. Radio group name. All radios in a group must share the same name.</td>
            </tr>
            <tr>
                <td><code>value</code></td>
                <td>string</td>
                <td>-</td>
                <td>Required. Value submitted when this radio is selected.</td>
            </tr>
            <tr>
                <td><code>label</code></td>
                <td>string|null</td>
                <td><code>null</code></td>
                <td>Label text displayed next to the radio button.</td>
            </tr>
            <tr>
                <td><code>description</code></td>
                <td>string|null</td>
                <td><code>null</code></td>
                <td>Additional descriptive text displayed below the label.</td>
            </tr>
            <tr>
                <td><code>labelPosition</code></td>
                <td>string</td>
                <td><code>right</code></td>
                <td>Label position relative to the radio. Options: <code>left</code>, <code>right</code></td>
            </tr>
            <tr>
                <td><code>checked</code></td>
                <td>bool</td>
                <td><code>false</code></td>
                <td>Whether the radio button is initially selected.</td>
            </tr>
            <tr>
                <td><code>disabled</code></td>
                <td>bool</td>
                <td><code>false</code></td>
                <td>Whether the radio button is disabled.</td>
            </tr>
            <tr>
                <td><code>withContainer</code></td>
                <td>bool</td>
                <td><code>false</code></td>
                <td>When <code>true</code>, displays the radio in a bordered container for emphasis.</td>
            </tr>
            <tr>
                <td><code>wire:model</code></td>
                <td>string</td>
                <td>-</td>
                <td>Livewire property binding. Use <code>wire:model.live</code> for real-time updates.</td>
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
                <td><strong>resources/views/components/radio.blade.php</strong></td>
                <td>Radio component file</td>
            </tr>
        </tbody>
    </table>

    <p class="pt-8 text-on-surface-muted dark:text-on-surface-muted-dark text-sm">For the detailed documentation, please
        visit the <a href="https://www.penguinui.com/components/radio-button" target="_blank">Penguin UI Radio Buttons</a>.</p>
</x-layouts.docs>

