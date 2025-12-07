@push('head')
    <title>Range Slider Component - {{ config('app.name') }}</title>
    <meta name="description"
        content="Learn how to use the Range Slider component. A customizable range input with optional tick marks and flexible styling.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'UI Components', 'url' => '#'], ['label' => 'Range Slider', 'url' => '#']]">

    <h1>Range Slider Component</h1>
    <p>The Range Slider component provides a styled range input for numerical values.</p>

    <h2>Usage</h2>
    <p>Use the range slider for numerical inputs within a defined range:</p>

    <pre><code class="language-html">&lt;x-range-slider 
    label="Mood Meter" 
    :value="20" 
    :min="0" 
    :max="100" 
/&gt;</code></pre>

    <div class="my-6 not-prose">
        <x-range-slider label="Mood Meter" :value="20" :min="0" :max="100" />
    </div>

    <h2>Livewire Integration</h2>
    <p>Bind the range slider to Livewire properties using <code>wire:model</code>:</p>

    <pre><code class="language-html">&lt;x-range-slider 
    label="Price Range" 
    wire:model.live="priceLimit"
    :min="0" 
    :max="1000" 
    :step="10"
/&gt;</code></pre>

    <pre><code class="language-php">class ProductFilter extends Component
{
    public int $priceLimit = 500;

    public function render(): View
    {
        $products = Product::where('price', '&lt;=', $this->priceLimit)->get();

        return view('livewire.product-filter', compact('products'));
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
                <td>string</td>
                <td>Auto-generated</td>
                <td>The input ID attribute. Auto-generates unique ID if not provided</td>
            </tr>
            <tr>
                <td><code>name</code></td>
                <td>string|null</td>
                <td><code>null</code></td>
                <td>The input name attribute for form submission</td>
            </tr>
            <tr>
                <td><code>label</code></td>
                <td>string|null</td>
                <td><code>null</code></td>
                <td>Label text displayed above the slider</td>
            </tr>
            <tr>
                <td><code>value</code></td>
                <td>int</td>
                <td><code>50</code></td>
                <td>Initial value of the slider</td>
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
                <td><code>step</code></td>
                <td>int</td>
                <td><code>1</code></td>
                <td>Increment value when sliding</td>
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
                <td><strong>resources/views/components/range-slider.blade.php</strong></td>
                <td>Range Slider component file</td>
            </tr>
        </tbody>
    </table>

</x-layouts.docs>

