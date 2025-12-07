@push('head')
    <title>GitHub Social Login - {{ config('app.name') }}</title>
    <meta name="description" content="Learn how to set up and configure GitHub social authentication for your application.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'Authentication', 'url' => '#'], ['label' => 'Social Login', 'url' => route('docs.show', ['topic' => 'auth/social-login/index'])], ['label' => 'GitHub', 'url' => '#']]">

    <h1>GitHub Social Login</h1>
    <p>This guide will walk you through setting up GitHub authentication for your application. GitHub OAuth allows users to sign in using their GitHub accounts.</p>

    <h2>Prerequisites</h2>
    <ul>
        <li>A GitHub account</li>
        <li>Access to <a href="https://github.com/settings/developers" target="_blank">GitHub Developer Settings</a></li>
        <li>Laravel Socialite package (already included in this application)</li>
    </ul>

    <h2>Step 1: Create a GitHub OAuth App</h2>
    <ol>
        <li>Go to <a href="https://github.com/settings/developers" target="_blank">GitHub Developer Settings</a></li>
        <li>Click <strong>OAuth Apps</strong> in the left sidebar</li>
        <li>Click <strong>New OAuth App</strong></li>
        <li>Fill in the application details:
            <ul>
                <li><strong>Application name:</strong> Your application name (e.g., "My App")</li>
                <li><strong>Homepage URL:</strong> Your application URL (e.g., <code>http://localhost:8000</code> for local development or <code>https://yourdomain.com</code> for production)</li>
                <li><strong>Authorization callback URL:</strong> <code>http://localhost:8000/auth/github/callback</code> (for local development) or <code>https://yourdomain.com/auth/github/callback</code> (for production)</li>
            </ul>
        </li>
        <li>Click <strong>Register application</strong></li>
        <li>On the next page, you'll see your <strong>Client ID</strong></li>
        <li>Click <strong>Generate a new client secret</strong> to create your client secret</li>
        <li>Copy both the <strong>Client ID</strong> and <strong>Client Secret</strong> (you won't be able to see the secret again)</li>
        <li>Once you have set the Client ID and Client Secret, navigate to <strong>Permissions & events</strong> in the OAuth App settings</li>
        <li>Under <strong>Account permissions</strong>, add <strong>Email address</strong> with <strong>Read-only</strong> access</li>
    </ol>

    <h2>Step 2: Configure Environment Variables</h2>
    <p>Add your GitHub OAuth credentials to your <code>.env</code> file:</p>
    <pre><code>GITHUB_CLIENT_ID=your-client-id-here
GITHUB_CLIENT_SECRET=your-client-secret-here
GITHUB_REDIRECT_URI=http://localhost/auth/github/callback</code></pre>
    <p><strong>Note:</strong> For production, update <code>GITHUB_REDIRECT_URI</code> to match your production domain.</p>

    <h2>Step 3: Verify Configuration</h2>
    <p>The configuration is already set up in <code>config/services.php</code>:</p>
    <pre><code>'github' => [
    'client_id'     => env('GITHUB_CLIENT_ID'),
    'client_secret' => env('GITHUB_CLIENT_SECRET'),
    'redirect'      => env('GITHUB_REDIRECT_URI'),
],</code></pre>
    <p>Make sure your <code>.env</code> values are correctly set and match the callback URL you configured in GitHub.</p>

    <h2>Step 4: Routes</h2>
    <p>The routes are already configured in <code>routes/web.php</code>:</p>
    <pre><code>Route::get('/auth/github/redirect', [SocialAuthController::class, 'redirectToGithub'])
    ->name('auth.github.redirect');

Route::get('/auth/github/callback', [SocialAuthController::class, 'handleGithubCallback'])
    ->name('auth.github.callback');</code></pre>

    <h2>Step 5: Using the Social Login Button</h2>
    <p>The social login button component is already included in the login and registration pages. To add it to other pages, use:</p>
    <pre><code>&lt;x-blocks.auth.social-login provider="github" /&gt;</code></pre>
    <p>This will render a button that redirects users to GitHub's authentication page.</p>

    <h2>GitHub Email Requirements</h2>
    <p><strong>Important:</strong> GitHub requires special handling for email addresses:</p>
    <ul>
        <li>Users must have a public email address, OR</li>
        <li>Users must grant the <code>user:email</code> scope to your application</li>
    </ul>
    <p>By default, Laravel Socialite requests the <code>user:email</code> scope, which allows access to the user's email even if it's private. However, if a user doesn't grant this permission or doesn't have an email set up, authentication will fail with an error message.</p>



    <h2>Common Issues</h2>
    <h3>Redirect URI Mismatch</h3>
    <p><strong>Error:</strong> "redirect_uri_mismatch" or "The redirect_uri MUST match the registered callback URL"</p>
    <p><strong>Solution:</strong> Ensure the callback URL in your GitHub OAuth App settings exactly matches the one in your <code>.env</code> file, including the protocol (http/https) and no trailing slashes.</p>

    <h3>Invalid Client</h3>
    <p><strong>Error:</strong> "invalid_client"</p>
    <p><strong>Solution:</strong> Verify that your <code>GITHUB_CLIENT_ID</code> and <code>GITHUB_CLIENT_SECRET</code> are correct. If you regenerated the client secret, make sure to update your <code>.env</code> file.</p>

    <h3>Email Not Available</h3>
    <p><strong>Error:</strong> "Unable to log in with GitHub. Your account must have an email address."</p>
    <p><strong>Solution:</strong> This occurs when GitHub doesn't return an email address. Users need to:
        <ul>
            <li>Have a public email address on their GitHub profile, OR</li>
            <li>Grant the <code>user:email</code> scope when authorizing the application</li>
        </ul>
        Make sure users understand they need to grant email access for authentication to work.
    </p>
trong>Solution:</strong> Check your GitHub OAuth App settings. The application may have been suspended due to policy violations. Contact GitHub support if needed.</p>

    <h2>Production Checklist</h2>
    <ul>
        <li>✅ Update <code>GITHUB_REDIRECT_URI</code> to your production domain</li>
        <li>✅ Update the callback URL in GitHub OAuth App settings to production URL</li>
        <li>✅ Test the authentication flow on production</li>
        <li>✅ Ensure HTTPS is enabled (required for production OAuth)</li>
        <li>✅ Verify that users can successfully authenticate with email access granted</li>
    </ul>

    <h2>Additional Resources</h2>
    <ul>
        <li><a href="https://docs.github.com/en/apps/oauth-apps/building-oauth-apps/authorizing-oauth-apps" target="_blank">GitHub OAuth App Documentation</a></li>
        <li><a href="https://laravel.com/docs/socialite" target="_blank">Laravel Socialite Documentation</a></li>
    </ul>

</x-layouts.docs>

