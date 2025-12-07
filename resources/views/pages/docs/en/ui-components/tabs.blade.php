@push('head')
    <title>Tabs Component - {{ config('app.name') }}</title>
    <meta name="description"
        content="Learn how to use the Tabs component. An accessible tab navigation component with keyboard support and smooth animations.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'UI Components', 'url' => '#'], ['label' => 'Tabs', 'url' => '#']]">

    <h1>Tabs Component</h1>
    <p>The Tabs component provides accessible tab navigation with keyboard support and animated underline indicators.</p>

    <h2>Basic Usage</h2>
    <p>Create tabs with an array of items and Alpine.js for state management:</p>
    <pre><code class="language-html">&lt;div x-data="{ selectedTab: 'profile' }"&gt;
    &lt;x-tabs 
        :items="[
            ['slug' => 'profile', 'label' => 'Profile'],
            ['slug' => 'settings', 'label' => 'Settings'],
            ['slug' => 'notifications', 'label' => 'Notifications']
        ]" 
        model="selectedTab" /&gt;

    &lt;div class="mt-4"&gt;
        &lt;div x-show="selectedTab === 'profile'"&gt;
            &lt;p&gt;Profile content here&lt;/p&gt;
        &lt;/div&gt;
        &lt;div x-show="selectedTab === 'settings'"&gt;
            &lt;p&gt;Settings content here&lt;/p&gt;
        &lt;/div&gt;
        &lt;div x-show="selectedTab === 'notifications'"&gt;
            &lt;p&gt;Notifications content here&lt;/p&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>

    <div class="my-6 not-prose" x-data="{ selectedTab: 'profile' }">
        <x-tabs 
            :items="[
                ['slug' => 'profile', 'label' => 'Profile'],
                ['slug' => 'settings', 'label' => 'Settings'],
                ['slug' => 'notifications', 'label' => 'Notifications']
            ]" 
            model="selectedTab" />

        <div class="mt-4 p-4 border border-outline dark:border-outline-dark rounded-radius bg-surface dark:bg-surface-dark">
            <div x-show="selectedTab === 'profile'">
                <h3 class="font-semibold mb-2">Profile</h3>
                <p class="text-sm">Manage your profile information and preferences.</p>
            </div>
            <div x-show="selectedTab === 'settings'" x-cloak>
                <h3 class="font-semibold mb-2">Settings</h3>
                <p class="text-sm">Configure your account settings and preferences.</p>
            </div>
            <div x-show="selectedTab === 'notifications'" x-cloak>
                <h3 class="font-semibold mb-2">Notifications</h3>
                <p class="text-sm">Manage your notification preferences.</p>
            </div>
        </div>
    </div>

    <h2>With Icons</h2>
    <p>Add icons to tabs for better visual hierarchy:</p>
    <pre><code class="language-html">&lt;div x-data="{ activeTab: 'dashboard' }"&gt;
    &lt;x-tabs 
        :items="[
            ['slug' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'icons.home'],
            ['slug' => 'users', 'label' => 'Users', 'icon' => 'icons.users'],
            ['slug' => 'reports', 'label' => 'Reports', 'icon' => 'icons.chart-bar']
        ]" 
        model="activeTab" /&gt;
&lt;/div&gt;</code></pre>

    <div class="my-6 not-prose" x-data="{ activeTab: 'dashboard' }">
        <x-tabs 
            :items="[
                ['slug' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'icons.home'],
                ['slug' => 'users', 'label' => 'Users', 'icon' => 'icons.users'],
                ['slug' => 'reports', 'label' => 'Reports', 'icon' => 'icons.chart-bar']
            ]" 
            model="activeTab" />

        <div class="mt-4 p-4 border border-outline dark:border-outline-dark rounded-radius bg-surface dark:bg-surface-dark">
            <div x-show="activeTab === 'dashboard'">
                <p class="text-sm">Dashboard overview and statistics.</p>
            </div>
            <div x-show="activeTab === 'users'" x-cloak>
                <p class="text-sm">User management and permissions.</p>
            </div>
            <div x-show="activeTab === 'reports'" x-cloak>
                <p class="text-sm">Analytics and reporting data.</p>
            </div>
        </div>
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
                <td><code>items</code></td>
                <td>array</td>
                <td><code>[]</code></td>
                <td>Required. Array of tab items. Each item should have <code>slug</code> (unique identifier), <code>label</code> (display text), and optional <code>icon</code> (icon component name).</td>
            </tr>
            <tr>
                <td><code>model</code></td>
                <td>string</td>
                <td><code>selectedTab</code></td>
                <td>Alpine.js model name for tracking the selected tab. Must match your x-data property.</td>
            </tr>
            <tr>
                <td><code>ariaLabel</code></td>
                <td>string</td>
                <td><code>tab options</code></td>
                <td>ARIA label for the tablist element for screen readers.</td>
            </tr>
            <tr>
                <td><code>panelPrefix</code></td>
                <td>string</td>
                <td><code>tabpanel-</code></td>
                <td>Prefix for tab panel IDs used in aria-controls attribute.</td>
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
                <td><strong>resources/views/components/tabs.blade.php</strong></td>
                <td>Tabs component file</td>
            </tr>
        </tbody>
    </table>

    <p class="pt-8 text-on-surface-muted dark:text-on-surface-muted-dark text-sm">For the detailed documentation, please
        visit the <a href="https://www.penguinui.com/components/tabs" target="_blank">Penguin UI Tabs</a>.</p>
</x-layouts.docs>

