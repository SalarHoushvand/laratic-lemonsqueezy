@push('head')
    <title>Notification Component - {{ config('app.name') }}</title>
    <meta name="description"
        content="Learn how to use the Notification component. A toast notification system with multiple variants, auto-dismiss, and session flash support.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'UI Components', 'url' => '#'], ['label' => 'Notification', 'url' => '#']]">

    <h1>Notification Component</h1>
    <p>The Notification component provides a toast notification system.</p>

    <div class="my-6 rounded-radius border border-info bg-info/10 p-4 dark:border-info dark:bg-info/10">
        <p class="text-sm text-on-surface dark:text-on-surface-dark">
            <strong>Important:</strong> The notification component must be included in your layout file (e.g.,
            <code>resources/views/components/layouts/app.blade.php</code>) using <code>&lt;x-notification /&gt;</code> for
            it to work throughout your application.
        </p>
    </div>

    <h2>Usage</h2>
    <p>Once the notification component is included in your layout, you can trigger notifications from anywhere using
        JavaScript by dispatching the <code>notify</code> window event:</p>

    <pre><code class="language-javascript">window.dispatchEvent(new CustomEvent('notify', {
    detail: {
        variant: 'success',
        title: 'Success!',
        message: 'Your changes have been saved.',
        displayDuration: 8000
    }
}));</code></pre>

    <div class="my-6 not-prose">
        <x-button onclick="window.dispatchEvent(new CustomEvent('notify', { detail: { variant: 'success', title: 'Success!', message: 'This is a test notification.' } }))">
            Show Notification
        </x-button>
    </div>

    <h2>With Alpine.js</h2>
    <p>Trigger notifications from Alpine.js components using <code>window.dispatchEvent()</code>:</p>

    <pre><code class="language-html">&lt;div x-data="{ count: 0 }"&gt;
    &lt;x-button 
        x-on:click="
            count++;
            window.dispatchEvent(new CustomEvent('notify', {
                detail: {
                    variant: 'info',
                    title: 'Counter Updated',
                    message: `Count is now ${count}`
                }
            }))
        "
    &gt;
        Increment Counter
    &lt;/x-button&gt;
&lt;/div&gt;</code></pre>

    <div class="my-6 not-prose">
        <div x-data="{ count: 0 }">
            <x-button 
                x-on:click="
                    count++;
                    window.dispatchEvent(new CustomEvent('notify', {
                        detail: {
                            variant: 'info',
                            title: 'Counter Updated',
                            message: `Count is now ${count}`
                        }
                    }))
                ">
                Increment Counter
            </x-button>
        </div>
    </div>

    <h2>With Livewire</h2>
    <p>Dispatch notifications from Livewire components using the <code>dispatch()</code> method:</p>

    <pre><code class="language-php">
$this->dispatch('notify',
    variant: 'success',
    title: __('Status Updated'),
    message: __('Order status has been updated successfully.')
);
</code></pre>

    <h2>From Laravel (Session Flash)</h2>
    <p>Trigger notifications using session flash messages. This is useful for redirects after operations:</p>

    <pre><code class="language-php">
session()->flash('notification', [
    'variant' => 'success',
    'title' => __('User Deleted'),
    'message' => __('The user has been deleted successfully.'),
]);
</code></pre>

    <h2>Notification Variants</h2>
    <p>The notification system supports four variants, each with its own color scheme and icon:</p>

    <h3>Info</h3>
    <pre><code class="language-javascript">window.dispatchEvent(new CustomEvent('notify', {
    detail: {
        variant: 'info',
        title: 'Information',
        message: 'This is an informational message.'
    }
}));</code></pre>

    <div class="my-6 not-prose">
        <x-button variant="info" onclick="window.dispatchEvent(new CustomEvent('notify', { detail: { variant: 'info', title: 'Information', message: 'This is an informational message.' } }))">
            Show Info
        </x-button>
    </div>

    <h3>Success</h3>
    <pre><code class="language-javascript">window.dispatchEvent(new CustomEvent('notify', {
    detail: {
        variant: 'success',
        title: 'Success',
        message: 'Operation completed successfully!'
    }
}));</code></pre>

    <div class="my-6 not-prose">
        <x-button variant="success" onclick="window.dispatchEvent(new CustomEvent('notify', { detail: { variant: 'success', title: 'Success', message: 'Operation completed successfully!' } }))">
            Show Success
        </x-button>
    </div>

    <h3>Warning</h3>
    <pre><code class="language-javascript">window.dispatchEvent(new CustomEvent('notify', {
    detail: {
        variant: 'warning',
        title: 'Warning',
        message: 'Please review your input.'
    }
}));</code></pre>

    <div class="my-6 not-prose">
        <x-button variant="warning" onclick="window.dispatchEvent(new CustomEvent('notify', { detail: { variant: 'warning', title: 'Warning', message: 'Please review your input.' } }))">
            Show Warning
        </x-button>
    </div>

    <h3>Danger / Error</h3>
    <pre><code class="language-javascript">window.dispatchEvent(new CustomEvent('notify', {
    detail: {
        variant: 'danger', // or 'error'
        title: 'Error',
        message: 'Something went wrong.'
    }
}));</code></pre>

    <div class="my-6 not-prose">
        <x-button variant="danger" onclick="window.dispatchEvent(new CustomEvent('notify', { detail: { variant: 'danger', title: 'Error', message: 'Something went wrong.' } }))">
            Show Error
        </x-button>
    </div>

    <h2>From Laravel (Session Flash)</h2>
    <p>You can trigger notifications from Laravel using session flash messages. This is useful for redirects after form
        submissions:</p>

    <pre><code class="language-php">return redirect()->route('dashboard')->with('notification', [
    'variant' => 'success',
    'title' => 'Welcome back!',
    'message' => 'You have successfully logged in.',
    'displayDuration' => 5000,
]);</code></pre>

    <h2>Event Details</h2>
    <table>
        <thead>
            <tr>
                <th>Property</th>
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
                <td>Notification type. Options: <code>info</code>, <code>success</code>, <code>warning</code>,
                    <code>danger</code>, <code>error</code>
                </td>
            </tr>
            <tr>
                <td><code>title</code></td>
                <td>string|null</td>
                <td><code>null</code></td>
                <td>Notification title (optional)</td>
            </tr>
            <tr>
                <td><code>message</code></td>
                <td>string|null</td>
                <td><code>null</code></td>
                <td>Notification message body (optional)</td>
            </tr>
            <tr>
                <td><code>displayDuration</code></td>
                <td>int</td>
                <td><code>8000</code></td>
                <td>Duration in milliseconds before auto-dismiss (8000 = 8 seconds)</td>
            </tr>
            <tr>
                <td><code>sender</code></td>
                <td>string|null</td>
                <td><code>null</code></td>
                <td>Sender identifier (reserved for future use)</td>
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
                <td><strong>resources/views/components/notification.blade.php</strong></td>
                <td>Notification component file</td>
            </tr>
        </tbody>
    </table>

    <p class="pt-8 text-on-surface-muted dark:text-on-surface-muted-dark text-sm">For the detailed documentation, please
        visit the <a href="https://www.penguinui.com/components/toast-notification" target="_blank">Penguin UI Notifications</a>.</p>
</x-layouts.docs>

