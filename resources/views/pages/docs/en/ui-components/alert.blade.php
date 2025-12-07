@push('head')
    <title>Alert Component - {{ config('app.name') }}</title>
    <meta name="description"
        content="Learn how to use the Alert component. A flexible, accessible alert component with multiple variants, icons, and dismissible functionality.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'UI Components', 'url' => '#'], ['label' => 'Alert', 'url' => '#']]">

    <h1>Alert Component</h1>
    <p>The Alert component is a flexible, accessible component for displaying important messages that has to stay
        visible for a longer period of time.</p>
    <h2>Usage</h2>
    <p>The simplest way to use the alert component:</p>
    <pre><code class="language-html">&lt;x-alert&gt;
    This is a basic alert message.
&lt;/x-alert&gt;</code></pre>

    <div class="my-6 not-prose">
        <x-alert>
            This is a basic alert message.
        </x-alert>
    </div>

    <h2>Variants</h2>
    <p>The alert component supports four semantic variants to convey different types of messages:</p>
    <pre><code class="language-html">&lt;x-alert variant="info"&gt;Information message&lt;/x-alert&gt;
&lt;x-alert variant="success"&gt;Success message&lt;/x-alert&gt;
&lt;x-alert variant="warning"&gt;Warning message&lt;/x-alert&gt;
&lt;x-alert variant="danger"&gt;Danger message&lt;/x-alert&gt;</code></pre>

    <div class="space-y-4 my-6 not-prose">
        <x-alert variant="info">Information message</x-alert>
        <x-alert variant="success">Success message</x-alert>
        <x-alert variant="warning">Warning message</x-alert>
        <x-alert variant="danger">Danger message</x-alert>
    </div>

    <h2>With Title and Text</h2>
    <p>You can provide both a title and text for more structured alerts:</p>
    <pre><code class="language-html">&lt;x-alert variant="success" title="Payment Successful" text="Your payment has been processed successfully." /&gt;
&lt;x-alert variant="warning" title="Warning" text="Please review your settings before continuing." /&gt;</code></pre>

    <div class="space-y-4 my-6 not-prose">
        <x-alert variant="success" title="Payment Successful" text="Your payment has been processed successfully." />
        <x-alert variant="warning" title="Warning" text="Please review your settings before continuing." />
    </div>

    <h2>With Icons</h2>
    <p>Enable icons by setting the <code>showIcon</code> prop to <code>true</code>. Each variant has a default icon:</p>
    <pre><code class="language-html">&lt;x-alert variant="info" :showIcon="true" title="Info" text="This is an informational message." /&gt;
&lt;x-alert variant="success" :showIcon="true" title="Success" text="Operation completed successfully." /&gt;
&lt;x-alert variant="warning" :showIcon="true" title="Warning" text="Please be careful." /&gt;
&lt;x-alert variant="danger" :showIcon="true" title="Error" text="Something went wrong." /&gt;</code></pre>

    <div class="space-y-4 my-6 not-prose">
        <x-alert variant="info" :showIcon="true" title="Info" text="This is an informational message." />
        <x-alert variant="success" :showIcon="true" title="Success" text="Operation completed successfully." />
        <x-alert variant="warning" :showIcon="true" title="Warning" text="Please be careful." />
        <x-alert variant="danger" :showIcon="true" title="Error" text="Something went wrong." />
    </div>

    <h2>Dismissible Alerts</h2>
    <p>Make alerts dismissible by setting the <code>isDismissible</code> prop to <code>true</code>. Users can close the
        alert by clicking the dismiss button:</p>
    <pre><code class="language-html">&lt;x-alert variant="info" :isDismissible="true" title="Dismissible Alert" text="You can close this alert." /&gt;</code></pre>

    <div class="my-6 not-prose">
        <x-alert variant="info" :isDismissible="true" title="Dismissible Alert" text="You can close this alert." />
    </div>

    <h2>With Buttons</h2>
    <p>Add action buttons to alerts using the <code>button</code> prop. Combine with <code>href</code> for links, or
        pass Livewire directives like <code>wire:click</code> directly:</p>

    <h3>Button as Link</h3>
    <pre><code class="language-html">&lt;x-alert variant="info" title="New Feature Available" text="Check out our latest update."
    button="Learn More" href="/features" /&gt;</code></pre>

    <div class="my-6 not-prose">
        <x-alert variant="info" title="New Feature Available" text="Check out our latest update." button="Learn More"
            href="/features" />
    </div>

    <h3>Button with Livewire Action</h3>
    <pre><code class="language-html">&lt;x-alert variant="warning" title="Action Required" text="Please confirm your email address."
    button="Resend Email" wire:click="resendEmail" /&gt;</code></pre>

    <div class="my-6 not-prose">
        <x-alert variant="warning" title="Action Required" text="Please confirm your email address."
            button="Resend Email" wire:click="resendEmail" />
    </div>

    <h3>Button with Dismissible</h3>
    <p>When using buttons with dismissible alerts, a "Dismiss" button appears next to the action button:</p>
    <pre><code class="language-html">&lt;x-alert variant="success" :isDismissible="true" title="Update Available"
    text="A new version is available." button="Update Now" href="/update" /&gt;</code></pre>

    <div class="my-6 not-prose">
        <x-alert variant="success" :isDismissible="true" title="Update Available" text="A new version is available."
            button="Update Now" href="/update" />
    </div>

    <h2>Using Slots</h2>
    <p>You can use the default slot for custom content when you don't provide <code>title</code> or <code>text</code>
        props:</p>
    <pre><code class="language-html">&lt;x-alert variant="info"&gt;
    &lt;strong&gt;Custom Content&lt;/strong&gt;
    &lt;p&gt;You can put any HTML content here.&lt;/p&gt;
