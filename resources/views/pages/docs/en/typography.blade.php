@push('head')
    <title>Typography - {{ config('app.name') }}</title>
    <meta name="description"
        content="Learn about the typography system in {{ config('app.name') }}, including heading utilities, link styles, and typography components for consistent text styling across your application.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'Basics', 'url' => '#'], ['label' => 'Typography', 'url' => '#']]">

    <h1>Typography</h1>
    <p>{{ config('app.name') }} includes a comprehensive typography system built with Tailwind CSS 4. The system provides
        consistent heading styles, link utilities, and reusable typography components that automatically adapt to your
        theme's color scheme and support dark mode.</p>

    <h2>Heading Utilities</h2>
    <p>The typography system includes six heading utility classes that provide responsive font sizes and consistent
        styling. These utilities use the theme's title font and automatically scale across different screen sizes.</p>

    <h3>Heading 1</h3>
    <p>Use <code>heading-1</code> for the main page title or hero headings:</p>
    <pre><code class="language-html">&lt;h1 class="heading-1"&gt;Main Page Title&lt;/h1&gt;</code></pre>

    <div class="my-6 not-prose">
        <h1 class="heading-1">Main Page Title</h1>
    </div>

    <h3>Heading 2</h3>
    <p>Use <code>heading-2</code> for major section headings:</p>
    <pre><code class="language-html">&lt;h2 class="heading-2"&gt;Section Heading&lt;/h2&gt;</code></pre>

    <div class="my-6 not-prose">
        <h2 class="heading-2">Section Heading</h2>
    </div>

    <h3>Heading 3</h3>
    <p>Use <code>heading-3</code> for subsection headings:</p>
    <pre><code class="language-html">&lt;h3 class="heading-3"&gt;Subsection Heading&lt;/h3&gt;</code></pre>

    <div class="my-6 not-prose">
        <h3 class="heading-3">Subsection Heading</h3>
    </div>

    <h3>Heading 4</h3>
    <p>Use <code>heading-4</code> for smaller section headings:</p>
    <pre><code class="language-html">&lt;h4 class="heading-4"&gt;Smaller Section Heading&lt;/h4&gt;</code></pre>

    <div class="my-6 not-prose">
        <h4 class="heading-4">Smaller Section Heading</h4>
    </div>

    <h3>Heading 5</h3>
    <p>Use <code>heading-5</code> for card titles or minor headings:</p>
    <pre><code class="language-html">&lt;h5 class="heading-5"&gt;Card Title&lt;/h5&gt;</code></pre>

    <div class="my-6 not-prose">
        <h5 class="heading-5">Card Title</h5>
    </div>

    <h3>Heading 6</h3>
    <p>Use <code>heading-6</code> for the smallest headings:</p>
    <pre><code class="language-html">&lt;h6 class="heading-6"&gt;Smallest Heading&lt;/h6&gt;</code></pre>

    <div class="my-6 not-prose">
        <h6 class="heading-6">Smallest Heading</h6>
    </div>

    <h2>Link Utility</h2>
    <p>The <code>link</code> utility class provides consistent link styling with underline decoration and theme-aware
        colors:</p>
    <pre><code class="language-html">&lt;a href="#" class="link"&gt;This is a styled link&lt;/a&gt;</code></pre>

    <div class="my-6 not-prose">
        <p>This is a paragraph with a <a href="#" class="link">styled link</a> inside it.</p>
    </div>

    <h2>Typography Components</h2>
    <p>{{ config('app.name') }} includes several reusable typography components designed for specific use cases. These
        components provide consistent styling and spacing for common page header patterns.</p>

    <h3>Guest Page Header</h3>
    <p>The <code>guest-page-header</code> component is designed for public-facing pages like landing pages, marketing
        pages, or documentation sections. It supports centered text, optional divider dots, and multiple heading sizes.
    </p>

    <h4>Basic Usage</h4>
    <pre><code class="language-html">&lt;x-typography.guest-page-header
    title="Welcome to Our Platform"
    description="Get started with our amazing features and tools."
/&gt;</code></pre>

    <div class="my-6 not-prose">
        <x-typography.guest-page-header title="Welcome to Our Platform"
            description="Get started with our amazing features and tools." />
    </div>

    <h4>With Different Heading Sizes</h4>
    <p>The component supports three heading sizes: <code>h1</code> (default), <code>h2</code>, and <code>h3</code>:</p>
    <pre><code class="language-html">&lt;x-typography.guest-page-header
    title="Smaller Heading"
    description="This uses an h2 heading."
    size="h2"
/&gt;</code></pre>

    <div class="my-6 not-prose">
        <x-typography.guest-page-header title="Smaller Heading" description="This uses an h2 heading." size="h2" />
    </div>

    <h4>Without Divider Dots</h4>
    <p>You can disable the divider dots by setting <code>dividerDots</code> to <code>false</code>:</p>
    <pre><code class="language-html">&lt;x-typography.guest-page-header
    title="No Divider Dots"
    description="This header doesn't have divider dots."
    :dividerDots="false"
/&gt;</code></pre>

    <div class="my-6 not-prose">
        <x-typography.guest-page-header title="No Divider Dots" description="This header doesn't have divider dots."
            :dividerDots="false" />
    </div>

    <h3>Auth Header</h3>
    <p>The <code>auth-header</code> component is designed for authentication pages (login, register, password reset). It
        provides centered text styling perfect for auth flows.</p>

    <pre><code class="language-html">&lt;x-typography.auth-header
    title="Sign in to your account"
    description="Enter your credentials to access your dashboard."
