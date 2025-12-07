@push('head')
    <title>Newsletter - {{ config('app.name') }}</title>
    <meta name="description" content="Learn how to use the newsletter subscription component with Mailchimp integration. A simple Livewire component you can drop anywhere in your application.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'Newsletter', 'url' => '#']]">

    <h1>Newsletter</h1>
    <p>The newsletter subscription component is a simple, ready-to-use Livewire component that integrates with Mailchimp to collect email subscriptions.</p>

    <h2>Requirements</h2>
    <p>To use the newsletter component, ensure the following:</p>
    <ul>
        <li>
            Spatie Laravel Newsletter package is installed. Please refer to the <a href="https://github.com/spatie/laravel-newsletter" target="_blank">Spatie Laravel Newsletter documentation</a> for installation instructions.
        </li>
        <li>
            Mailchimp API key and List ID are set in your <code>.env</code> file:
            <pre><code class="language-ini">NEWSLETTER_API_KEY=your-mailchimp-api-key
NEWSLETTER_LIST_ID=your-mailchimp-list-id
</code></pre>
        </li>
    </ul>

    <h2>How It Works</h2>
    <p>The component uses the <a href="https://github.com/spatie/laravel-newsletter" target="_blank">Spatie Laravel Newsletter</a> package to interface with Mailchimp's API. When a user submits their email address.</p>
   

    <h2>Mailchimp Setup</h2>
    <p>Before using the newsletter component, you need to set up your Mailchimp account and configure the required environment variables.</p>

    <h3>Step 1: Get Your Mailchimp API Key</h3>
    <ol>
        <li>Log in to your <a href="https://mailchimp.com" target="_blank">Mailchimp account</a></li>
        <li>Navigate to <strong>Account &gt; Extras &gt; API keys</strong></li>
        <li>If you don't have an API key, click <strong>Create A Key</strong></li>
        <li>Copy the generated API key (it will look like: <code>xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-us1</code>)</li>
    </ol>

    <h3>Step 2: Get Your Mailchimp List ID</h3>
    <ol>
        <li>In your Mailchimp dashboard, go to <strong>Audience &gt; More Options &gt; Audiance Settings</strong></li>
        <li>Scroll down to find your <strong>Audiance ID</strong></li>
        <li>Copy the List ID (it will look like: <code>a1b2c3d4e5</code>)</li>
    </ol>
    <p><strong>Note:</strong> If you don't have a list yet, create one first by going to <strong>Audience &gt; Create Audience</strong>.</p>

    <h2>Usage</h2>
    <p>The newsletter component is a standard Livewire component that can be included anywhere in your Blade templates. Simply use the Livewire component directive:</p>
    <pre><code class="language-html">&lt;livewire:forms.newsletter /&gt;</code></pre>



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
                <td><x-badge variant="outline-primary">Livewire Component</x-badge></td>
                <td><strong>App\Livewire\Forms\Newsletter</strong></td>
                <td>Main newsletter subscription component</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">View</x-badge></td>
                <td><strong>resources/views/livewire/forms/newsletter.blade.php</strong></td>
                <td>Newsletter form template</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Config</x-badge></td>
                <td><strong>config/newsletter.php</strong></td>
                <td>Newsletter and Mailchimp configuration</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Package</x-badge></td>
                <td><strong>spatie/laravel-newsletter</strong></td>
                <td>Third-party package providing Mailchimp integration</td>
            </tr>
        </tbody>
    </table>

</x-layouts.docs>

