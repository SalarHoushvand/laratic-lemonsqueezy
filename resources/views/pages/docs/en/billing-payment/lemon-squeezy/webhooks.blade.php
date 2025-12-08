@push('head')
    <title>Lemon Squeezy Webhooks - {{ config('app.name') }}</title>
    <meta name="description" content="Learn how to configure Lemon Squeezy webhooks in {{ config('app.name') }}.">
@endpush

<x-layouts.docs :breadcrumbs="[
    ['label' => 'Billing & Payments', 'url' => '#'],
    ['label' => 'Lemon Squeezy', 'url' => '#'],
    ['label' => 'Webhooks', 'url' => '#'],
]">

    <h1>Lemon Squeezy Webhooks</h1>
    <p class="text-on-surface-muted dark:text-on-surface-dark-muted">
        {{ config('app.name') }} is already configured to handle Lemon Squeezy webhooks. You just need to set up the
        webhook in your Lemon Squeezy dashboard.
    </p>

    <h2>Configure Webhook in Lemon Squeezy Dashboard (For Production)</h2>
    <ol>
        <li>Navigate to <strong>Settings</strong> > <strong>Webhooks</strong> in your Lemon Squeezy dashboard.</li>
        <li>Click <strong>Create Webhook</strong>.</li>
        <li>Enter your webhook URL:
            <ul>
                <li><strong>Production:</strong> <code>https://your-domain.com/lemon-squeezy/webhook</code></li>
                <li><strong>Local testing:</strong> Use ngrok (see below) to expose your local server</li>
            </ul>
        </li>
        <li>Select the events you want to receive, you can choose all of them.

        </li>
        <li>Save the webhook configuration.</li>
    </ol>

    <h2>Testing Locally with ngrok</h2>
    <p>
        <strong>Note:</strong> You need an ngrok account to use ngrok. Sign up for a free account at
        <a href="https://ngrok.com" target="_blank" rel="noopener noreferrer">ngrok.com</a> if you don't have one.
    </p>

    <x-alert variant="warning" title="Important" class="my-6">
        <p class="text-sm">
            If you're using Laravel Debugbar, disable it before testing webhooks as it will
            exhaust your memory when webhooks are received. <br>
            Free ngrok accounts can only have one active tunnel, so kill
            all ngrok processes (<code>pkill ngrok</code>) before starting a new one.
        </p>
    </x-alert>

    <ol>
        <li>Start your Laravel application locally, make sure it's running on port 8000:
            <pre><code class="language-bash">php artisan serve</code></pre>
        </li>
        <li>In a separate terminal, start ngrok to expose your local server (use the URL from the <code>php artisan
                serve</code> command):
            <pre><code class="language-bash">php artisan lmsqueezy:listen ngrok</code></pre>

            If your app is running on a different port, you can specify the port with the <code>--port</code> option:
            <pre><code class="language-bash">php artisan lmsqueezy:listen ngrok --port=8001</code></pre>
        </li>
        <li>This should automatically add the webhook URL to the Lemon Squeezy webhook configuration in the Lemon
            Squeezy dashboard. Go there and get the webhook secret and add it to your .env file.
            <pre><code class="language-ini">LEMON_SQUEEZY_SIGNING_SECRET=add the webhook secret here</code></pre>
        </li>
    </ol>


    <p class="text-sm">
        The webhook endpoint is already configured in <code>bootstrap/app.php</code> and excluded from CSRF
        protection.
        The <code>LemonSqueezyEventListener</code> automatically handles webhook events.
    </p>

    <p class="text-sm">
       To learn more about the webhook events, see the <a href="https://github.com/lmsqueezy/laravel?tab=readme-ov-file#webhooks" target="_blank" rel="noopener noreferrer">Lemon Squeezy Laravel package</a> documentation.
    </p>


</x-layouts.docs>