/&gt;</code></pre>

    <div class="my-6 not-prose">
        <x-typography.auth-header title="Sign in to your account"
            description="Enter your credentials to access your dashboard." />
    </div>

    <h3>Admin Page Header</h3>
    <p>The <code>admin-page-header</code> component is designed for admin dashboard pages. It provides a compact header
        with a title and description, perfect for admin interfaces.</p>

    <pre><code class="language-html">&lt;x-typography.admin-page-header
    title="User Management"
    description="Manage users, roles, and permissions from this dashboard."
/&gt;</code></pre>

    <div class="my-6 not-prose">
        <x-typography.admin-page-header title="User Management"
            description="Manage users, roles, and permissions from this dashboard." />
    </div>

    <h3>Settings Header</h3>
    <p>The <code>settings-header</code> component is designed for settings pages. It provides a compact header similar to
        the admin header but uses an <code>h2</code> tag instead of <code>h1</code>.</p>

    <pre><code class="language-html">&lt;x-typography.settings-header
    title="Profile Settings"
    description="Update your personal information and preferences."
/&gt;</code></pre>

    <div class="my-6 not-prose">
        <x-typography.settings-header title="Profile Settings"
            description="Update your personal information and preferences." />
    </div>

    <h2>Theme Integration</h2>
    <p>All typography utilities and components automatically adapt to your application's theme. They use CSS custom
        properties (CSS variables) defined in your theme configuration, ensuring consistent colors across light and dark
        modes.</p>

    <p>The typography system uses these theme variables:</p>
    <ul>
        <li><code>--color-on-surface-strong</code> - Primary text color</li>
        <li><code>--color-on-surface-dark-strong</code> - Primary text color (dark mode)</li>
        <li><code>--color-on-surface-muted</code> - Muted/secondary text color</li>
        <li><code>--color-on-surface-dark-muted</code> - Muted/secondary text color (dark mode)</li>
        <li><code>--color-primary</code> - Link color</li>
        <li><code>--color-primary-dark</code> - Link color (dark mode)</li>
    </ul>

    <h2>Component Props Reference</h2>

    <h3>Guest Page Header</h3>
    <table>
        <thead>
            <tr>
                <th>Prop</th>
                <th>Type</th>
                <th>Default</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><code>title</code></td>
                <td>string</td>
                <td>—</td>
                <td>The main heading text</td>
            </tr>
            <tr>
                <td><code>description</code></td>
                <td>string</td>
                <td>—</td>
                <td>The description text displayed below the title</td>
            </tr>
            <tr>
                <td><code>dividerDots</code></td>
                <td>boolean</td>
                <td><code>true</code></td>
                <td>Whether to show decorative divider dots between title and description</td>
            </tr>
            <tr>
                <td><code>size</code></td>
                <td>string</td>
                <td><code>h1</code></td>
                <td>The heading size. Options: <code>h1</code>, <code>h2</code>, <code>h3</code></td>
            </tr>
        </tbody>
    </table>

    <h3>Auth Header</h3>
    <table>
        <thead>
            <tr>
                <th>Prop</th>
                <th>Type</th>
                <th>Default</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><code>title</code></td>
                <td>string</td>
                <td>—</td>
                <td>The main heading text (required)</td>
            </tr>
            <tr>
                <td><code>description</code></td>
                <td>string</td>
                <td>—</td>
                <td>The description text displayed below the title (required)</td>
            </tr>
        </tbody>
    </table>

    <h3>Admin Page Header</h3>
    <table>
        <thead>
            <tr>
                <th>Prop</th>
                <th>Type</th>
                <th>Default</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><code>title</code></td>
                <td>string</td>
                <td><code>null</code></td>
                <td>The main heading text</td>
            </tr>
            <tr>
                <td><code>description</code></td>
                <td>string</td>
                <td><code>null</code></td>
                <td>The description text displayed below the title</td>
            </tr>
        </tbody>
    </table>

    <h3>Settings Header</h3>
    <table>
        <thead>
            <tr>
                <th>Prop</th>
                <th>Type</th>
                <th>Default</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><code>title</code></td>
                <td>string</td>
                <td>—</td>
                <td>The main heading text (required)</td>
            </tr>
            <tr>
                <td><code>description</code></td>
                <td>string</td>
                <td>—</td>
                <td>The description text displayed below the title (required)</td>
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
                <td><x-badge variant="outline-primary">CSS Utility</x-badge></td>
                <td><strong>resources/css/app.css</strong></td>
                <td>Heading utilities (heading-1 through heading-6) and link utility</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Component</x-badge></td>
                <td><strong>resources/views/components/typography/guest-page-header.blade.php</strong></td>
                <td>Guest page header component with optional divider dots</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Component</x-badge></td>
                <td><strong>resources/views/components/typography/auth-header.blade.php</strong></td>
                <td>Authentication page header component</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Component</x-badge></td>
                <td><strong>resources/views/components/typography/admin-page-header.blade.php</strong></td>
                <td>Admin dashboard page header component</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Component</x-badge></td>
                <td><strong>resources/views/components/typography/settings-header.blade.php</strong></td>
                <td>Settings page header component</td>
            </tr>
        </tbody>
    </table>

</x-layouts.docs>

