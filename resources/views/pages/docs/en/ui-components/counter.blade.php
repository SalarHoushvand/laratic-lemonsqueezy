@push('head')
    <title>Counter Component - {{ config('app.name') }}</title>
    <meta name="description"
        content="Learn how to use the Counter component. A numeric input with increment and decrement buttons.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'UI Components', 'url' => '#'], ['label' => 'Counter', 'url' => '#']]">

    <h1>Counter Component</h1>
    <p>The Counter component provides a numeric input with increment and decrement buttons for easy value adjustment.</p>

    <h2>Usage</h2>
    <p>Use the counter for numeric inputs with a defined range:</p>

    <pre><code class="language-html">&lt;x-counter 
    label="Items(s)" 
    :value="1" 
    :min="0" 
    :max="10" 
/&gt;</code></pre>

    <div class="my-6 not-prose">
        <x-counter label="Items(s)" :value="1" :min="0" :max="10" />
    </div>

    <h2>With Custom Step</h2>
    <p>Control the increment/decrement amount using the <code>step</code> prop:</p>

    <pre><code class="language-html">&lt;x-counter 
    label="Quantity" 
    :value="5" 
    :min="0" 
    :max="100" 
    :step="5"
/&gt;</code></pre>

    <div class="my-6 not-prose">
        <x-counter label="Quantity" :value="5" :min="0" :max="100" :step="5" />
    </div>

    <h2>Livewire Integration</h2>
    <p>Bind the counter to Livewire properties using <code>wire:model</code>:</p>

    <pre><code class="language-html">&lt;x-counter 
    label="Guest Count" 
    wire:model.live="guestCount"
    :min="1" 
    :max="20" 
/&gt;</code></pre>

    <pre><code class="language-php">class BookingForm extends Component
{
    public int $guestCount = 2;

    public function calculateTotal(): float
    {
        return $this->guestCount * 50.00;
    }

    public function render(): View
    {
        return view('livewire.booking-form', [
            'total' => $this->calculateTotal(),
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
                <td>Label text displayed above the counter</td>
            </tr>
            <tr>
                <td><code>value</code></td>
                <td>int</td>
                <td><code>1</code></td>
                <td>Initial value of the counter</td>
            </tr>
            <tr>
                <td><code>min</code></td>
                <td>int</td>
                <td><code>0</code></td>
                <td>Minimum allowed value</td>
            </tr>
            <tr>
                <td><code>max</code></td>
                <td>int</td>
                <td><code>10</code></td>
                <td>Maximum allowed value</td>
            </tr>
            <tr>
                <td><code>step</code></td>
                <td>int</td>
                <td><code>1</code></td>
                <td>Increment/decrement amount</td>
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
                <td><strong>resources/views/components/counter.blade.php</strong></td>
                <td>Counter component file</td>
            </tr>
        </tbody>
    </table>

    <p class="pt-8 text-on-surface-muted dark:text-on-surface-muted-dark text-sm">For the detailed documentation, please
        visit the <a href="https://www.penguinui.com/components/counter" target="_blank">Penguin UI Counters</a>.</p>

</x-layouts.docs>

