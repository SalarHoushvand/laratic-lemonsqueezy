@push('head')
    <title>Themes & Customization - {{ config('app.name') }}</title>
    <meta name="description"
        content="Learn how to change and customize themes in {{ config('app.name') }}, including available themes, font management, and CSS customization.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'Design System', 'url' => '#'], ['label' => 'Themes', 'url' => '#']]">

    <h1>Themes & Customization</h1>
    <p class="text-on-surface-muted dark:text-on-surface-dark-muted">
        {{ config('app.name') }} comes with beautiful, pre-built themes that you can easily switch between or
        customize
        to match your brand. Each theme includes its own color palette, typography, and border radius settings.
    </p>

    <p>
        You can change the theme globally by setting the <code>APP_THEME</code> environment variable in your
        <code>.env</code> file:
    </p>

    <pre><code class="language-ini">APP_THEME=laratic</code></pre>


    <h2>Available Themes</h2>
    <p>
        {{ config('app.name') }} includes 14 beautiful, pre-built themes out of the box. Each theme includes both light
        and dark mode variants. Click on any theme to see it in action:
    </p>

    @php
        $themes = [
            [
                'name' => 'laratic',
                'title' => 'Laratic',
                'description' => 'The default theme with Instrument Sans font and indigo color scheme',
                'filename' => 'laratic',
            ],
            [
                'name' => 'arctic',
                'title' => 'Arctic',
                'description' => 'Cool blue tones with Inter font',
                'filename' => 'arctic',
            ],
            [
                'name' => 'minimal',
                'title' => 'Minimal',
                'description' => 'Clean, minimal design with Montserrat font and no border radius',
                'filename' => 'minimal',
            ],
            [
                'name' => 'modern',
                'title' => 'Modern',
                'description' => 'Modern aesthetic with Lato font',
                'filename' => 'modern',
            ],
            [
                'name' => 'high-contrast',
                'title' => 'High Contrast',
                'description' => 'High contrast design with Inter font for accessibility',
                'filename' => 'highContrast',
            ],
            [
                'name' => 'neo-brutalism',
                'title' => 'Neo Brutalism',
                'description' => 'Bold, brutalist design with Space Mono and Montserrat fonts',
                'filename' => 'neoBrutalism',
            ],
            [
                'name' => 'halloween',
                'title' => 'Halloween',
                'description' => 'Spooky theme with Poppins and Denk One fonts',
                'filename' => 'halloween',
            ],
            [
                'name' => 'zombie',
                'title' => 'Zombie',
                'description' => 'Dark, eerie theme with Montserrat and Denk One fonts',
                'filename' => 'zombie',
            ],
            [
                'name' => 'pastel',
                'title' => 'Pastel',
                'description' => 'Soft pastel colors with Playpen Sans font',
                'filename' => 'pastel',
            ],
            [
                'name' => 'retro',
                'title' => 'Retro (90s)',
                'description' => 'Retro 90s aesthetic with Poppins and Oswald fonts',
                'filename' => 'retro',
            ],
            [
                'name' => 'christmas',
                'title' => 'Christmas',
                'description' => 'Festive theme with Lato and Jost fonts',
                'filename' => 'christmas',
            ],
            [
                'name' => 'prototype',
                'title' => 'Prototype',
                'description' => 'Prototype/wireframe style with Playpen Sans font',
                'filename' => 'prototype',
            ],
            [
                'name' => 'news',
                'title' => 'News',
                'description' => 'News website style with Inter and Merriweather fonts',
                'filename' => 'news',
            ],
            [
                'name' => 'industrial',
                'title' => 'Industrial',
                'description' => 'Industrial design with Poppins and Oswald fonts',
                'filename' => 'industrial',
            ],
        ];
    @endphp

    <div class="grid grid-cols-1 gap-6 my-8 not-prose">
        @foreach ($themes as $theme)
            <div class="overflow-hidden bg-surface dark:bg-surface-dark">
                <div class="relative">
                    <!-- Light mode screenshot -->
                    <img src="{{ asset("images/themes/themes-{$theme['filename']}-light.webp") }}"
                        alt="{{ $theme['title'] }} theme - Light mode"
                        class="w-full h-auto block dark:hidden border border-outline dark:border-outline-dark"
                        loading="lazy" decoding="async">
                    <!-- Dark mode screenshot -->
                    <img src="{{ asset("images/themes/themes-{$theme['filename']}-dark.webp") }}"
                        alt="{{ $theme['title'] }} theme - Dark mode"
                        class="w-full h-auto hidden dark:block border border-outline dark:border-outline-dark"
                        loading="lazy" decoding="async">
                </div>
                <div class="p-4">
                    <h3
                        class="font-title font-bold text-lg mb-1 text-on-surface-strong dark:text-on-surface-dark-strong">
                        {{ $theme['title'] }}
                    </h3>
                    <p class="text-sm text-on-surface-muted dark:text-on-surface-dark-muted mb-3">
                        {{ $theme['description'] }}
                    </p>
                    <div>
                        <code
                            class="text-xs bg-surface-alt dark:bg-surface-dark-alt px-2 py-1 rounded-radius text-on-surface dark:text-on-surface-dark">
                            {{ $theme['name'] }}
                        </code>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <h2>Font Management</h2>
    <p>
       You can edit the fonts in the <code>resources/views/partials/head.blade.php</code>. The system automatically loads only the fonts needed for the active theme.
    </p>

    <h2>Customizing Themes</h2>
    <p>
        All theme definitions are located in <code>resources/css/app.css</code>. Each theme is defined using CSS custom
        properties (variables) within a <code>[data-theme=theme-name]</code> selector.
    </p>

    <h3>Theme Structure</h3>
    <p>
        Each theme includes the following customizable properties:
    </p>

    <ul>
        <li><strong>Fonts</strong> - <code>--font-body</code> and <code>--font-title</code></li>
        <li><strong>Light Theme Colors</strong>:
            <ul>
                <li><code>--color-surface</code> - Background color</li>
                <li><code>--color-surface-alt</code> - Alternate background</li>
                <li><code>--color-on-surface</code> - Text color</li>
                <li><code>--color-on-surface-strong</code> - Strong text color</li>
                <li><code>--color-on-surface-muted</code> - Muted text color</li>
                <li><code>--color-primary</code> - Primary brand color</li>
                <li><code>--color-on-primary</code> - Text on primary color</li>
                <li><code>--color-secondary</code> - Secondary brand color</li>
                <li><code>--color-on-secondary</code> - Text on secondary color</li>
                <li><code>--color-outline</code> - Border/outline color</li>
                <li><code>--color-outline-strong</code> - Strong border color</li>
            </ul>
        </li>
        <li><strong>Dark Theme Colors</strong> - Same properties with <code>-dark</code> suffix</li>
        <li><strong>Shared Colors</strong> - <code>--color-info</code>, <code>--color-success</code>,
            <code>--color-warning</code>, <code>--color-danger</code>
        </li>
        <li><strong>Border Radius</strong> - <code>--radius-radius</code></li>
    </ul>

    <h3>Creating a Custom Theme</h3>
    <p>
        To create your own custom theme, add a new theme block in <code>resources/css/app.css</code>:
    </p>

    <pre><code class="language-css">[data-theme=my-custom-theme] {
    /* Fonts */
    --font-body: 'Your Font', sans-serif;
    --font-title: 'Your Font', sans-serif;

    /* Light Theme */
    --color-surface: var(--color-white);
    --color-surface-alt: var(--color-slate-100);
    --color-on-surface: var(--color-slate-700);
    --color-on-surface-strong: var(--color-black);
    --color-on-surface-muted: var(--color-neutral-500);
    --color-primary: var(--color-indigo-600);
    --color-on-primary: var(--color-slate-100);
    --color-secondary: var(--color-indigo-700);
    --color-on-secondary: var(--color-slate-100);
    --color-outline: var(--color-slate-300);
    --color-outline-strong: var(--color-slate-800);

    /* Dark Theme */
    --color-surface-dark: var(--color-neutral-900);
    --color-surface-dark-alt: var(--color-neutral-800);
    --color-on-surface-dark: var(--color-neutral-300);
    --color-on-surface-dark-strong: var(--color-white);
    --color-on-surface-dark-muted: var(--color-neutral-400);
    --color-primary-dark: var(--color-indigo-500);
    --color-on-primary-dark: var(--color-neutral-50);
    --color-secondary-dark: var(--color-blue-500);
    --color-on-secondary-dark: var(--color-neutral-100);
    --color-outline-dark: var(--color-neutral-700);
    --color-outline-dark-strong: var(--color-neutral-300);

    /* Shared Colors */
    --color-info: var(--color-blue-500);
    --color-on-info: var(--color-white);
    --color-success: var(--color-green-600);
    --color-on-success: var(--color-white);
    --color-warning: var(--color-amber-500);
    --color-on-warning: var(--color-white);
    --color-danger: var(--color-red-600);
    --color-on-danger: var(--color-white);

    /* Border Radius */
    --radius-radius: var(--radius-sm);
}</code></pre>

    <p>
        Then set <code>APP_THEME=my-custom-theme</code> in your <code>.env</code> file, and add the corresponding font
        link in <code>resources/views/partials/head.blade.php</code> if needed.
    </p>

    <h2>Theme Variables Reference</h2>
    <p>
        Here's a quick reference of all available theme variables:
    </p>

    <table>
        <thead>
            <tr>
                <th>Variable</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><code>--font-body</code></td>
                <td>Font family for body text</td>
            </tr>
            <tr>
                <td><code>--font-title</code></td>
                <td>Font family for headings and titles</td>
            </tr>
            <tr>
                <td><code>--color-surface</code></td>
                <td>Main background color (light mode)</td>
            </tr>
            <tr>
                <td><code>--color-surface-alt</code></td>
                <td>Alternate background color (light mode)</td>
            </tr>
            <tr>
                <td><code>--color-on-surface</code></td>
                <td>Main text color (light mode)</td>
            </tr>
            <tr>
                <td><code>--color-on-surface-strong</code></td>
                <td>Strong/emphasized text color (light mode)</td>
            </tr>
            <tr>
                <td><code>--color-on-surface-muted</code></td>
                <td>Muted/secondary text color (light mode)</td>
            </tr>
            <tr>
                <td><code>--color-primary</code></td>
                <td>Primary brand color (light mode)</td>
            </tr>
            <tr>
                <td><code>--color-on-primary</code></td>
                <td>Text color on primary background (light mode)</td>
            </tr>
            <tr>
                <td><code>--color-secondary</code></td>
                <td>Secondary brand color (light mode)</td>
            </tr>
            <tr>
                <td><code>--color-on-secondary</code></td>
                <td>Text color on secondary background (light mode)</td>
            </tr>
            <tr>
                <td><code>--color-outline</code></td>
                <td>Border/outline color (light mode)</td>
            </tr>
            <tr>
                <td><code>--color-outline-strong</code></td>
                <td>Strong border color (light mode)</td>
            </tr>
            <tr>
                <td><code>--color-*-dark</code></td>
                <td>All above variables with <code>-dark</code> suffix for dark mode</td>
            </tr>
            <tr>
                <td><code>--color-info</code></td>
                <td>Info message color</td>
            </tr>
            <tr>
                <td><code>--color-success</code></td>
                <td>Success message color</td>
            </tr>
            <tr>
                <td><code>--color-warning</code></td>
                <td>Warning message color</td>
            </tr>
            <tr>
                <td><code>--color-danger</code></td>
                <td>Error/danger message color</td>
            </tr>
            <tr>
                <td><code>--radius-radius</code></td>
                <td>Default border radius for rounded elements</td>
            </tr>
        </tbody>
    </table>

</x-layouts.docs>
