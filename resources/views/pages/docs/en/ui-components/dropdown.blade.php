@push('head')
    <title>Dropdown Component - {{ config('app.name') }}</title>
    <meta name="description"
        content="Learn how to use the Dropdown component. A fully accessible dropdown menu with keyboard navigation, focus trapping, and multiple alignment options.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'UI Components', 'url' => '#'], ['label' => 'Dropdown', 'url' => '#']]">

    <h1>Dropdown Component</h1>
    <p>The Dropdown component provides a fully accessible menu with keyboard navigation, focus trapping, and smooth
        transitions. It uses Alpine.js for state management and includes support for keyboard shortcuts (Space, Enter,
        Arrow keys, and Escape).</p>

    <h2>Usage</h2>
    <p>The dropdown component uses named slots for the trigger and content:</p>
    <pre><code class="language-html">&lt;x-dropdown&gt;
    &lt;x-slot:trigger&gt;
        &lt;x-button&gt;Open Menu&lt;/x-button&gt;
    &lt;/x-slot:trigger&gt;

    &lt;x-slot:content&gt;
        &lt;x-dropdown-link href="/profile"&gt;Profile&lt;/x-dropdown-link&gt;
        &lt;x-dropdown-link href="/settings"&gt;Settings&lt;/x-dropdown-link&gt;
        &lt;x-dropdown-link href="/logout"&gt;Logout&lt;/x-dropdown-link&gt;
    &lt;/x-slot:content&gt;
&lt;/x-dropdown&gt;</code></pre>

    <div class="my-6 not-prose">
        <x-dropdown>
            <x-slot:trigger>
                <x-button>Open Menu</x-button>
            </x-slot:trigger>

            <x-slot:content>
                <x-dropdown-link href="#">Profile</x-dropdown-link>
                <x-dropdown-link href="#">Settings</x-dropdown-link>
                <x-dropdown-link href="#">Logout</x-dropdown-link>
            </x-slot:content>
        </x-dropdown>
    </div>

    <h2>Alignment</h2>
    <p>Control where the dropdown appears relative to the trigger using the <code>align</code> prop:</p>
    <pre><code class="language-html">&lt;x-dropdown align="left"&gt;
    &lt;!-- ... --&gt;
&lt;/x-dropdown&gt;

&lt;x-dropdown align="right"&gt;
    &lt;!-- ... --&gt;
&lt;/x-dropdown&gt;</code></pre>

    <div class="my-6 not-prose flex gap-4">
        <x-dropdown align="left">
            <x-slot:trigger>
                <x-button>Left Aligned</x-button>
            </x-slot:trigger>

            <x-slot:content>
                <x-dropdown-link href="#">Option 1</x-dropdown-link>
                <x-dropdown-link href="#">Option 2</x-dropdown-link>
                <x-dropdown-link href="#">Option 3</x-dropdown-link>
            </x-slot:content>
        </x-dropdown>

        <x-dropdown align="right">
            <x-slot:trigger>
                <x-button>Right Aligned</x-button>
            </x-slot:trigger>

            <x-slot:content>
                <x-dropdown-link href="#">Option 1</x-dropdown-link>
                <x-dropdown-link href="#">Option 2</x-dropdown-link>
                <x-dropdown-link href="#">Option 3</x-dropdown-link>
            </x-slot:content>
        </x-dropdown>
    </div>

    <h2>Width</h2>
    <p>Customize the dropdown width using the <code>width</code> prop. The default is <code>48</code> (w-48), but you
        can pass any Tailwind width class:</p>
    <pre><code class="language-html">&lt;x-dropdown width="w-64"&gt;
    &lt;!-- ... --&gt;
&lt;/x-dropdown&gt;</code></pre>

    <div class="my-6 not-prose">
        <x-dropdown width="w-64">
            <x-slot:trigger>
                <x-button>Wide Dropdown</x-button>
            </x-slot:trigger>

            <x-slot:content>
                <x-dropdown-link href="#">This is a wider dropdown menu</x-dropdown-link>
                <x-dropdown-link href="#">With more space for content</x-dropdown-link>
            </x-slot:content>
        </x-dropdown>
    </div>

    <h2>With Icons</h2>
    <p>Add icons to dropdown items for better visual context:</p>
    <pre><code class="language-html">&lt;x-dropdown&gt;
    &lt;x-slot:trigger&gt;
        &lt;x-button&gt;Account&lt;/x-button&gt;
    &lt;/x-slot:trigger&gt;

    &lt;x-slot:content&gt;
        &lt;x-dropdown-link href="/profile"&gt;
            &lt;x-icons.user /&gt;
            Profile
        &lt;/x-dropdown-link&gt;
        &lt;x-dropdown-link href="/settings"&gt;
            &lt;x-icons.cog-6-tooth /&gt;
            Settings
        &lt;/x-dropdown-link&gt;
    &lt;/x-slot:content&gt;
&lt;/x-dropdown&gt;</code></pre>

    <div class="my-6 not-prose">
        <x-dropdown>
            <x-slot:trigger>
                <x-button>Account</x-button>
            </x-slot:trigger>

            <x-slot:content>
                <x-dropdown-link href="#">
                    <x-icons.user  variant="mini" size="sm" />
                    Profile
                </x-dropdown-link>
                <x-dropdown-link href="#">
                    <x-icons.cog-6-tooth variant="mini" size="sm" />
                    Settings
                </x-dropdown-link>
                <x-dropdown-link href="#">
                    <x-icons.arrow-right-start-on-rectangle variant="mini" size="sm" />
                    Logout
                </x-dropdown-link>
            </x-slot:content>
        </x-dropdown>
    </div>

    <h2>Props Reference</h2>

    <h3>Dropdown</h3>
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
                <td><code>align</code></td>
                <td>string</td>
                <td><code>right</code></td>
                <td>Alignment of the dropdown. Options: <code>left</code>, <code>right</code>, <code>top</code>, or any
                    custom Tailwind classes</td>
            </tr>
            <tr>
                <td><code>width</code></td>
                <td>string</td>
                <td><code>48</code></td>
                <td>Width of the dropdown. Use <code>48</code> for <code>w-48</code> or pass any Tailwind width class
                    like <code>w-64</code></td>
            </tr>
            <tr>
                <td><code>contentClasses</code></td>
                <td>string</td>
                <td>Default styling</td>
                <td>Custom classes for the dropdown content container. Override the default styling if needed.</td>
            </tr>
        </tbody>
    </table>

    <h3>Dropdown Link</h3>
    <p>The dropdown link component extends the standard <code>&lt;a&gt;</code> tag and accepts all anchor attributes
        (<code>href</code>, <code>target</code>, etc.).</p>


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
                <td><strong>resources/views/components/dropdown.blade.php</strong></td>
                <td>Main dropdown component</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Component</x-badge></td>
                <td><strong>resources/views/components/dropdown-link.blade.php</strong></td>
                <td>Styled link component for dropdown items</td>
            </tr>
        </tbody>
    </table>

    <p class="pt-8 text-on-surface-muted dark:text-on-surface-muted-dark text-sm">For the detailed documentation, please
        visit the <a href="https://www.penguinui.com/components/dropdown" target="_blank">Penguin UI Dropdowns</a>.</p>

</x-layouts.docs>
