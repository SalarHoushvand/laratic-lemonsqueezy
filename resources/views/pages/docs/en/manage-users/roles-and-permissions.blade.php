@push('head')
    <title>Roles and Permissions - {{ config('app.name') }}</title>
    <meta name="description" content="Learn how to manage roles and permissions using Spatie Laravel Permission, including creating roles, assigning permissions, and managing user role assignments.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'Admin', 'url' => '#'], ['label' => 'Manage Users', 'url' => route('docs.show', ['topic' => 'manage-users'])], ['label' => 'Roles and Permissions', 'url' => '#']]">

    <h1>Roles and Permissions</h1>
    <p>{{ config('app.name') }} uses the <a href="https://spatie.be/docs/laravel-permission" target="_blank" rel="noopener">Spatie Laravel Permission</a> package to manage user roles and permissions. Users can have multiple roles, and roles can have multiple permissions.</p>

    <h2>Managing User Roles via Admin Interface</h2>
    <p>You can assign and remove roles from users directly through the admin edit user page:</p>
    <ol>
        <li>Navigate to the users in the admin panel</li>
        <li>Click on a user to view their detail page</li>
        <li>Select a role from the dropdown to assign it to the user</li>
        <li>Click the X icon on the role badge to remove it from the user</li>
    </ol>
    <p>The dropdown only shows roles that are not already assigned to the user, preventing duplicate assignments.</p>


    <h2>Creating an Admin User</h2>
    <p>To create a new user with the admin role:</p>
    <pre class="language-bash"><code>php artisan app:create-admin-user</code></pre>

    <h2>Managing Roles and Permissions via Artisan</h2>
    <p>Roles and permissions are created using Spatie's artisan commands. Here are the most important ones:</p>

    <h2>Creating Roles</h2>
    <pre class="language-bash"><code>php artisan permission:create-role developer</code></pre>

    <h2>Creating Permissions</h2>
    <pre class="language-bash"><code>php artisan permission:create-permission "edit posts"</code></pre>

    <h2>Viewing All Roles and Permissions</h2>
    <pre class="language-bash"><code>php artisan permission:show</code></pre>


    <p>For more artisan commands and advanced usage, refer to the <a href="https://spatie.be/docs/laravel-permission" target="_blank" rel="noopener">official Spatie Laravel Permission documentation</a>.</p>

</x-layouts.docs>