&lt;/x-alert&gt;</code></pre>

    <div class="my-6 not-prose">
        <x-alert variant="info">
            <strong>Custom Content</strong>
            <p>You can put any HTML content here.</p>
        </x-alert>
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
                <td><code>variant</code></td>
                <td>string</td>
                <td><code>info</code></td>
                <td>Visual style variant. Options: <code>info</code>, <code>success</code>, <code>warning</code>,
                    <code>danger</code>
                </td>
            </tr>
            <tr>
                <td><code>isDismissible</code></td>
                <td>bool</td>
                <td><code>false</code></td>
                <td>Whether the alert can be dismissed by the user. Adds a close button and Alpine.js transition
                    animations.</td>
            </tr>
            <tr>
                <td><code>showIcon</code></td>
                <td>bool</td>
                <td><code>false</code></td>
                <td>Whether to display an icon. Each variant has a default icon (info: information-circle, success:
                    check-circle, warning: exclamation-triangle, danger: x-circle).</td>
            </tr>
            <tr>
                <td><code>title</code></td>
                <td>string|null</td>
                <td><code>null</code></td>
                <td>Optional title text displayed in a heading. If not provided, the default slot will be used.</td>
            </tr>
            <tr>
                <td><code>text</code></td>
                <td>string|null</td>
                <td><code>null</code></td>
                <td>Optional body text displayed below the title. If neither title nor text is provided, the default
                    slot
                    will be used.</td>
            </tr>
            <tr>
                <td><code>button</code></td>
                <td>string|null</td>
                <td><code>null</code></td>
                <td>Text label for an optional action button. Combine with <code>href</code> for links, or pass
                    <code>wire:click</code> (or other wire directives) directly to the component for Livewire actions.
                </td>
            </tr>
            <tr>
                <td><code>href</code></td>
                <td>string|null</td>
                <td><code>null</code></td>
                <td>Optional URL for the button. When provided, the button renders as an anchor tag.</td>
            </tr>
            <tr>
                <td><code>wire:click</code></td>
                <td>string</td>
                <td>-</td>
                <td>Pass Livewire directives directly to the component. When <code>button</code> is provided
                    without <code>href</code>, wire directives will be applied to the button. Supports
                    <code>wire:click</code>, <code>wire:target</code>, <code>wire:loading</code>, and
                    <code>wire:confirm</code>.
                </td>
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
                <td>Custom content displayed when neither <code>title</code> nor <code>text</code> props are provided.
                    Allows for flexible HTML content.</td>
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
                <td><strong>resources/views/components/alert.blade.php</strong></td>
                <td>Alert component file</td>
            </tr>
        </tbody>
    </table>


    <p class="pt-8 text-on-surface-muted dark:text-on-surface-muted-dark text-sm">For the detailed documentation,
        please
        visit the <a href="https://www.penguinui.com/components/alerts" target="_blank">Penguin UI Alerts</a>.</p>

</x-layouts.docs>
