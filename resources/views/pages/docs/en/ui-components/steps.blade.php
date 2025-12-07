@push('head')
    <title>Steps Component - {{ config('app.name') }}</title>
    <meta name="description"
        content="Learn how to use the Steps component. A visual progress indicator for multi-step processes.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'UI Components', 'url' => '#'], ['label' => 'Steps', 'url' => '#']]">

    <h1>Steps Component</h1>
    <p>The Steps component provides a visual indicator for multi-step processes, showing completed, current, and pending
        steps with connecting lines.</p>

    <h2>Basic Usage</h2>
    <p>Define steps as an array of strings and specify the current step number:</p>

    <pre><code class="language-html">&lt;x-steps 
    :steps="[
        'Create an account',
        'Select a plan',
        'Checkout',
        'Get started'
    ]"
    :current="2"
/&gt;</code></pre>

    <div class="my-6 not-prose">
        <x-steps :steps="['Create an account', 'Select a plan', 'Checkout', 'Get started']" :current="2" />
    </div>

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
                <td><code>steps</code></td>
                <td>array</td>
                <td><code>[]</code></td>
                <td>Array of step labels as strings</td>
            </tr>
            <tr>
                <td><code>current</code></td>
                <td>int</td>
                <td><code>1</code></td>
                <td>The current active step number (1-based index)</td>
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
                <td><strong>resources/views/components/steps.blade.php</strong></td>
                <td>Steps component file</td>
            </tr>
        </tbody>
    </table>

    <p class="pt-8 text-on-surface-muted dark:text-on-surface-muted-dark text-sm">For the detailed documentation, please
        visit the <a href="https://www.penguinui.com/components/steps" target="_blank">Penguin UI Steps</a>.</p>

</x-layouts.docs>
