@push('head')
    <title>Select Component - {{ config('app.name') }}</title>
    <meta name="description"
        content="Learn how to use the Select component. A styled dropdown select component with optional icons and error states.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'UI Components', 'url' => '#'], ['label' => 'Select', 'url' => '#']]">

    <h1>Select Component</h1>
    <p>The Select component provides a styled dropdown for selecting options from a list.</p>

    <h2>Basic Usage</h2>
    <p>Create a simple select dropdown:</p>
    <pre><code class="language-html">&lt;div class="max-w-xs space-y-1"&gt;
    &lt;x-input-label for="country" value="Country" /&gt;
    &lt;x-select id="country" name="country"&gt;
        &lt;option value=""&gt;Select a country&lt;/option&gt;
        &lt;option value="us"&gt;United States&lt;/option&gt;
        &lt;option value="ca"&gt;Canada&lt;/option&gt;
        &lt;option value="uk"&gt;United Kingdom&lt;/option&gt;
        &lt;option value="au"&gt;Australia&lt;/option&gt;
    &lt;/x-select&gt;
&lt;/div&gt;</code></pre>

    <div class="my-6 not-prose">
        <div class="max-w-xs space-y-1">
            <x-input-label for="country" value="Country" />
            <x-select id="country" name="country">
                <option value="">Select a country</option>
                <option value="us">United States</option>
                <option value="ca">Canada</option>
                <option value="uk">United Kingdom</option>
                <option value="au">Australia</option>
            </x-select>
        </div>
    </div>

    <h2>With Icon</h2>
    <p>Add an icon to the left side of the select:</p>
    <pre><code class="language-html">&lt;div class="max-w-xs space-y-1"&gt;
    &lt;x-input-label for="language" value="Language" /&gt;
    &lt;x-select id="language" name="language" icon="language"&gt;
        &lt;option value=""&gt;Select a language&lt;/option&gt;
        &lt;option value="en"&gt;English&lt;/option&gt;
        &lt;option value="es"&gt;Spanish&lt;/option&gt;
        &lt;option value="fr"&gt;French&lt;/option&gt;
        &lt;option value="de"&gt;German&lt;/option&gt;
    &lt;/x-select&gt;
&lt;/div&gt;</code></pre>

    <div class="my-6 not-prose">
        <div class="max-w-xs space-y-1">
            <x-input-label for="language" value="Language" />
            <x-select id="language" name="language" icon="language">
                <option value="">Select a language</option>
                <option value="en">English</option>
                <option value="es">Spanish</option>
                <option value="fr">French</option>
                <option value="de">German</option>
            </x-select>
        </div>
    </div>

    <h2>Error State</h2>
    <p>Display validation errors:</p>
    <pre><code class="language-html">&lt;div class="max-w-xs space-y-1"&gt;
    &lt;x-input-label for="category" value="Category" :error="true" /&gt;
    &lt;x-select id="category" name="category" :error="true"&gt;
        &lt;option value=""&gt;Select a category&lt;/option&gt;
        &lt;option value="tech"&gt;Technology&lt;/option&gt;
        &lt;option value="design"&gt;Design&lt;/option&gt;
        &lt;option value="business"&gt;Business&lt;/option&gt;
    &lt;/x-select&gt;
    &lt;x-input-error :messages="['The category field is required.']" /&gt;
&lt;/div&gt;</code></pre>

    <div class="my-6 not-prose">
        <div class="max-w-xs space-y-1">
            <x-input-label for="category" value="Category" :error="true" />
            <x-select id="category" name="category" :error="true">
                <option value="">Select a category</option>
                <option value="tech">Technology</option>
                <option value="design">Design</option>
                <option value="business">Business</option>
            </x-select>
            <x-input-error :messages="['The category field is required.']" />
        </div>
    </div>
    
    <h2>Livewire Integration</h2>
    <p>Use with Livewire for reactive forms:</p>
    <pre><code class="language-html">&lt;x-select name="role" wire:model.live="selectedRole"&gt;
    &lt;option value=""&gt;Select a role&lt;/option&gt;
    &lt;option value="admin"&gt;Administrator&lt;/option&gt;
    &lt;option value="editor"&gt;Editor&lt;/option&gt;
    &lt;option value="viewer"&gt;Viewer&lt;/option&gt;
&lt;/x-select&gt;</code></pre>

    <p>In your Livewire component:</p>
    <pre><code class="language-php">class UserForm extends Component
{
    public string $selectedRole = '';

    public function updatedSelectedRole()
    {
        // React to role changes
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
                <td><code>width</code></td>
                <td>string</td>
                <td><code>max-w-xs</code></td>
                <td>CSS width class for the select container.</td>
            </tr>
            <tr>
                <td><code>error</code></td>
                <td>bool</td>
                <td><code>false</code></td>
                <td>When <code>true</code>, applies error styling with a red border.</td>
            </tr>
            <tr>
                <td><code>icon</code></td>
                <td>string|null</td>
                <td><code>null</code></td>
                <td>Icon name to display on the left side. Uses <code>x-icons.*</code> components.</td>
            </tr>
            <tr>
                <td><code>chevron</code></td>
                <td>bool</td>
                <td><code>true</code></td>
                <td>Whether to display the chevron-down icon on the right side.</td>
            </tr>
            <tr>
                <td><code>name</code></td>
                <td>string</td>
                <td>-</td>
                <td>Name attribute for form submission.</td>
            </tr>
            <tr>
                <td><code>id</code></td>
                <td>string</td>
                <td>-</td>
                <td>ID attribute for label association.</td>
            </tr>
            <tr>
                <td><code>disabled</code></td>
                <td>bool</td>
                <td><code>false</code></td>
                <td>Whether the select is disabled.</td>
            </tr>
            <tr>
                <td><code>wire:model</code></td>
                <td>string</td>
                <td>-</td>
                <td>Livewire property binding. Use <code>wire:model.live</code> for real-time updates.</td>
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
                <td>Contains the <code>&lt;option&gt;</code> elements for the dropdown.</td>
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
                <td><strong>resources/views/components/select.blade.php</strong></td>
                <td>Select component file</td>
            </tr>
        </tbody>
    </table>

</x-layouts.docs>

