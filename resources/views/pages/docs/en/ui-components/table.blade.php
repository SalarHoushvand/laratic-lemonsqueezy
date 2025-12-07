@push('head')
    <title>Table Component - {{ config('app.name') }}</title>
    <meta name="description"
        content="Learn how to use the Table component. A responsive table component with styled headers and rows.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'UI Components', 'url' => '#'], ['label' => 'Table', 'url' => '#']]">

    <h1>Table Component</h1>
    <p>The Table component provides a styled, responsive table with bordered rows and dark mode support.</p>

    <h2>Basic Usage</h2>
    <p>Create a table with head and body slots:</p>
    <pre><code class="language-html">&lt;x-table&gt;
    &lt;x-slot:head&gt;
        &lt;th&gt;Name&lt;/th&gt;
        &lt;th&gt;Email&lt;/th&gt;
        &lt;th&gt;Role&lt;/th&gt;
    &lt;/x-slot:head&gt;

    &lt;x-slot:body&gt;
        &lt;tr&gt;
            &lt;td&gt;John Doe&lt;/td&gt;
            &lt;td&gt;john@example.com&lt;/td&gt;
            &lt;td&gt;Admin&lt;/td&gt;
        &lt;/tr&gt;
        &lt;tr&gt;
            &lt;td&gt;Jane Smith&lt;/td&gt;
            &lt;td&gt;jane@example.com&lt;/td&gt;
            &lt;td&gt;Editor&lt;/td&gt;
        &lt;/tr&gt;
        &lt;tr&gt;
            &lt;td&gt;Bob Johnson&lt;/td&gt;
            &lt;td&gt;bob@example.com&lt;/td&gt;
            &lt;td&gt;Viewer&lt;/td&gt;
        &lt;/tr&gt;
    &lt;/x-slot:body&gt;
&lt;/x-table&gt;</code></pre>

    <div class="my-6 not-prose">
        <x-table>
            <x-slot:head>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
            </x-slot:head>

            <x-slot:body>
                <tr>
                    <td>John Doe</td>
                    <td>john@example.com</td>
                    <td>Admin</td>
                </tr>
                <tr>
                    <td>Jane Smith</td>
                    <td>jane@example.com</td>
                    <td>Editor</td>
                </tr>
                <tr>
                    <td>Bob Johnson</td>
                    <td>bob@example.com</td>
                    <td>Viewer</td>
                </tr>
            </x-slot:body>
        </x-table>
    </div>

    <h2>With Badges</h2>
    <p>Combine with other components for richer content:</p>
    <pre><code class="language-html">&lt;x-table&gt;
    &lt;x-slot:head&gt;
        &lt;th&gt;Product&lt;/th&gt;
        &lt;th&gt;Status&lt;/th&gt;
        &lt;th&gt;Price&lt;/th&gt;
    &lt;/x-slot:head&gt;

    &lt;x-slot:body&gt;
        &lt;tr&gt;
            &lt;td&gt;Premium Plan&lt;/td&gt;
            &lt;td&gt;&lt;x-badge variant="success"&gt;Active&lt;/x-badge&gt;&lt;/td&gt;
            &lt;td&gt;$99/mo&lt;/td&gt;
        &lt;/tr&gt;
        &lt;tr&gt;
            &lt;td&gt;Basic Plan&lt;/td&gt;
            &lt;td&gt;&lt;x-badge variant="warning"&gt;Pending&lt;/x-badge&gt;&lt;/td&gt;
            &lt;td&gt;$29/mo&lt;/td&gt;
        &lt;/tr&gt;
        &lt;tr&gt;
            &lt;td&gt;Enterprise&lt;/td&gt;
            &lt;td&gt;&lt;x-badge variant="info"&gt;Trial&lt;/x-badge&gt;&lt;/td&gt;
            &lt;td&gt;$299/mo&lt;/td&gt;
        &lt;/tr&gt;
    &lt;/x-slot:body&gt;
&lt;/x-table&gt;</code></pre>

    <div class="my-6 not-prose">
        <x-table>
            <x-slot:head>
                <th>Product</th>
                <th>Status</th>
                <th>Price</th>
            </x-slot:head>

            <x-slot:body>
                <tr>
                    <td>Premium Plan</td>
                    <td><x-badge variant="success">Active</x-badge></td>
                    <td>$99/mo</td>
                </tr>
                <tr>
                    <td>Basic Plan</td>
                    <td><x-badge variant="warning">Pending</x-badge></td>
                    <td>$29/mo</td>
                </tr>
                <tr>
                    <td>Enterprise</td>
                    <td><x-badge variant="info">Trial</x-badge></td>
                    <td>$299/mo</td>
                </tr>
            </x-slot:body>
        </x-table>
    </div>

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
                <td><code>headClass</code></td>
                <td>string</td>
                <td><code>''</code></td>
                <td>Additional CSS classes for the table header.</td>
            </tr>
            <tr>
                <td><code>bodyClass</code></td>
                <td>string</td>
                <td><code>''</code></td>
                <td>Additional CSS classes for the table body.</td>
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
                <td><code>head</code></td>
                <td>Required. Table header content. Contains <code>&lt;th&gt;</code> elements.</td>
            </tr>
            <tr>
                <td><code>body</code></td>
                <td>Required. Table body content. Contains <code>&lt;tr&gt;</code> and <code>&lt;td&gt;</code> elements.</td>
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
                <td><strong>resources/views/components/table.blade.php</strong></td>
                <td>Table component file</td>
            </tr>
        </tbody>
    </table>

    <p class="pt-8 text-on-surface-muted dark:text-on-surface-muted-dark text-sm">For the detailed documentation, please
        visit the <a href="https://www.penguinui.com/components/table" target="_blank">Penguin UI Tables</a>.</p>
</x-layouts.docs>

