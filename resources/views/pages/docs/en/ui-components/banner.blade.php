@push('head')
    <title>Banner Component - {{ config('app.name') }}</title>
    <meta name="description"
        content="Learn how to use the Banner component. A flexible banner component for announcements, promotions, and important messages with optional countdown timer.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'UI Components', 'url' => '#'], ['label' => 'Banner', 'url' => '#']]">

    <h1>Banner Component</h1>
    <p>The Banner component displays important announcements, promotions, or messages at the top of your page. It supports countdown timers, action buttons, and dismissible functionality.</p>

    <h2>Usage</h2>
    <p>The simplest way to use the banner component:</p>
    <pre><code class="language-html">&lt;x-banner&gt;
    This is an important announcement.
&lt;/x-banner&gt;</code></pre>

    <div class="my-6 not-prose">
        <x-banner>
            This is an important announcement.
        </x-banner>
    </div>

    <h2>Variants</h2>
    <p>The banner component supports six color variants:</p>
    <pre><code class="language-html">&lt;x-banner variant="default"&gt;Default banner&lt;/x-banner&gt;
&lt;x-banner variant="primary"&gt;Primary banner&lt;/x-banner&gt;
&lt;x-banner variant="info"&gt;Info banner&lt;/x-banner&gt;
&lt;x-banner variant="success"&gt;Success banner&lt;/x-banner&gt;
&lt;x-banner variant="warning"&gt;Warning banner&lt;/x-banner&gt;
&lt;x-banner variant="danger"&gt;Danger banner&lt;/x-banner&gt;</code></pre>

    <div class="space-y-4 my-6 not-prose">
        <x-banner variant="default">Default banner</x-banner>
        <x-banner variant="primary">Primary banner</x-banner>
        <x-banner variant="info">Info banner</x-banner>
        <x-banner variant="success">Success banner</x-banner>
        <x-banner variant="warning">Warning banner</x-banner>
        <x-banner variant="danger">Danger banner</x-banner>
    </div>

    <h2>Dismissible Banners</h2>
    <p>Make banners dismissible by setting the <code>isDismissible</code> prop to <code>true</code>:</p>
    <pre><code class="language-html">&lt;x-banner :isDismissible="true" variant="info"&gt;
    You can close this banner.
&lt;/x-banner&gt;</code></pre>

    <div class="my-6 not-prose">
        <x-banner :isDismissible="true" variant="info">
            You can close this banner.
        </x-banner>
    </div>

    <h2>With Action Button</h2>
    <p>Add an action button using the <code>button</code> and <code>href</code> props:</p>
    <pre><code class="language-html">&lt;x-banner variant="primary" button="Learn More" href="/features"&gt;
    Check out our new features!
&lt;/x-banner&gt;</code></pre>

    <div class="my-6 not-prose">
        <x-banner variant="primary" button="Learn More" href="/features">
            Check out our new features!
        </x-banner>
    </div>

    <h2>With Livewire Action</h2>
    <p>Use Livewire directives for dynamic actions:</p>
    <pre><code class="language-html">&lt;x-banner variant="warning" button="Verify Now" wire:click="verifyEmail"&gt;
    Please verify your email address.
&lt;/x-banner&gt;</code></pre>

    <div class="my-6 not-prose">
        <x-banner variant="warning" button="Verify Now" wire:click="verifyEmail">
            Please verify your email address.
        </x-banner>
    </div>

    <h2>With Countdown Timer</h2>
    <p>Add a countdown timer using the <code>endDate</code> prop. The banner will automatically hide when the timer expires:</p>
    <pre><code class="language-html">&lt;x-banner 
    variant="success" 
    button="Shop Now" 
    href="/pricing"
    endDate="2025-12-31T23:59:59Z"&gt;
    🎉 Special offer! Save 50% - Limited time only!
&lt;/x-banner&gt;</code></pre>

    <div class="my-6 not-prose">
        <x-banner 
            variant="success" 
            button="Shop Now" 
            href="/pricing"
            endDate="2025-12-31T23:59:59Z">
            🎉 Special offer! Save 50% - Limited time only!
        </x-banner>
    </div>

    <h2>Combined Features</h2>
    <p>You can combine timer, button, and dismissible features:</p>
    <pre><code class="language-html">&lt;x-banner 
    variant="primary" 
    :isDismissible="true"
    button="Get Started" 
    href="/register"
    endDate="2025-12-25T00:00:00Z"&gt;
    🎄 Holiday sale! Register now and save 30%!
&lt;/x-banner&gt;</code></pre>

    <div class="my-6 not-prose">
        <x-banner 
            variant="primary" 
            :isDismissible="true"
            button="Get Started" 
            href="/register"
            endDate="2025-12-25T00:00:00Z">
            🎄 Holiday sale! Register now and save 30%!
        </x-banner>
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
                <td><code>variant</code></td>
                <td>string</td>
                <td><code>default</code></td>
                <td>Visual style variant. Options: <code>default</code>, <code>primary</code>, <code>info</code>,
                    <code>success</code>, <code>warning</code>, <code>danger</code></td>
            </tr>
            <tr>
                <td><code>isDismissible</code></td>
                <td>bool</td>
                <td><code>false</code></td>
                <td>Whether the banner can be dismissed by the user. Adds a close button.</td>
            </tr>
            <tr>
                <td><code>button</code></td>
                <td>string|null</td>
                <td><code>null</code></td>
                <td>Text label for an optional action button. Combine with <code>href</code> for links, or pass
                    <code>wire:click</code> directly for Livewire actions.</td>
            </tr>
            <tr>
                <td><code>href</code></td>
                <td>string|null</td>
                <td><code>null</code></td>
                <td>Optional URL for the button. When provided, the button renders as a link.</td>
            </tr>
            <tr>
                <td><code>endDate</code></td>
                <td>string|null</td>
                <td><code>null</code></td>
                <td>Optional countdown timer end date in ISO 8601 format (e.g., <code>2025-12-31T23:59:59Z</code>). The
                    banner will automatically hide when the timer expires. Shows days, hours, minutes, and seconds.</td>
            </tr>
            <tr>
                <td><code>wire:click</code></td>
                <td>string</td>
                <td>-</td>
                <td>Pass Livewire directives directly to the component. When <code>button</code> is provided
                    without <code>href</code>, wire directives will be applied to the button. Supports
                    <code>wire:click</code>, <code>wire:target</code>, <code>wire:loading</code>, and
                    <code>wire:confirm</code>.</td>
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
                <td>Banner message content. Supports text, HTML, and icons.</td>
            </tr>
        </tbody>
    </table>

    <h2>Countdown Timer</h2>
    <p>The countdown timer feature provides:</p>
    <ul>
        <li><strong>Desktop view:</strong> Shows separate boxes for days, hours, minutes, and seconds</li>
        <li><strong>Mobile view:</strong> Shows a condensed format with days and hours only</li>
        <li><strong>Auto-hide:</strong> Banner automatically hides when the countdown reaches zero</li>
        <li><strong>Format:</strong> Use ISO 8601 date format (e.g., <code>2025-12-31T23:59:59Z</code>)</li>
    </ul>

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
                <td><strong>resources/views/components/banner.blade.php</strong></td>
                <td>Banner component file</td>
            </tr>
        </tbody>
    </table>

    <p class="pt-8 text-on-surface-muted dark:text-on-surface-muted-dark text-sm">For the detailed documentation, please
        visit the <a href="https://www.penguinui.com/components/banner" target="_blank">Penguin UI Banners</a>.</p>

</x-layouts.docs>

