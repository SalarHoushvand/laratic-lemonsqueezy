@push('head')
    <title>Input Component - {{ config('app.name') }}</title>
    <meta name="description"
        content="Learn how to use the Input component. A flexible input field component with support for text, password, search, and date variants with built-in error handling.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'UI Components', 'url' => '#'], ['label' => 'Input', 'url' => '#']]">

    <h1>Input Component</h1>
    <p>The Input component provides a consistent and accessible text input field with support for multiple variants
        including text, password with visibility toggle, search with icon, and date picker. It includes built-in error
        state styling and dark mode support.</p>

    <h2>Basic Usage</h2>
    <p>The simplest way to use the input component with a label:</p>
    <pre><code class="language-html">&lt;div class="max-w-xs space-y-1"&gt;
    &lt;x-input-label for="username" value="Username" /&gt;
    &lt;x-input type="text" id="username" name="username" placeholder="Enter your username" /&gt;
&lt;/div&gt;</code></pre>

    <div class="my-6 not-prose max-w-xs space-y-1">
        <x-input-label for="username" value="Username" />
        <x-input type="text" id="username" name="username" placeholder="Enter your username" />
    </div>


    <h2>Password Variant</h2>
    <p>A password input with an optional show/hide toggle button:</p>
    <pre><code class="language-html">&lt;div class="max-w-xs space-y-1"&gt;
    &lt;x-input-label for="password" value="Password" /&gt;
    &lt;x-input 
        id="password"
        variant="password" 
        name="password" 
        :viewable="true"
        placeholder="Enter password" /&gt;
&lt;/div&gt;</code></pre>

    <div class="my-6 not-prose max-w-xs space-y-1">
        <x-input-label for="password" value="Password" />
        <x-input id="password" variant="password" name="password" placeholder="Enter password" :viewable="true" />
    </div>



    <h2>Search Variant</h2>
    <p>A search input with a magnifying glass icon:</p>
    <pre><code class="language-html">&lt;div class="max-w-xs space-y-1"&gt;
    &lt;x-input-label for="search" value="Search" /&gt;
    &lt;x-input 
        id="search"
        variant="search" 
        name="search" 
        placeholder="Search articles..." /&gt;
&lt;/div&gt;</code></pre>

    <div class="my-6 not-prose max-w-xs space-y-1">
        <x-input-label for="search" value="Search" />
        <x-input id="search" variant="search" name="search" placeholder="Search articles..." />
    </div>

    <h2>Date Variant</h2>
    <p>A date picker input:</p>
    <pre><code class="language-html">&lt;div class="max-w-xs space-y-1"&gt;
    &lt;x-input-label for="birth_date" value="Birth Date" /&gt;
    &lt;x-input 
        id="birth_date"
        variant="date" 
        name="birth_date" /&gt;
&lt;/div&gt;</code></pre>

    <div class="my-6 not-prose max-w-xs space-y-1">
        <x-input-label for="birth_date" value="Birth Date" />
        <x-input id="birth_date" variant="date" name="birth_date" />
    </div>

    <h2>Disabled State</h2>
    <p>Disable user interaction with the <code>disabled</code> prop:</p>
    <pre><code class="language-html">&lt;div class="max-w-xs space-y-1"&gt;
    &lt;x-input-label for="email_disabled" value="Email (Disabled)" /&gt;
    &lt;x-input 
        id="email_disabled"
        type="text" 
        name="email" 
        value="user@example.com"
        :disabled="true" /&gt;
&lt;/div&gt;</code></pre>

    <div class="my-6 not-prose max-w-xs space-y-1">
        <x-input-label for="email_disabled" value="Email (Disabled)" />
        <x-input id="email_disabled" type="text" name="email" value="user@example.com" :disabled="true" />
    </div>

    <h2>Error State</h2>
    <p>Display the input in an error state using the <code>error</code> prop, along with label and error message:</p>
    <pre><code class="language-html">&lt;div class="max-w-xs space-y-1"&gt;
    &lt;x-input-label for="user_email" value="Email Address" :error="true" /&gt;
    &lt;x-input 
        id="user_email"
        type="email" 
        name="user_email" 
        placeholder="Enter email"
        :error="true" /&gt;
    &lt;x-input-error :messages="['The email field is required.']" /&gt;
