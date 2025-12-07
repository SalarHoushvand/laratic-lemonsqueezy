@push('head')
    <title>Line Chart Component - {{ config('app.name') }}</title>
    <meta name="description"
        content="Learn how to use the Line Chart component. A simple and flexible chart component powered by ApexCharts with dark mode support.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'UI Components', 'url' => '#'], ['label' => 'Line Chart', 'url' => '#']]">

    <h1>Line Chart Component</h1>
    <p>The Line Chart component is powered by ApexCharts and provides an easy way to display data visualizations.</p>

    <h2>Basic Usage</h2>
    <p>The simplest way to use the line chart component:</p>
    <pre><code class="language-html">&lt;x-line-chart 
    :data="[10, 20, 15, 30, 25]" 
    :categories="['Jan', 'Feb', 'Mar', 'Apr', 'May']" /&gt;</code></pre>

    <div class="my-6 not-prose">
        <x-line-chart 
            :data="[10, 20, 15, 30, 25]" 
            :categories="['Jan', 'Feb', 'Mar', 'Apr', 'May']" />
    </div>

    <h2>With Currency Formatting</h2>
    <p>Add currency formatting to the y-axis and tooltips:</p>
    <pre><code class="language-html">&lt;x-line-chart 
    :data="[1200, 1900, 1500, 2800, 2200]" 
    :categories="['Jan', 'Feb', 'Mar', 'Apr', 'May']"
    currency="$" /&gt;</code></pre>

    <div class="my-6 not-prose">
        <x-line-chart 
            :data="[1200, 1900, 1500, 2800, 2200]" 
            :categories="['Jan', 'Feb', 'Mar', 'Apr', 'May']"
            currency="$" />
    </div>

    <h2>Custom Height</h2>
    <p>Adjust the chart height using the <code>height</code> prop:</p>
    <pre><code class="language-html">&lt;x-line-chart 
    :data="[10, 20, 15, 30, 25, 35, 28]" 
    :categories="['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']"
    height="350" /&gt;</code></pre>

    <div class="my-6 not-prose">
        <x-line-chart 
            :data="[10, 20, 15, 30, 25, 35, 28]" 
            :categories="['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']"
            height="350" />
    </div>

   

    <h2>Livewire Example</h2>
    <p>Use dynamic data from a Livewire component:</p>
    <pre><code class="language-html">&lt;x-line-chart 
    :data="$data" 
    :categories="$categories"
    currency="$"
    color="primary" /&gt;</code></pre>

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
                <td><code>data</code></td>
                <td>array</td>
                <td>-</td>
                <td>Required. Array of numeric values for the chart data points.</td>
            </tr>
            <tr>
                <td><code>categories</code></td>
                <td>array</td>
                <td>-</td>
                <td>Required. Array of labels for the x-axis. Should match the length of data array.</td>
            </tr>
            <tr>
                <td><code>height</code></td>
                <td>string</td>
                <td><code>250</code></td>
                <td>Height of the chart in pixels.</td>
            </tr>
            <tr>
                <td><code>toolbar</code></td>
                <td>bool</td>
                <td><code>false</code></td>
                <td>Show or hide the ApexCharts toolbar (download, zoom, etc.).</td>
            </tr>
            <tr>
                <td><code>dataLabels</code></td>
                <td>bool</td>
                <td><code>false</code></td>
                <td>Show or hide data values on each point.</td>
            </tr>
            <tr>
                <td><code>currency</code></td>
                <td>string|null</td>
                <td><code>null</code></td>
                <td>Currency symbol to prepend to values. Example: <code>$</code>, <code>€</code>, <code>£</code></td>
            </tr>
            <tr>
                <td><code>id</code></td>
                <td>string</td>
                <td>Auto-generated</td>
                <td>Unique ID for the chart element. Auto-generates if not provided.</td>
            </tr>
            <tr>
                <td><code>color</code></td>
                <td>string</td>
                <td><code>primary</code></td>
                <td>Color variant for the line. Options: <code>primary</code>, <code>success</code>, <code>danger</code>, <code>warning</code>, <code>info</code></td>
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
                <td><strong>resources/views/components/line-chart.blade.php</strong></td>
                <td>Line Chart component file</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-info">Library</x-badge></td>
                <td><strong>ApexCharts</strong></td>
                <td>Charting library used for rendering</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-info">Script</x-badge></td>
                <td><strong>resources/js/charts.js</strong></td>
                <td>Charts initialization script</td>
            </tr>
        </tbody>
    </table>

</x-layouts.docs>

