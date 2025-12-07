@push('head')
    <title>Google Social Login - {{ config('app.name') }}</title>
    <meta name="description" content="Learn how to set up and configure Google social authentication for your application.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'Authentication', 'url' => '#'], ['label' => 'Social Login', 'url' => route('docs.show', ['topic' => 'auth/social-login/index'])], ['label' => 'Google', 'url' => '#']]">

    <h1>Google Social Login</h1>
    <p>This guide will walk you through setting up Google authentication for your application. Google OAuth allows users to sign in using their Google accounts.</p>

    <h2>Prerequisites</h2>
    <ul>
        <li>A Google account</li>
        <li>Access to the <a href="https://console.cloud.google.com/" target="_blank">Google Cloud Console</a></li>
        <li>Laravel Socialite package (already included in this application)</li>
    </ul>

    <h2>Step 1: Create a Google OAuth Application</h2>
    <ol>
        <li>Go to the <a href="https://console.cloud.google.com/" target="_blank">Google Cloud Console</a></li>
        <li>Select or create a project</li>
        <li>Navigate to <strong>APIs & Services</strong> → <strong>Credentials</strong></li>
        <li>Click <strong>Create Credentials</strong> → <strong>OAuth client ID</strong></li>
        <li>If prompted, configure the OAuth consent screen first:
            <ul>
                <li>Choose <strong>External</strong> user type (unless you have a Google Workspace account)</li>
                <li>Fill in the required app information (app name, user support email, developer contact)</li>
                <li>Add scopes: <code>email</code>, <code>profile</code>, <code>openid</code></li>
                <li>Add test users if your app is in testing mode</li>
            </ul>
        </li>
        <li>For the OAuth client:
            <ul>
                <li>Application type: <strong>Web application</strong></li>
                <li>Name: Your application name</li>
                <li>Authorized redirect URIs: <code>http://localhost:8000/auth/google/callback</code> (for local development) or <code>https://yourdomain.com/auth/google/callback</code> (for production)</li>
            </ul>
        </li>
        <li>Click <strong>Create</strong></li>
        <li>Copy the <strong>Client ID</strong> and <strong>Client Secret</strong></li>
    </ol>

    <h2>Step 2: Configure Environment Variables</h2>
    <p>Add your Google OAuth credentials to your <code>.env</code> file:</p>
    <pre><code>GOOGLE_CLIENT_ID=your-client-id-here
GOOGLE_CLIENT_SECRET=your-client-secret-here
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback</code></pre>
    <p><strong>Note:</strong> For production, update <code>GOOGLE_REDIRECT_URI</code> to match your production domain.</p>

    <h2>Step 3: Verify Configuration</h2>
    <p>The configuration is already set up in <code>config/services.php</code>:</p>
    <pre><code>'google' => [
    'client_id'     => env('GOOGLE_CLIENT_ID'),
    'client_secret' => env('GOOGLE_CLIENT_SECRET'),
    'redirect'      => env('GOOGLE_REDIRECT_URI'),
],</code></pre>
    <p>Make sure your <code>.env</code> values are correctly set and match the redirect URI you configured in Google Cloud Console.</p>

    <h2>Step 4: Routes</h2>
    <p>The routes are already configured in <code>routes/web.php</code>:</p>
    <pre><code>Route::get('/auth/google/redirect', [SocialAuthController::class, 'redirectToGoogle'])
    ->name('auth.google.redirect');

Route::get('/auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback'])
    ->name('auth.google.callback');</code></pre>

    <h2>Step 5: Using the Social Login Button</h2>
    <p>The social login button component is already included in the login and registration pages. To add it to other pages, use:</p>
    <pre><code>&lt;x-blocks.auth.social-login provider="google" /&gt;</code></pre>
    <p>This will render a button that redirects users to Google's authentication page.</p>


    <h2>Common Issues</h2>
    <h3>Redirect URI Mismatch</h3>
    <p><strong>Error:</strong> "redirect_uri_mismatch"</p>
    <p><strong>Solution:</strong> Ensure the redirect URI in your Google Cloud Console exactly matches the one in your <code>.env</code> file, including the protocol (http/https) and trailing slashes.</p>

    <h3>Invalid Client</h3>
    <p><strong>Error:</strong> "invalid_client"</p>
    <p><strong>Solution:</strong> Verify that your <code>GOOGLE_CLIENT_ID</code> and <code>GOOGLE_CLIENT_SECRET</code> are correct and haven't been regenerated.</p>

    <h3>OAuth Consent Screen Not Configured</h3>
    <p><strong>Error:</strong> "access_denied" or consent screen errors</p>
    <p><strong>Solution:</strong> Make sure you've completed the OAuth consent screen configuration in Google Cloud Console, especially if your app is in testing mode (add test users).</p>

    <h2>Production Checklist</h2>
    <ul>
        <li>✅ Update <code>GOOGLE_REDIRECT_URI</code> to your production domain</li>
        <li>✅ Add production redirect URI to Google Cloud Console</li>
        <li>✅ Verify OAuth consent screen is published (if going public)</li>
        <li>✅ Test the authentication flow on production</li>
        <li>✅ Ensure HTTPS is enabled (required for production OAuth)</li>
    </ul>

    <h2>Additional Resources</h2>
    <ul>
        <li><a href="https://developers.google.com/identity/protocols/oauth2" target="_blank">Google OAuth 2.0 Documentation</a></li>
        <li><a href="https://laravel.com/docs/socialite" target="_blank">Laravel Socialite Documentation</a></li>
    </ul>

</x-layouts.docs>

