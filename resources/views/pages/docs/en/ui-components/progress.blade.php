@push('head')
    <title>Progress Component - {{ config('app.name') }}</title>
    <meta name="description"
        content="Learn how to use the Progress component. A visual progress indicator with multiple variants and optional labels.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'UI Components', 'url' => '#'], ['label' => 'Progress', 'url' => '#']]">

    <h1>Progress Component</h1>
    <p>The Progress component provides a visual indicator for task completion or progress tracking.</p>

    <h2>Usage</h2>
    <p>Basic progress bar with default styling:</p>

    <pre><code class="language-html">&lt;x-progress :value="40" /&gt;</code></pre>

    <div class="my-6 not-prose">
        <x-progress :value="40" />
    </div>

    <h2>With Label and Percentage</h2>
    <p>Display a label and percentage indicator above the progress bar:</p>

    <pre><code class="language-html">&lt;x-progress 
    label="Progress" 
    :value="20" 
    :showPercentage="true" 
/&gt;</code></pre>

    <div class="my-6 not-prose">
        <x-progress label="Progress" :value="20" :showPercentage="true" />
    </div>

    <h2>Variants</h2>
    <p>The progress bar supports multiple color variants:</p>

    <h3>Primary</h3>
    <pre><code class="language-html">&lt;x-progress variant="primary" :value="40" /&gt;</code></pre>
    <div class="my-6 not-prose">
        <x-progress variant="primary" :value="40" />
    </div>

    <h3>Secondary</h3>
    <pre><code class="language-html">&lt;x-progress variant="secondary" :value="40" /&gt;</code></pre>
    <div class="my-6 not-prose">
        <x-progress variant="secondary" :value="40" />
    </div>

    <h3>Success</h3>
    <pre><code class="language-html">&lt;x-progress variant="success" :value="40" /&gt;</code></pre>
    <div class="my-6 not-prose">
        <x-progress variant="success" :value="40" />
    </div>

    <h3>Info</h3>
    <pre><code class="language-html">&lt;x-progress variant="info" :value="40" /&gt;</code></pre>
    <div class="my-6 not-prose">
        <x-progress variant="info" :value="40" />
    </div>

    <h3>Warning</h3>
    <pre><code class="language-html">&lt;x-progress variant="warning" :value="40" /&gt;</code></pre>
    <div class="my-6 not-prose">
        <x-progress variant="warning" :value="40" />
    </div>

    <h3>Danger</h3>
    <pre><code class="language-html">&lt;x-progress variant="danger" :value="40" /&gt;</code></pre>
    <div class="my-6 not-prose">
        <x-progress variant="danger" :value="40" />
    </div>

    <h2>Custom Range</h2>
    <p>Define custom minimum and maximum values:</p>

    <pre><code class="language-html">&lt;x-progress 
    label="Upload Progress" 
    :value="350" 
    :min="0" 
    :max="500" 
    :showPercentage="true"
    variant="success"
/&gt;</code></pre>

    <div class="my-6 not-prose">
        <x-progress label="Upload Progress" :value="350" :min="0" :max="500" :showPercentage="true"
            variant="success" />
    </div>

    <h2>Livewire Integration</h2>
    <p>Bind the progress value to Livewire properties:</p>

    <pre><code class="language-html">&lt;x-progress 
    label="Processing" 
    :value="$uploadProgress" 
    :showPercentage="true"
    variant="info"
/&gt;</code></pre>

    <pre><code class="language-php">class FileUpload extends Component
{
    public int $uploadProgress = 0;

    public function updatedFile(): void
    {
        // Simulate upload progress
        $this->uploadProgress = 25;
        
        // Process file...
        
        $this->uploadProgress = 100;
    }

    public function render(): View
    {
        return view('livewire.file-upload');
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
                <td><code>value</code></td>
                <td>int</td>
                <td><code>20</code></td>
                <td>Current progress value</td>
            </tr>
            <tr>
                <td><code>min</code></td>
                <td>int</td>
                <td><code>0</code></td>
                <td>Minimum value</td>
            </tr>
            <tr>
                <td><code>max</code></td>
                <td>int</td>
                <td><code>100</code></td>
                <td>Maximum value</td>
            </tr>
            <tr>
                <td><code>label</code></td>
                <td>string|null</td>
                <td><code>null</code></td>
                <td>Label text displayed above the progress bar</td>
            </tr>
            <tr>
                <td><code>showPercentage</code></td>
                <td>bool</td>
                <td><code>false</code></td>
                <td>Whether to display the percentage indicator</td>
            </tr>
            <tr>
                <td><code>variant</code></td>
                <td>string</td>
                <td><code>primary</code></td>
                <td>Color variant: <code>primary</code>, <code>secondary</code>, <code>success</code>, <code>info</code>,
                    <code>warning</code>, <code>danger</code>
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
                <td><strong>resources/views/components/progress.blade.php</strong></td>
                <td>Progress component file</td>
            </tr>
        </tbody>
    </table>

</x-layouts.docs>

