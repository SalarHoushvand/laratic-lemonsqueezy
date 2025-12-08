@push('head')
    <title>Email-based Two-Factor Authentication - {{ config('app.name') }}</title>
    <meta name="description"
        content="Learn how to set up two-factor authentication (2FA) with email verification codes in {{ config('app.name') }}.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'Security', 'url' => '#'], ['label' => 'Two-Factor Authentication', 'url' => '#']]">

    <x-alert variant="primary" :showIcon="true" class="my-6">
        This feature is only available for the <strong>Startup</strong> Bundle.
    </x-alert>

    <h1>Two-Factor Authentication with Email</h1>
    <p class="text-on-surface-muted dark:text-on-surface-dark-muted">
        Two-factor authentication (2FA) adds an extra layer of security to your account by requiring a verification code
        sent via email when you log in.
    </p>

    <img src="{{ asset('images/docs/2FA-login-dark.webp') }}" alt="Two-Factor Authentication" class="hidden dark:block">
    <img src="{{ asset('images/docs/2FA-login-light.webp') }}" alt="Two-Factor Authentication" class="dark:hidden">

    <h2>Enabling Two-Factor Authentication</h2>
    <p>
        To enable two-factor authentication:
    </p>
    <ol>
        <li>Navigate to <strong>Settings</strong> → <strong>Two-Factor Authentication</strong> in your account.</li>
        <li>Click the <strong>Enable Two-Factor Authentication</strong> button.</li>
        <li>Click <strong>Send Verification Code</strong>.</li>
        <li>You will receive a 6-digit verification code via email.</li>
        <li>Enter the code in the verification modal and click <strong>Verify and Enable</strong>.</li>
    </ol>
    <p>
        Once enabled, you will be required to enter a verification code each time you log in to your account.
    </p>

    <h2>Disabling Two-Factor Authentication</h2>
    <p>
        To disable 2FA:
    </p>
    <ol>
        <li>Navigate to <strong>Settings</strong> → <strong>Two-Factor Authentication</strong>.</li>
        <li>Click the <strong>Disable Two-Factor Authentication</strong> button.</li>
        <li>Enter your password to confirm the action.</li>
        <li>Click <strong>Disable 2FA</strong>.</li>
    </ol>

    <h2>Security Features</h2>
    <p>
        The 2FA system includes several security features:
    </p>
    <ul>
        <li><strong>Rate Limiting:</strong> You can only request a new verification code once per 60 seconds to prevent
            abuse.</li>
        <li><strong>Attempt Limits:</strong> After 5 failed verification attempts, the code is invalidated and you must
            request a new one.</li>
        <li><strong>Code Expiration:</strong> Verification codes expire after 10 minutes for login and 15 minutes for
            initial setup.</li>
        <li><strong>Session Security:</strong> After successful verification, your session is regenerated for additional
            security.</li>
    </ul>

</x-layouts.docs>
