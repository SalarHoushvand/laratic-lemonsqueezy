@push('head')
    <title>Manage Users - {{ config('app.name') }}</title>
    <meta name="description" content="Learn how to manage users, including editing user information, managing roles and permissions, blocking users, and deleting accounts.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'Admin', 'url' => '#'], ['label' => 'Manage Users', 'url' => '#']]">

    <h1>Manage Users</h1>
    <p class="text-on-surface-muted dark:text-on-surface-dark-muted">
        The user management system allows administrators to view, edit, and manage user accounts through a simple interface.
    </p>

    <h2>User Listing</h2>
    <img src="{{ asset('images/docs/admin-users-index-dark.webp') }}" alt="User Listing table" class="hidden dark:block">
    <img src="{{ asset('images/docs/admin-users-index-light.webp') }}" alt="User Listing table" class="dark:hidden">
    <p>The users table is available at <code>/admin/users</code> and provides:</p>
    <ul>
        <li>Search functionality to find users by name or email</li>
        <li>Sorting by creation date</li>
        <li>Pagination (6 users per page)</li>
        <li>Display of user roles and subscription status</li>
    </ul>
    <p>The table is powered by the <code>Admin\Users\UsersTable</code> Livewire component.</p>

    <h2>User Detail Page</h2>
    <img src="{{ asset('images/docs/admin-users-show-dark.webp') }}" alt="User Detail Page" class="hidden dark:block">
    <img src="{{ asset('images/docs/admin-users-show-light.webp') }}" alt="User Detail Page" class="dark:hidden">
    <p>Each user has a detail page at <code>/admin/users/{user}</code> where you can:</p>
    <ul>
        <li>Edit user information (name, email, phone, address)</li>
        <li><a href="{{ route('docs.show', ['topic' => 'manage-users/roles-and-permissions']) }}">Manage roles and permissions</a></li>
        <li>Block or unblock users</li>
        <li>Delete user accounts</li>
        <li>View subscriptions, orders, and transactions</li>
    </ul>

    <h2>Components</h2>
    
    <h3>UsersTable</h3>
    <p>Displays a paginated, searchable table of users with their roles and subscription information.</p>
    <p><strong>Location:</strong> <code>App\Livewire\Admin\Users\UsersTable</code></p>

    <h3>ManageUserRoles</h3>
    <p>Allows assigning and removing roles from users. Roles are selected from a dropdown that only shows unassigned roles.</p>
    <p><strong>Location:</strong> <code>App\Livewire\Admin\Users\ManageUserRoles</code></p>

    <h3>BlockUser</h3>
    <p>Toggles the blocked status of a user by assigning or removing the 'blocked' role. Blocked users cannot log in.</p>
    <p><strong>Location:</strong> <code>App\Livewire\Admin\Users\BlockUser</code></p>

    <h3>DeleteUser</h3>
    <p>Permanently deletes a user account. Automatically cancels any active subscriptions before deletion.</p>
    <p><strong>Location:</strong> <code>App\Livewire\Admin\Users\DeleteUser</code></p>

    <h2>Related Routes</h2>
    <table>
        <thead>
            <tr>
                <th>Method</th>
                <th>Path</th>
                <th>Route name</th>
            </tr>
        </thead>
        <tbody class="font-mono">
            <tr>
                <td><x-badge variant="success">GET</x-badge></td>
                <td>/admin/users</td>
                <td>admin.users.index</td>
            </tr>
            <tr>
                <td><x-badge variant="success">GET</x-badge></td>
                <td>/admin/users/{user}</td>
                <td>admin.users.show</td>
            </tr>
        </tbody>
    </table>

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
                <td><x-badge variant="outline-primary">Routes</x-badge></td>
                <td><strong>GET /admin/users (admin.users.index)</strong></td>
                <td>Admin users listing page</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Routes</x-badge></td>
                <td><strong>GET /admin/users/{user} (admin.users.show)</strong></td>
                <td>User detail page</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Controller</x-badge></td>
                <td><strong>App\Http\Controllers\Admin\UserController</strong></td>
                <td>Controller handling user listing and detail pages</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Livewire</x-badge></td>
                <td><strong>App\Livewire\Admin\Users\UsersTable</strong></td>
                <td>Component for displaying paginated, searchable users table</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Livewire</x-badge></td>
                <td><strong>App\Livewire\Admin\Users\ManageUserRoles</strong></td>
                <td>Component for managing user roles (assign/remove)</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Livewire</x-badge></td>
                <td><strong>App\Livewire\Admin\Users\BlockUser</strong></td>
                <td>Component for blocking/unblocking users</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Livewire</x-badge></td>
                <td><strong>App\Livewire\Admin\Users\DeleteUser</strong></td>
                <td>Component for deleting user accounts</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Model</x-badge></td>
                <td><strong>App\Models\User</strong></td>
                <td>User model with Spatie HasRoles trait</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Views</x-badge></td>
                <td><strong>pages/admin/users/index.blade.php</strong></td>
                <td>Admin users listing page</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Views</x-badge></td>
                <td><strong>pages/admin/users/show.blade.php</strong></td>
                <td>User detail page with all management components</td>
            </tr>
        </tbody>
    </table>

</x-layouts.docs>