&lt;/div&gt;</code></pre>

    <div class="my-6 not-prose max-w-xs space-y-1">
        <x-input-label for="user_email" value="Email Address" :error="true" />
        <x-input id="user_email" type="email" name="user_email" placeholder="Enter email" :error="true" />
        <x-input-error :messages="['The email field is required.']" />
    </div>

    <h2>Complete Form Example</h2>
    <p>Combine with input-label, helper text, and input-error components for a complete form field:</p>
    <pre><code class="language-html">&lt;div class="space-y-1 max-w-xs"&gt;
    &lt;x-input-label for="email_complete" value="Email Address" /&gt;
    &lt;x-input 
        id="email_complete"
        type="email" 
        name="email" 
        placeholder="you@example.com"
        required /&gt;
    &lt;small class="text-xs text-on-surface-muted dark:text-on-surface-dark-muted"&gt;
        We'll never share your email with anyone else.
    &lt;/small&gt;
    &lt;x-input-error :messages="$errors->get('email')" /&gt;
&lt;/div&gt;</code></pre>

    <div class="my-6 not-prose max-w-xs space-y-1">
        <div class="space-y-1">
            <x-input-label for="email_complete" value="Email Address" />
            <x-input id="email_complete" type="email" name="email" placeholder="you@example.com" required />
            <small class="text-xs text-on-surface-muted dark:text-on-surface-dark-muted">
                We'll never share your email with anyone else.
            </small>
        </div>
    </div>

    <h2>Livewire Integration</h2>
    <p>Use <code>wire:model</code> for two-way data binding in Livewire components:</p>
    <pre><code class="language-html">&lt;div class="max-w-xs"&gt;
    &lt;x-input-label for="title" value="Post Title" /&gt;
    &lt;x-input 
        id="title"
        type="text" 
        name="title" 
        wire:model.live="title"
        placeholder="Enter post title" /&gt;
&lt;/div&gt;</code></pre>

    <p>In your Livewire component:</p>
    <pre><code class="language-php">class CreatePost extends Component
{
    public string $title = '';

    public function save()
    {
        $this->validate([
            'title' => 'required|min:3|max:255',
        ]);
        
        Post::create([
            'title' => $this->title,
        ]);
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
                <td><code>variant</code></td>
                <td>string</td>
                <td><code>text</code></td>
                <td>Input variant. Options: <code>text</code>, <code>password</code>, <code>search</code>,
                    <code>date</code>
                </td>
            </tr>
            <tr>
                <td><code>disabled</code></td>
                <td>bool</td>
                <td><code>false</code></td>
                <td>Whether the input is disabled. Prevents user interaction and reduces opacity.</td>
            </tr>
            <tr>
                <td><code>viewable</code></td>
                <td>bool</td>
                <td><code>true</code></td>
                <td>Only applies to <code>password</code> variant. When <code>true</code>, shows a toggle button to
                    reveal/hide the password.</td>
            </tr>
            <tr>
                <td><code>error</code></td>
                <td>bool</td>
                <td><code>false</code></td>
                <td>When <code>true</code>, applies error styling with a red border to indicate validation failure.</td>
            </tr>
            <tr>
                <td><code>type</code></td>
                <td>string</td>
                <td>-</td>
                <td>Standard HTML input type attribute. Common values: <code>text</code>, <code>email</code>,
                    <code>number</code>, <code>tel</code>, <code>url</code>, etc.
                </td>
            </tr>
            <tr>
                <td><code>name</code></td>
                <td>string</td>
                <td>-</td>
                <td>Input field name for form submission and validation.</td>
            </tr>
            <tr>
                <td><code>placeholder</code></td>
                <td>string</td>
                <td>-</td>
                <td>Placeholder text displayed when the input is empty.</td>
            </tr>
            <tr>
                <td><code>value</code></td>
                <td>string</td>
                <td>-</td>
                <td>Initial value of the input field.</td>
            </tr>
            <tr>
                <td><code>required</code></td>
                <td>bool</td>
                <td><code>false</code></td>
                <td>Whether the input is required for form submission.</td>
            </tr>
            <tr>
                <td><code>wire:model</code></td>
                <td>string</td>
                <td>-</td>
                <td>Livewire property binding. Use <code>wire:model.live</code> for real-time updates or
                    <code>wire:model.blur</code> for updates on blur.
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
                <td><strong>resources/views/components/input.blade.php</strong></td>
                <td>Input component file</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Component</x-badge></td>
                <td><strong>resources/views/components/input-label.blade.php</strong></td>
                <td>Input label component</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Component</x-badge></td>
                <td><strong>resources/views/components/input-error.blade.php</strong></td>
                <td>Input error message component</td>
            </tr>
        </tbody>
    </table>

    <p class="pt-8 text-on-surface-muted dark:text-on-surface-muted-dark text-sm">For the detailed documentation, please
        visit the <a href="https://www.penguinui.com/components/text-input" target="_blank">Penguin UI Inputs</a>.</p>

</x-layouts.docs>
