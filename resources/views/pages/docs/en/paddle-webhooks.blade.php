@push('head')
    <title>Paddle Webhooks &amp; Testing - {{ config('app.name') }}</title>
    <meta name="description"
        content="Learn how to set up and test Paddle webhooks in {{ config('app.name') }} using ngrok for local development.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'Billing', 'url' => '#'], ['label' => 'Paddle Webhooks', 'url' => '#']]">

    <h1>Paddle Webhooks &amp; Testing</h1>
    <p class="text-on-surface-muted dark:text-on-surface-dark-muted">
        Configure webhooks in Paddle to receive events and keep your local database in sync. This guide walks you
        through
        setting up webhooks in the Paddle sandbox and testing them locally.
    </p>

    <h2>1. Set Up Webhook in Paddle Sandbox</h2>
    <p>To configure webhooks in the Paddle sandbox dashboard:</p>

    <ol>
        <li>Navigate to <strong>Developer Tools</strong> > <strong>Notifications</strong> in your Paddle sandbox
            dashboard.</li>
        <li>Click <strong>New Destination</strong> to create a new webhook destination.</li>
        <li>Enter your webhook URL. For local testing, you'll use an ngrok URL (see step 3 below).</li>
        <li>Enable the following events:
            <ul>
                <li>All of the <code>subscription</code> events</li>
                <li><code>price.created</code></li>
                <li><code>price.updated</code></li>
                <li><code>transaction.completed</code></li>
                <li><code>transaction.updated</code></li>
                <li><code>customer.updated</code></li>
            </ul>
        </li>
        <li>Copy the <strong>Webhook Secret</strong> that Paddle generates. You'll need this for your <code>.env</code>
            file.</li>
    </ol>

    <h2>2. Add Webhook Secret to Environment</h2>
    <p>Add the webhook secret to your <code>.env</code> file:</p>

    <pre><code class="language-ini">PADDLE_WEBHOOK_SECRET=your_webhook_secret_from_paddle
PADDLE_SANDBOX=true # For sandbox make sure you have this in env</code></pre>

    <p>After adding the secret, clear and cache your configuration:</p>

    <pre><code class="language-bash">php artisan config:clear
php artisan config:cache</code></pre>

    <h2>3. Test with ngrok (Requires Account)</h2>
    <p>
        <strong>Note:</strong> You need an ngrok account to use ngrok. Sign up for a free account at
        <a href="https://ngrok.com" target="_blank" rel="noopener noreferrer">ngrok.com</a> if you don't have one.
    </p>

    <ol>
        <li>Start your Laravel application locally:
            <pre><code class="language-bash">php artisan serve</code></pre>
        </li>
        <li>In a separate terminal, start ngrok to expose your local server (use the URL from the <code>php artisan
                serve</code> command):
            <pre><code class="language-bash">ngrok http http://127.0.0.1:8000</code></pre>
        </li>
        <li>Copy the HTTPS URL that ngrok provides (e.g., <code>https://abc123.ngrok-free.app</code>). and add
            <code>/paddle/webhook</code> to the end of the URL.
            <pre><code class="language-plaintext">https://your-ngrok-url.ngrok-free.app/paddle/webhook</code></pre>

            Add this URL to the Paddle Webhook destination in the Paddle dashboard.
        </li>
    </ol>

    <x-alert variant="info" title="Webhook Endpoint" class="my-6">
        <p class="text-sm">
            {{ config('app.name') }} has already added the paddle endpoint to bootstrap/app.php for you. This will
            exclude the webhook from CSRF protection. You can update this in the app.php file.

<pre><code class="language-php">$middleware->validateCsrfTokens(except: [
    'paddle/*',
]);
</code></pre>
        </p>
    </x-alert>

    <h2>4. Test with a Product</h2>
    <p>To verify webhooks are working:</p>

    <ol>
        <li>Create a test product in the Paddle sandbox dashboard.</li>
        <li>Add a price to the product. This will trigger a <code>price.created</code> webhook.</li>
        <li>Check your Laravel logs to see if the webhook was received, you can also check your database or products
            page to see if the product was created.</li>
        <li>Paddle also provides webhook logs to help you debug any issues.</li>
    </ol>

    <p>
        If you see log entries like "New product created from Paddle webhook" in your Laravel logs, and the webhook
        shows as successful in the Paddle dashboard, your webhook setup is working correctly!
    </p>

</x-layouts.docs>
