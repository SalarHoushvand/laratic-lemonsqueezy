@push('head')
    <title>Input File Component - {{ config('app.name') }}</title>
    <meta name="description"
        content="Learn how to use the Input File component. A flexible file upload component powered by Cloudinary with Livewire integration and error handling.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'UI Components', 'url' => '#'], ['label' => 'Input File', 'url' => '#']]">

    <h1>Input File Component</h1>
    <p>The Input File component provides a seamless file upload experience powered by Cloudinary. It supports custom labels, error handling, and automatic Livewire property updates.</p>

    <h2>Basic Usage</h2>
    <p>The simplest way to use the input-file component:</p>
    <pre><code class="language-html">&lt;x-input-file name="avatar" /&gt;</code></pre>

    <div class="my-6 not-prose">
        <x-input-file name="avatar" />
    </div>

    <h2>With Custom Label</h2>
    <p>Customize the upload button text using the <code>label</code> prop:</p>
    <pre><code class="language-html">&lt;x-input-file name="profile_image" label="Upload Profile Photo" /&gt;</code></pre>

    <div class="my-6 not-prose">
        <x-input-file name="profile_image" label="Upload Profile Photo" />
    </div>


    <h2>Livewire Integration</h2>
    <p>Automatically update a Livewire component property when a file is uploaded using the <code>target</code> and <code>componentId</code> props:</p>
    <pre><code class="language-html">&lt;x-input-file 
    name="avatar" 
    label="Upload Avatar"
    target="avatarUrl" 
    :componentId="$this->getId()" /&gt;</code></pre>

    <p>In your Livewire component:</p>
    <pre><code class="language-php">class ProfileSettings extends Component
{
    public string $avatarUrl = '';

    public function save()
    {
        // $this->avatarUrl will automatically contain the uploaded file URL
        $this->validate([
            'avatarUrl' => 'required|url',
        ]);
        
        auth()->user()->update([
            'avatar' => $this->avatarUrl,
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
                <td><code>name</code></td>
                <td>string</td>
                <td>-</td>
                <td>Input field name. Used for validation error display.</td>
            </tr>
            <tr>
                <td><code>label</code></td>
                <td>string|null</td>
                <td><code>null</code></td>
                <td>Text label for the default upload button. Defaults to "Upload File" if not provided and slot is empty.</td>
            </tr>
            <tr>
                <td><code>error</code></td>
                <td>bool</td>
                <td><code>false</code></td>
                <td>Manually set error state. When <code>true</code>, displays the component in an error state.</td>
            </tr>
            <tr>
                <td><code>errorMessage</code></td>
                <td>string|array|null</td>
                <td><code>null</code></td>
                <td>Custom error message(s) to display. Can be a string or array of strings. Overrides validation errors.</td>
            </tr>
            <tr>
                <td><code>target</code></td>
                <td>string|null</td>
                <td><code>null</code></td>
                <td>Livewire property name to update with the uploaded file URL. Requires <code>componentId</code>.</td>
            </tr>
            <tr>
                <td><code>componentId</code></td>
                <td>string|null</td>
                <td><code>null</code></td>
                <td>Livewire component ID. Use <code>$this->getId()</code> in Livewire components. Requires <code>target</code>.</td>
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
                <td>Optional custom upload button content. When provided, replaces the default upload button. The slot content will be wrapped with the Cloudinary upload widget functionality.</td>
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
                <td><strong>resources/views/components/input-file.blade.php</strong></td>
                <td>Input File component file</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-info">Package</x-badge></td>
                <td><strong>cloudinary-labs/cloudinary-laravel</strong></td>
                <td>Cloudinary Laravel integration package</td>
            </tr>
        </tbody>
    </table>

</x-layouts.docs>

