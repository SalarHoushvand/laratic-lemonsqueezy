@push('head')
    <title>Heroku Deployment - {{ config('app.name') }}</title>
    <meta name="description"
        content="Learn how to deploy {{ config('app.name') }} to Heroku with GitHub integration and automatic deployments.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'Deployment', 'url' => '#'], ['label' => 'Heroku Deployment', 'url' => '#']]">

    <div class="not-prose">
        <x-alert variant="warning" title="Disclaimer" :showIcon="false" class="mb-6 text-xs">
            Please note that some Heroku services are paid. This article is provided for educational purposes only, and
            Laratic is not affiliated with Heroku.
        </x-alert>

    </div>
    <h1>Deploying to Heroku</h1>
    <p class="text-on-surface-muted dark:text-on-surface-dark-muted">
        This guide will walk you through deploying {{ config('app.name') }} to Heroku using GitHub integration for
        automatic deployments.
    </p>

    <h2>Prerequisites</h2>
    <p>Before you begin, make sure you have:</p>
    <ul>
        <li>A <a href="https://www.heroku.com" target="_blank" rel="noopener noreferrer">Heroku account</a></li>
        <li>Your application code pushed to a <a href="https://github.com" target="_blank"
                rel="noopener noreferrer">GitHub
                repository</a></li>
        <li>A Procfile in the root of your repository (is already included in the project).</li>
    </ul>

    <h2>1. Create a Heroku App</h2>
    <p>First, create a new Heroku application:</p>

    <ol>
        <li>Log in to your <a href="https://dashboard.heroku.com" target="_blank" rel="noopener noreferrer">Heroku
                Dashboard</a></li>
        <li>Click <strong>New</strong> → <strong>Create new app</strong></li>
        <li>Enter a unique app name (e.g., <code>your-app-name</code>)</li>
        <li>Select a location (choose the one closest to your users)</li>
        <li>Click <strong>Create app</strong></li>
    </ol>

    <h2>2. Connect GitHub Repository</h2>
    <p>In the deployment tab (second step after creating the app), select GitHub and connect your repository:</p>
    <ol>
        <li>In your Heroku app dashboard, go to the <strong>Deploy</strong> tab</li>
        <li>Under <strong>Deployment method</strong>, select <strong>GitHub</strong></li>
        <li>Click <strong>Connect to GitHub</strong> and authorize Heroku to access your GitHub account</li>
        <li>Search for your repository and click <strong>Connect</strong></li>
        <li>Optionally, enable <strong>Automatic deploys</strong> from your main branch</li>
        <li>Click <strong>Deploy Branch</strong> to trigger your first deployment</li>
    </ol>

    <h2>3. Configure Environment Variables</h2>
    <p>Set up all required environment variables in Heroku:</p>
    <ol>
        <li>In your Heroku app dashboard, go to <strong>Settings</strong></li>
        <li>Click <strong>Reveal Config Vars</strong></li>
        <li>Add all the environment variables from your <code>.env</code> file, including:
            <h3>Required Environment Variables</h3>
            <h4>Application</h4>
            <ul>
                <li><code>APP_NAME</code> - Your application name</li>
                <li><code>APP_ENV</code> - Set to your environment name (e.g., <code>development</code> or
                    <code>production</code>)
                </li>
                <li><code>APP_KEY</code> - Generate with <code>php artisan key:generate</code></li>
                <li><code>APP_DEBUG</code> - Set to <code>true</code> if you want to see detailed error messages. Set to
                    <code>false</code> for production.
                </li>


            </ul>
            <h4>Database</h4>
            <ul>
                <li><code>DB_CONNECTION</code> - Set to <code>pgsql</code> for Heroku Postgres</li>
                <li><code>DB_HOST</code>, <code>DB_DATABASE</code>, <code>DB_USERNAME</code>,
                    <code>DB_PASSWORD</code> - You can get this from your Heroku Postgres addon settings (explained in
                    the next section) or your database provider.
                </li>
            </ul>
            <p>Add rest of the environment variables as required by your application from your <code>.env</code> file.
            </p>
        </li>
    </ol>

    <h2>4. Configure Database</h2>

    <h3>Using Heroku Postgres (Paid)</h3>
    <ol>
        <li>In your Heroku app dashboard, go to the <strong>Resources</strong> tab</li>
        <li>In the <strong>Add-ons</strong> section, search for <code>Heroku Postgres</code></li>
        <li>Select the plan</li>
        <li>Click <strong>Submit Order Form</strong></li>
    </ol>

    <h3>Using your sqlite database</h3>
    <p>If you are using a sqlite database, remove all the DB values from your config variables. You also need to remove
        .gitignore file from the database folder. This is not recommended for production environments.</p>


    <h2>5. Add Node.js Buildpack</h2>
    <ol>
        <li>In your Heroku app dashboard, go to the <strong>Settings</strong> tab</li>
        <li>Click <strong>Buildpacks</strong></li>
        <li>Click <strong>Add buildpack</strong></li>
        <li>Select <code>nodejs</code> from the list</li>
        <li>Click <strong>Save</strong></li>
        <li>Redploy your application manually from the deployment tab</li>
    </ol>

    <p>You're app should be deployed successfully now. You can verify by clicking on "Open App" button at the top of
        your dashboard.</p>

    <h2>Understanding the Procfile</h2>
    <p>The <code>Procfile</code> in your project root tells Heroku how to run your application:</p>
    <pre><code class="language-text">web: vendor/bin/heroku-php-apache2 public/
worker: php artisan queue:work --sleep=1 --tries=3 --timeout=90</code></pre>
    <p>This Procfile defines two process types:</p>
    <ul>
        <li><strong>web:</strong> Runs your Laravel application using Apache and PHP. This handles HTTP requests.</li>
        <li><strong>worker:</strong> Runs Laravel's queue worker to process background jobs (AI processing, etc.).</li>
    </ul>
    <p class="text-on-surface-muted dark:text-on-surface-dark-muted">
        <strong>Note:</strong> The worker dyno is optional but required if you use AI processing due to the long running
        nature of the jobs.
    </p>

    <h2>Enable Worker Dyno</h2>
    <p>If your application uses AI processing, enable the worker dyno:</p>

    <ol>
        <li>Go to the <strong>Overv </strong> tab</li>
        <li>In <strong>Dyno Formations
            </strong> section, click "configure Dynos"</li>
        <li>Click the pencil icon to edit</li>
        <li>Toggle it <strong>On</strong> and click <strong>Confirm</strong></li>
    </ol>

</x-layouts.docs>
