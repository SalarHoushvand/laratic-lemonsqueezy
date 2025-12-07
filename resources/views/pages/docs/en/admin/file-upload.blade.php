@push('head')
    <title>Cloudinary File Uploads - {{ config('app.name') }}</title>
    <meta name="description" content="Set up Cloudinary and learn how the Laratic admin file upload page works.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'Admin', 'url' => '#'], ['label' => 'File Uploads', 'url' => '#']]">

    <h1>Cloudinary File Uploads</h1>
    <p class="text-on-surface-muted dark:text-on-surface-dark-muted">
        All the file inputs in {{ config('app.name') }} are powered by Cloudinary using their hosted
        widget and <a href="https://github.com/cloudinary-community/cloudinary-laravel" target="_blank" rel="noopener">cloudinay laravel package</a>. 
    </p>

    <h2>Cloudinary prerequisites</h2>
    <ol>
        <li>Create a free Cloudinary account at <a href="https://cloudinary.com/users/register/free" target="_blank"
                rel="noopener">cloudinary.com</a>.</li>
        <li>Go to Settings &gt; API Keys, create a new API key and copy your <strong>Cloud Name</strong>, <strong>API Key</strong>, and
            <strong>API Secret</strong>.</li>
        <li>In your Cloudinary Console, open <strong>Settings &gt; Upload &gt; Upload presets</strong> and create an
            unsigned preset for your application.</li>
    </ol>

    <h3>Recommended upload preset</h3>
    <ul>
        <li><strong>Name:</strong> something descriptive like <code>laratic_unsigned</code></li>
        <li><strong>Signing Mode:</strong> <code>Unsigned</code></li>
        <li><strong>Folder:</strong> optional (for example <code>laratic/uploads</code>)</li>
        <li><strong>Allowed formats:</strong> include the image/video types you plan to support</li>
    </ul>
    <p>
        Save the preset ID because the widget references it through <code>CLOUDINARY_UPLOAD_PRESET</code>.
    </p>

    <h3>.env configuration</h3>
    <p>Add or update the following environment variables, then run <code>php artisan config:cache</code>:</p>
    <pre><code class="language-php">CLOUDINARY_URL=cloudinary://your-api-key:your-api-secret@your-cloud-name
CLOUDINARY_UPLOAD_PRESET=</code></pre>
    <p>These values feed <code>config/cloudinary.php</code> and the Cloudinary filesystem disk so the widget can generate
        signed URLs automatically.</p>

    <h2>Using the admin upload page</h2>
    <ol>
        <li>Visit <code>/admin/files/upload</code> (route name <code>admin.files.upload</code>).</li>
        <li>Click “Choose a file to upload” to open the Cloudinary widget.</li>
        <li>Select your local file. Once the upload finishes, the page shows a success card, the hosted URL, and a copy
            shortcut.</li>
        <li>If the file is an image, Laratic renders a live preview. Non-image files simply show the URL.</li>
    </ol>

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
                <td><x-badge variant="outline-primary">Route</x-badge></td>
                <td><strong>GET /admin/files/upload (admin.files.upload)</strong></td>
                <td>Admin page that renders the Livewire component</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Livewire</x-badge></td>
                <td><strong>App\Livewire\Admin\FileUpload</strong></td>
                <td>Stores the uploaded URL and returns the view</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">View</x-badge></td>
                <td><strong>resources/views/livewire/admin/file-upload.blade.php</strong></td>
                <td>UI for the uploader, copy button, and preview</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Component</x-badge></td>
                <td><strong>resources/views/components/input-file.blade.php</strong></td>
                <td>Wraps Cloudinary’s widget and syncs with Livewire</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Config</x-badge></td>
                <td><strong>config/cloudinary.php</strong></td>
                <td>Reads environment variables for Cloudinary credentials</td>
            </tr>
        </tbody>
    </table>

</x-layouts.docs>

