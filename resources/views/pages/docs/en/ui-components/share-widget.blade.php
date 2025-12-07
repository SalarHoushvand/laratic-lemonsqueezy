@push('head')
    <title>Share Widget Component - {{ config('app.name') }}</title>
    <meta name="description"
        content="Learn how to use the Share Widget component. A social sharing component with native Web Share API support and fallback modal.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'UI Components', 'url' => '#'], ['label' => 'Share Widget', 'url' => '#']]">

    <h1>Share Widget Component</h1>
    <p>The Share Widget provides social sharing functionality with automatic fallback to a modal dialog when the native Web Share API is unavailable.</p>

    <h2>Usage</h2>
    <p>Wrap your trigger element with the share-widget component:</p>
    <pre><code class="language-html">&lt;x-share-widget&gt;
    &lt;x-slot:trigger&gt;
        &lt;x-button variant="outline" x-on:click="share()"&gt;
            &lt;x-icons.share variant="micro" size="sm" /&gt;
            Share
        &lt;/x-button&gt;
    &lt;/x-slot:trigger&gt;
&lt;/x-share-widget&gt;</code></pre>

    <div class="my-6 not-prose">
        <x-share-widget>
            <x-slot:trigger>
                <x-button variant="outline"  x-on:click="share()">
                    <x-icons.share variant="micro" size="sm" />
                    Share
                </x-button>
            </x-slot:trigger>
        </x-share-widget>
    </div>

    <h2>How It Works</h2>
    <p>The component automatically detects browser capabilities:</p>
    <ul>
        <li><strong>Web Share API Available:</strong> Opens the native share dialog (mobile devices, modern browsers)</li>
        <li><strong>No Web Share API:</strong> Opens a modal with social media share buttons and copy link functionality</li>
    </ul>

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
                <td><code>trigger</code></td>
                <td>Required. The clickable element that opens the share functionality (button, link, etc.).</td>
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
                <td><strong>resources/views/components/share-widget.blade.php</strong></td>
                <td>Share Widget component file</td>
            </tr>
        </tbody>
    </table>

</x-layouts.docs>

