@push('head')
    <title>Textarea Component - {{ config('app.name') }}</title>
    <meta name="description"
        content="Learn how to use the Textarea component. A styled multi-line text input with error states, disabled states, and Livewire support.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'UI Components', 'url' => '#'], ['label' => 'Textarea', 'url' => '#']]">

    <h1>Textarea Component</h1>
    <p>The Textarea component provides a styled multi-line text input with support for error states, disabled states, and
        full dark mode compatibility. It's designed to work seamlessly with forms and Livewire.</p>

    <h2>Usage</h2>
    <p>Use the textarea component for multi-line text input:</p>
    <pre><code class="language-html">&lt;x-text-area 
    name="description" 
    rows="4" 
    placeholder="Enter your description..."
/&gt;</code></pre>

    <div class="my-6 not-prose">
        <x-text-area name="description" rows="4" placeholder="Enter your description..." />
    </div>

    <h2>With Label</h2>
    <p>Combine with the input label component for accessible forms:</p>
    <pre><code class="language-html">&lt;div class="space-y-1"&gt;
    &lt;x-input-label for="message" value="Message" /&gt;
    &lt;x-text-area 
        id="message" 
        name="message" 
        rows="4" 
        placeholder="Your message..."
    /&gt;
&lt;/div&gt;</code></pre>

    <div class="my-6 not-prose">
        <div class="space-y-1">
            <x-input-label for="message" value="Message" />
            <x-text-area id="message" name="message" rows="4" placeholder="Your message..." />
        </div>
    </div>

    <h2>Error State</h2>
    <p>Show validation errors using the <code>error</code> prop:</p>
    <pre><code class="language-html">&lt;div class="space-y-1"&gt;
    &lt;x-input-label for="bio" value="Bio" :error="true" /&gt;
    &lt;x-text-area 
        id="bio" 
        name="bio" 
        rows="3" 
        :error="true"
        placeholder="Tell us about yourself..."
    /&gt;
    &lt;x-input-error :messages="['This field is required.']" /&gt;
&lt;/div&gt;</code></pre>

    <div class="my-6 not-prose">
        <div>
            <x-input-label for="bio" value="Bio" :error="true" />
            <x-text-area id="bio" name="bio" rows="3" :error="true" placeholder="Tell us about yourself..." />
            <x-input-error :messages="['This field is required.']" />
        </div>
    </div>


    <h2>Livewire Integration</h2>
    <p>Use with Livewire for reactive forms:</p>
    <pre><code class="language-html">&lt;x-text-area 
    wire:model="description" 
    name="description" 
    rows="4" 
    placeholder="Enter description..."
/&gt;</code></pre>

    <p>In your Livewire component:</p>
    <pre><code class="language-php">class CreatePost extends Component
{
    public string $description = '';

    public function save()
    {
        $this->validate([
            'description' => 'required|min:10',
        ]);
        
        // Save logic
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
                <td><code>disabled</code></td>
                <td>bool</td>
                <td><code>false</code></td>
                <td>Whether the textarea is disabled</td>
            </tr>
            <tr>
                <td><code>error</code></td>
                <td>bool</td>
                <td><code>false</code></td>
                <td>Whether to show error styling (red border)</td>
            </tr>
        </tbody>
    </table>

    <h3>Standard Textarea Attributes</h3>
    <p>The component also accepts all standard textarea attributes:</p>
    <ul>
        <li><code>name</code> — Input name for form submission</li>
        <li><code>id</code> — Unique identifier</li>
        <li><code>rows</code> — Number of visible text rows</li>
        <li><code>cols</code> — Number of visible character columns</li>
        <li><code>placeholder</code> — Placeholder text</li>
        <li><code>required</code> — Whether the field is required</li>
        <li><code>maxlength</code> — Maximum character length</li>
        <li><code>readonly</code> — Makes the textarea read-only</li>
        <li><code>wire:model</code> — Livewire property binding</li>
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
                <td><strong>resources/views/components/text-area.blade.php</strong></td>
                <td>Textarea component file</td>
            </tr>
        </tbody>
    </table>

    <p class="pt-8 text-on-surface-muted dark:text-on-surface-muted-dark text-sm">For the detailed documentation, please
        visit the <a href="https://www.penguinui.com/components/textarea" target="_blank">Penguin UI Textareas</a>.</p>
</x-layouts.docs>

