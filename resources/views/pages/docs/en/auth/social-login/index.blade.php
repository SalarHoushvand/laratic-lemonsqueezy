@push('head')
    <title>Social Login - {{ config('app.name') }}</title>
    <meta name="description" content="Learn how to set up and configure social authentication providers including Google and GitHub.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'Authentication', 'url' => '#'], ['label' => 'Social Login', 'url' => '#']]">

    <h1>Social Login</h1>
    <p>{{ config('app.name') }} includes built-in support for social authentication, allowing users to sign in using their existing accounts from popular providers. Under the hood, it uses <a href="https://laravel.com/docs/12.x/socialite" target="_blank">Laravel Socialite</a> to handle the authentication flow.</p>

    <h2>Supported Providers</h2>
    <p>The application comes with out-of-the-box support for the following providers:</p>
    <ul>
        <li><a href="{{ route('docs.show', ['topic' => 'auth/social-login/google']) }}">Google</a> - Sign in with Google accounts</li>
        <li><a href="{{ route('docs.show', ['topic' => 'auth/social-login/github']) }}">GitHub</a> - Sign in with GitHub accounts</li>
    </ul>

    <h2>Available Social Login Buttons</h2>
    <p>The <code>blocks.auth.social-login</code> component provides pre-built buttons for the following providers. While Google and GitHub are fully configured, the other providers have button components ready but require backend setup:</p>
    <ul>
        <li><strong>Google</strong> - Fully configured and ready to use</li>
        <li><strong>GitHub</strong> - Fully configured and ready to use</li>
        <li><strong>Facebook</strong> - Button component available, requires backend setup</li>
        <li><strong>Twitter (X)</strong> - Button component available, requires backend setup</li>
        <li><strong>LinkedIn</strong> - Button component available, requires backend setup</li>
        <li><strong>Slack</strong> - Button component available, requires backend setup</li>
    </ul>
    <p>To use any of these buttons, simply include the component in your authentication views:</p>
    <pre><code>&lt;x-blocks.auth.social-login provider="google" /&gt;
&lt;x-blocks.auth.social-login provider="github" /&gt;
&lt;x-blocks.auth.social-login provider="facebook" /&gt;
&lt;x-blocks.auth.social-login provider="twitter" /&gt;
&lt;x-blocks.auth.social-login provider="linkedin" /&gt;
&lt;x-blocks.auth.social-login provider="slack" /&gt;</code></pre>

    <h2>Adding Additional Providers</h2>
    <p>While Google and GitHub are configured by default, you can easily add support for any provider supported by Laravel Socialite. The system is designed to be extensible:</p>
    <ol>
        <li>Add the provider configuration to <code>config/services.php</code></li>
        <li>Create redirect and callback routes in <code>routes/web.php</code></li>
        <li>Add methods to <code>SocialAuthController</code> following the existing pattern</li>
        <li>Add the social login button to your authentication views</li>
    </ol>
    <p>All providers follow the same authentication flow, making it straightforward to add new ones.</p>



    <h2>References</h2>
    <table>
        <thead>
            <tr>
                <th>Category</th>
                <th>Path / Name</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><x-badge variant="outline-primary">Controller</x-badge></td>
                <td><strong>Auth\SocialAuthController</strong></td>
                <td>Handles all social authentication logic</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Model</x-badge></td>
                <td><strong>Models\SocialLogin</strong></td>
                <td>Stores social provider account information linked to users</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Routes</x-badge></td>
                <td><strong>GET /auth/google/redirect (auth.google.redirect)</strong></td>
                <td>Initiates Google authentication</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Routes</x-badge></td>
                <td><strong>GET /auth/google/callback (auth.google.callback)</strong></td>
                <td>Handles Google authentication callback</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Routes</x-badge></td>
                <td><strong>GET /auth/github/redirect (auth.github.redirect)</strong></td>
                <td>Initiates GitHub authentication</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Routes</x-badge></td>
                <td><strong>GET /auth/github/callback (auth.github.callback)</strong></td>
                <td>Handles GitHub authentication callback</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Config</x-badge></td>
                <td><strong>config/services.php</strong></td>
                <td>Contains provider credentials and configuration</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Component</x-badge></td>
                <td><strong>blocks.auth.social-login</strong></td>
                <td>Reusable social login button component supporting Google, GitHub, Facebook, Twitter, LinkedIn, and Slack</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Migration</x-badge></td>
                <td><strong>create_social_logins_table</strong></td>
                <td>Database table for storing social login records</td>
            </tr>
        </tbody>
    </table>

</x-layouts.docs>

