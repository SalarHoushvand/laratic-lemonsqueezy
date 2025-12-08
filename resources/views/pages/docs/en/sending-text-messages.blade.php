@push('head')
    <title>Two-Factor Authentication Delivery - {{ config('app.name') }}</title>
    <meta name="description"
        content="Learn how {{ config('app.name') }} delivers two-factor authentication (2FA) verification codes via email.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'Components', 'url' => '#'], ['label' => 'Two-Factor Authentication Delivery', 'url' => '#']]">

    <h1>Two-Factor Authentication Delivery</h1>
    <p class="text-on-surface-muted dark:text-on-surface-dark-muted">
        {{ config('app.name') }} delivers all two-factor authentication (2FA) verification codes via email using your
        configured mail provider. SMS delivery and Vonage integration are no longer used or required.
    </p>

    <h2>How It Works</h2>
    <ul>
        <li>When you enable 2FA from your account settings, a verification code is sent to your primary email address.</li>
        <li>When you log in and 2FA is enabled, you are prompted to enter a verification code that is emailed to you.</li>
        <li>Codes are short-lived, rate-limited, and invalidated after several failed attempts.</li>
    </ul>

    <p class="mt-4">
        As long as your application's mail configuration is working, no additional setup is required for 2FA delivery.
    </p>

</x-layouts.docs>
