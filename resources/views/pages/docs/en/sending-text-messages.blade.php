@push('head')
    <title>Sending Text Messages - {{ config('app.name') }}</title>
    <meta name="description"
        content="Learn how to set up Vonage API for sending 2FA verification codes via SMS in {{ config('app.name') }}.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'Components', 'url' => '#'], ['label' => 'Sending Text Messages', 'url' => '#']]">

    <h1>Sending Text Messages</h1>
    <p class="text-on-surface-muted dark:text-on-surface-dark-muted">
        {{ config('app.name') }} uses Vonage (formerly Nexmo) to send SMS notifications for two-factor authentication
        (2FA) verification codes. This guide will show you how to set up Vonage.
    </p>

    <h2>Setting Up Vonage</h2>
    <p>
        Before you can send SMS notifications, you need to configure a Vonage account and add your API credentials to
        your application.
    </p>

    <h3>1. Create a Vonage Account</h3>
    <p><strong>Steps to get started:</strong></p>
    <ol>
        <li>Sign up for a free account at <a href="https://www.vonage.com" target="_blank"
                rel="noopener noreferrer">vonage.com</a></li>
        <li>Navigate to your <a href="https://dashboard.nexmo.com/" target="_blank"
                rel="noopener noreferrer">Vonage Dashboard</a></li>
        <li>Go to the "Settings" section and find your API credentials</li>
        <li>Copy your API Key and API Secret</li>
    </ol>

    <h3>2. Get a Phone Number</h3>
    <p>
        You'll need a phone number to send SMS messages from. In your Vonage dashboard:
    </p>
    <ol>
        <li>Navigate to "Numbers" → "Buy Numbers"</li>
        <li>Select your country and choose a number</li>
        <li>Purchase the number (you may get a free number for testing)</li>
        <li>Copy the phone number (e.g., <code>15556666666</code>)</li>
    </ol>
    <p class="text-on-surface-muted dark:text-on-surface-dark-muted">
        <strong>Note:</strong> For testing purposes, Vonage provides a sandbox environment. You can use a test number
        without purchasing one initially.
    </p>

    <h3>3. Configure Environment Variables</h3>
    <p>
        Add the following environment variables to your <code>.env</code> file:
    </p>
    <pre><code class="language-env">VONAGE_KEY=your_vonage_api_key
VONAGE_SECRET=your_vonage_api_secret
VONAGE_SMS_FROM=15556666666</code></pre>
    <p>
        Replace the following values:
    </p>
    <ul>
        <li><code>your_vonage_api_key</code> - Your Vonage API Key (found in your dashboard under Settings → API
            credentials)</li>
        <li><code>your_vonage_api_secret</code> - Your Vonage API Secret (found in the same location)</li>
        <li><code>15556666666</code> - The phone number you purchased or your test number (format: country code + number
            without + or spaces)</li>
    </ul>

    <h3>4. Install Required Package</h3>
    <p>
        The Vonage notification channel package should already be installed in this application. If you need to install
        it manually, run:
    </p>
    <pre><code class="language-bash">composer require laravel/vonage-notification-channel guzzlehttp/guzzle</code></pre>

    <h2>Usage</h2>
    <p>
        Once configured, Vonage is automatically used by the application to send 2FA verification codes via SMS. The
        SMS functionality is handled by the <code>App\Support\TwoFactor</code> service and
        <code>App\Notifications\PhoneVerificationNotification</code> notification class.
    </p>

</x-layouts.docs>
