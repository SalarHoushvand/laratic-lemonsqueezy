@push('head')
    <title>Installation - {{ config('app.name') }}</title>
    <meta name="description"
        content="Learn how to install {{ config('app.name') }}. Follow these simple steps to get started with Laratic.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'Basics', 'url' => '#'], ['label' => 'Installation', 'url' => '#']]">

    <h1>Installation</h1>
    <p>Follow these steps to install Laratic on your system.</p>

    <h2>1. Clone the Repository</h2>
    <p>Clone the repository and navigate into the project folder. You can rename the folder to anything you want.</p>
    <pre><code class="language-bash">git clone https://github.com/SalarHoushvand/laratic-lemonsqueezy.git
cd laratic-lemonsqueezy</code></pre>

    <h2>2. Install PHP Dependencies</h2>
    <p>Install all required PHP packages using Composer:</p>
    <pre><code class="language-bash">composer install</code></pre>

    <h2>3. Install JavaScript Dependencies</h2>
    <p>Install all required Node.js packages:</p>
    <pre><code class="language-bash">npm install</code></pre>

    <h2>4. Configure Environment</h2>
    <p>Copy the example environment file:</p>
    <pre><code class="language-bash">cp .env.example .env</code></pre>
    <p>Then edit the <code>.env</code> file and configure your database connection and other settings.</p>

    <h2>5. Generate Application Key</h2>
    <p>Generate a unique application key:</p>
    <pre><code class="language-bash">php artisan key:generate</code></pre>

    <h2>6. Run Database Migrations</h2>
    <p>Create the necessary database tables:</p>
    <pre><code class="language-bash">php artisan migrate</code></pre>

    <h2>7. Seed the Database (Optional)</h2>
    <p>If you want to populate your database with demo data:</p>
    <pre><code class="language-bash">php artisan db:seed</code></pre>

    <h2>8. Create Storage Link</h2>
    <p>Create a symbolic link for public storage:</p>
    <pre><code class="language-bash">php artisan storage:link</code></pre>

    <h2>9. Start Development Server</h2>
    <p>Start the development server:</p>
    <pre><code class="language-bash">composer run dev</code></pre>
    <p>This command will start both the Laravel development server and Vite for asset compilation.</p>

    <h2>Next Steps</h2>
    <p>Now that you have Laratic installed, you need to configure the following services by setting up accounts and adding their credentials to your <code>.env</code> file:</p>
    <ul>
        <li>
            <a href="{{ route('docs.show', ['topic' => 'email-notifications']) }}#setting-up-your-email-service">Setup Mailtrap + Mailgun</a>
            <p class="text-on-surface-muted dark:text-on-surface-dark-muted text-sm mt-1">For email testing (Mailtrap) and sending transactional emails (Mailgun).</p>
        </li>
        <li>
           <a href="{{ route('docs.show', ['topic' => 'newsletter']) }}">Setup Newsletter</a>
            <p class="text-on-surface-muted dark:text-on-surface-dark-muted text-sm mt-1">For newsletter subscriptions and email marketing campaigns.</p>
        </li>
        <li>
            <a href="{{ route('docs.show', ['topic' => 'ai/index']) }}">Setup Open AI</a>
            <p class="text-on-surface-muted dark:text-on-surface-dark-muted text-sm mt-1">Required for AI-powered features like chat, post generation, and content translation.</p>
        </li>
        <li>
            <a href="{{ route('docs.show', ['topic' => 'admin/file-upload']) }}">Setup Cloudinary</a>
            <p class="text-on-surface-muted dark:text-on-surface-dark-muted text-sm mt-1">Required for image and media upload, storage, and optimization.</p>
        </li>
        <li>
            <a href="{{ route('docs.show', ['topic' => 'auth/social-login/index']) }}">Setup Socialite</a>
            <p class="text-on-surface-muted dark:text-on-surface-dark-muted text-sm mt-1">Required for social authentication (OAuth login with providers like Google, GitHub, etc.).</p>
        </li>
        <li>
            <a href="{{ route('docs.show', ['topic' => 'billing-payment/lemon-squeezy/setup']) }}">Setup Lemon Squeezy</a>
            <p class="text-on-surface-muted dark:text-on-surface-dark-muted text-sm mt-1">Required for billing and subscriptions.</p>
        </li>
    </ul>

</x-layouts.docs>
