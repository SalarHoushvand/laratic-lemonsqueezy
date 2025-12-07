@push('head')
    <title>Avatar Component - {{ config('app.name') }}</title>
    <meta name="description"
        content="Learn how to use the Avatar component. A flexible avatar component with multiple sizes, variants, and fallback options.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'UI Components', 'url' => '#'], ['label' => 'Avatar', 'url' => '#']]">

    <h1>Avatar Component</h1>
    <p>The Avatar component displays user profile images with automatic fallback handling. It supports multiple sizes,
        variants, and custom content.</p>

    <h2>Usage</h2>
    <p>The simplest way to use the avatar component with an image:</p>
    <pre><code class="language-html">&lt;x-avatar img="/images/avatars/avatar-1.webp" alt="User Avatar" /&gt;</code></pre>

    <div class="flex gap-3 my-6 not-prose">
        <x-avatar img="/images/avatars/avatar-1.webp" alt="User Avatar" />
    </div>

    <h2>Sizes</h2>
    <p>The avatar component supports six different sizes:</p>
    <pre><code class="language-html">&lt;x-avatar size="xs" img="/images/avatars/avatar-2.webp" /&gt;
&lt;x-avatar size="sm" img="/images/avatars/avatar-3.webp" /&gt;
&lt;x-avatar size="md" img="/images/avatars/avatar-4.webp" /&gt;
&lt;x-avatar size="lg" img="/images/avatars/avatar-5.webp" /&gt;
&lt;x-avatar size="xl" img="/images/avatars/avatar-6.webp" /&gt;
&lt;x-avatar size="2xl" img="/images/avatars/avatar-7.webp" /&gt;</code></pre>

    <div class="flex flex-wrap items-center gap-3 my-6 not-prose">
        <x-avatar size="xs" img="/images/avatars/avatar-2.webp" />
        <x-avatar size="sm" img="/images/avatars/avatar-3.webp" />
        <x-avatar size="md" img="/images/avatars/avatar-4.webp" />
        <x-avatar size="lg" img="/images/avatars/avatar-5.webp" />
        <x-avatar size="xl" img="/images/avatars/avatar-6.webp" />
        <x-avatar size="2xl" img="/images/avatars/avatar-7.webp" />
    </div>

    <h2>Variants</h2>
    <p>When no image is provided or when an image fails to load, the avatar displays a fallback with different color variants:</p>
    <pre><code class="language-html">&lt;x-avatar variant="default" /&gt;
&lt;x-avatar variant="primary" /&gt;
&lt;x-avatar variant="secondary" /&gt;
&lt;x-avatar variant="info" /&gt;
&lt;x-avatar variant="success" /&gt;
&lt;x-avatar variant="warning" /&gt;
&lt;x-avatar variant="danger" /&gt;
&lt;x-avatar variant="inverse" /&gt;</code></pre>

    <div class="flex flex-wrap gap-3 my-6 not-prose">
        <x-avatar variant="default" />
        <x-avatar variant="primary" />
        <x-avatar variant="secondary" />
        <x-avatar variant="info" />
        <x-avatar variant="success" />
        <x-avatar variant="warning" />
        <x-avatar variant="danger" />
        <x-avatar variant="inverse" />
    </div>

    <h2>With Initials</h2>
    <p>Use the <code>fallback</code> prop to display user initials or custom text:</p>
    <pre><code class="language-html">&lt;x-avatar fallback="JD" variant="primary" /&gt;
&lt;x-avatar fallback="SM" variant="secondary" /&gt;
&lt;x-avatar fallback="AB" variant="info" /&gt;</code></pre>

    <div class="flex gap-3 my-6 not-prose">
        <x-avatar fallback="JD" variant="primary" />
        <x-avatar fallback="SM" variant="secondary" />
        <x-avatar fallback="AB" variant="info" />
    </div>

    <h2>Image with Fallback</h2>
    <p>When an image URL is provided but fails to load, the avatar automatically shows the fallback:</p>
    <pre><code class="language-html">&lt;x-avatar img="invalid-url.jpg" fallback="JD" variant="danger" /&gt;</code></pre>

    <div class="flex gap-3 my-6 not-prose">
        <x-avatar img="invalid-url.jpg" fallback="JD" variant="danger" />
    </div>

    <h2>Square Shape</h2>
    <p>By default, avatars are circular. Set <code>:isCircle="false"</code> for rounded squares:</p>
    <pre><code class="language-html">&lt;x-avatar :isCircle="false" img="/images/avatars/avatar-4.webp" /&gt;
&lt;x-avatar :isCircle="false" fallback="SQ" variant="primary" /&gt;</code></pre>

    <div class="flex gap-3 my-6 not-prose">
        <x-avatar :isCircle="false" img="/images/avatars/avatar-4.webp" />
        <x-avatar :isCircle="false" fallback="SQ" variant="primary" />
    </div>


    <h2>Props Reference</h2>
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
                <td><code>size</code></td>
                <td>string</td>
                <td><code>md</code></td>
                <td>Avatar size. Options: <code>xs</code>, <code>sm</code>, <code>md</code>, <code>lg</code>,
                    <code>xl</code>, <code>2xl</code></td>
            </tr>
            <tr>
                <td><code>variant</code></td>
                <td>string</td>
                <td><code>default</code></td>
                <td>Color variant for fallback. Options: <code>default</code>, <code>primary</code>,
                    <code>secondary</code>, <code>info</code>, <code>success</code>, <code>warning</code>,
                    <code>danger</code>, <code>inverse</code></td>
            </tr>
            <tr>
                <td><code>img</code></td>
                <td>string|null</td>
                <td><code>null</code></td>
                <td>Image URL. If the image fails to load, the fallback will be displayed automatically.</td>
            </tr>
            <tr>
                <td><code>alt</code></td>
                <td>string</td>
                <td><code>Avatar</code></td>
                <td>Alternative text for the image for accessibility.</td>
            </tr>
            <tr>
                <td><code>isCircle</code></td>
                <td>bool</td>
                <td><code>true</code></td>
                <td>Whether the avatar should be circular. Set to <code>false</code> for rounded squares.</td>
            </tr>
            <tr>
                <td><code>fallback</code></td>
                <td>string|null</td>
                <td><code>null</code></td>
                <td>Fallback text (e.g., user initials) to display when no image is provided or when the image fails to
                    load.</td>
            </tr>
        </tbody>
    </table>

    <h2>Slots</h2>
    <table>
        <thead>
            <tr>
                <th>Slot</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Default slot</td>
                <td>Custom content displayed in the fallback state. Useful for custom icons or badges. If no slot content
                    is provided, a default user icon will be shown.</td>
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
                <td><x-badge variant="outline-primary">Component</x-badge></td>
                <td><strong>resources/views/components/avatar.blade.php</strong></td>
                <td>Avatar component file</td>
            </tr>
        </tbody>
    </table>

    <p class="pt-8 text-on-surface-muted dark:text-on-surface-muted-dark text-sm">For the detailed documentation, please
        visit the <a href="https://www.penguinui.com/components/avatars" target="_blank">Penguin UI Avatars</a>.</p>


</x-layouts.docs>

