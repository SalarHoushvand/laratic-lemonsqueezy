@push('head')
    <title>Email Notifications - {{ config('app.name') }}</title>
    <meta name="description"
        content="Learn about all available email notifications in {{ config('app.name') }} and how to use them.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'Basics', 'url' => '#'], ['label' => 'Email Notifications', 'url' => '#']]">

    <h1>Email Notifications</h1>
    <p class="text-on-surface-muted dark:text-on-surface-dark-muted">
        {{ config('app.name') }} includes several email notifications that are automatically sent to users and
        administrators. This page lists all available notifications and how they work.
    </p>

    <h2>Setting Up Your Email Service</h2>
    <p>
        Before sending email notifications, you need to configure an email service.
        This application supports multiple email providers.
        For development and testing, we recommend using <a href="https://mailtrap.io" target="_blank"
            rel="noopener noreferrer">Mailtrap</a>. For production, use <a href="https://mailgun.com" target="_blank"
            rel="noopener noreferrer">Mailgun</a>.
    </p>

    <h3>1. Setting Up Mailtrap for Testing</h3>
    <p>
        Mailtrap is a fake SMTP server that captures all emails sent by your application during development. This allows
        you to test email functionality without sending real emails to users.
    </p>
    <p><strong>Steps to configure Mailtrap:</strong></p>
    <ol>
        <li>Sign up for a free account at <a href="https://mailtrap.io" target="_blank"
                rel="noopener noreferrer">mailtrap.io</a></li>
        <li>Create a new inbox in your Mailtrap dashboard</li>
        <li>Navigate to the inbox integrations and copy your SMTP credentials, you can find Laravel specific code in the
            "Code Samples" section.</li>
        <li>Add the following environment variables to your <code>.env</code> file:</li>
    </ol>
    <pre><code class="language-env">MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password</code></pre>
    <p>
        Replace <code>your_mailtrap_username</code> and <code>your_mailtrap_password</code> with your actual Mailtrap
        credentials.
    </p>
    <p>
        After configuring these settings, all emails sent by your application will be captured in your Mailtrap inbox,
        allowing you to preview them without sending real emails.
    </p>

    <h3>2. Setting Up Mailgun for Production</h3>
    <p>
        Mailgun is a transactional email service that delivers emails reliably in production. It's configured as the
        default mailer in this application.
    </p>
    <p><strong>Steps to configure Mailgun:</strong></p>
    <ol>
        <li>Sign up for an account at <a href="https://www.mailgun.com" target="_blank"
                rel="noopener noreferrer">mailgun.com</a></li>
        <li>Verify your domain in the Mailgun dashboard (or use the sandbox domain for testing)</li>
        <li>Navigate to your domain settings and copy your API credentials</li>
        <li>Add the following environment variables to your <code>.env</code> file:</li>
    </ol>
    <pre><code class="language-env">MAILGUN_DOMAIN=your_mailgun_domain
MAILGUN_SECRET=your_mailgun_secret_key
MAILGUN_ENDPOINT=api.mailgun.net
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="Your App Name"
# This is the email address that will receive the contact requests
CONTACT_EMAIL=your@contact.email</code></pre>
    <p>
        Replace the following values:
    </p>
    <ul>
        <li><code>your_mailgun_domain</code> - Your verified Mailgun domain (e.g., <code>mg.yourdomain.com</code> or the
            sandbox domain)</li>
        <li><code>your_mailgun_secret_key</code> - Your Mailgun API secret key (found in your Mailgun dashboard under
            "API Keys")</li>
        <li><code>noreply@yourdomain.com</code> - The email address you want to send from (must be from your verified
            domain)</li>
    </ul>
    <p>
        Please refer to the <a href="https://laravel.com/docs/12.x/mail#mailgun-driver" target="_blank"
            rel="noopener noreferrer">Laravel's Mailgun documentation</a> for more information.
    </p>
    <p>
        Once configured, your application will use Mailgun to send all email notifications in production. Make sure to
        verify your domain in Mailgun to ensure proper deliverability.
    </p>

    <h2>Available Notifications</h2>

    <h3>Welcome Notification</h3>
    <p>
        Sent automatically when a new user registers. This notification welcomes the user and provides a link to the
        dashboard.
    </p>
    <p><strong>Class:</strong> <code>App\Notifications\WelcomeNotification</code></p>
    <p><strong>When it's sent:</strong> Automatically triggered by the <code>Registered</code> event listener when a
        user registers.</p>
    <p><strong>Template:</strong> <code>resources/views/emails/welcome.blade.php</code></p>

    <h3>Email Verification Notification</h3>
    <p>
        Sent when a user requests an email verification code for two-factor authentication.
    </p>
    <p><strong>Class:</strong> <code>App\Notifications\EmailVerificationNotification</code></p>
    <p><strong>When it's sent:</strong> When a user requests email verification for 2FA.</p>
    <p><strong>Usage:</strong></p>
    <pre><code class="language-php">$user->notify(new EmailVerificationNotification($code));</code></pre>

    <h3>Order Paid Notification</h3>
    <p>
        Sent to the customer when their order payment is successfully processed.
    </p>
    <p><strong>Class:</strong> <code>App\Notifications\OrderPaidNotification</code></p>
    <p><strong>When it's sent:</strong> Automatically when a LemonSqueezy transaction is completed and the order is marked as
        paid.</p>
    <p><strong>Template:</strong> <code>resources/views/emails/order-paid.blade.php</code></p>
    <p><strong>Usage:</strong></p>
    <pre><code class="language-php">$user->notify(new OrderPaidNotification($order));</code></pre>

    <h3>Order Paid Admin Notification</h3>
    <p>
        Sent to all admin users when an order payment is successfully processed.
    </p>
    <p><strong>Class:</strong> <code>App\Notifications\OrderPaidAdminNotification</code></p>
    <p><strong>When it's sent:</strong> Automatically when a LemonSqueezy transaction is completed and the order is marked as
        paid.</p>
    <p><strong>Template:</strong> <code>resources/views/emails/order-paid-admin.blade.php</code></p>
    <p><strong>Usage:</strong></p>
    <pre><code class="language-php">$admin->notify(new OrderPaidAdminNotification($order));</code></pre>

    <h2>How to Send Notifications</h2>
    <p>
        All notifications can be sent using Laravel's notification system. The most common way is to use the
        <code>notify()</code> method on a user model:
    </p>
    <pre><code class="language-php">use App\Notifications\WelcomeNotification;

$user->notify(new WelcomeNotification);</code></pre>

    <h2>Email Templates</h2>
    <p>
        All email notifications use Laravel's markdown mail components. Templates are located in
        <code>resources/views/emails/</code> and use the <code>&lt;x-mail::message&gt;</code> component for consistent
        styling.
    </p>
    <p>
        To customize an email template, edit the corresponding Blade file in <code>resources/views/emails/</code>.
    </p>

    <h2>Automatic Notifications</h2>
    <p>
        Some notifications are sent automatically through event listeners:
    </p>
    <ul>
        <li><strong>Welcome Notification:</strong> Sent via <code>App\Listeners\SendWelcomeNotification</code> when the
            <code>Registered</code> event fires.</li>
        <li><strong>Order Paid Notifications:</strong> Sent when a LemonSqueezy webhook processes a payment.</li>
    </ul>

</x-layouts.docs>
