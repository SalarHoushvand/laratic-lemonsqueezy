@push('head')
    <title>Carousel Component - {{ config('app.name') }}</title>
    <meta name="description"
        content="Learn how to use the Carousel component. A fully-featured image carousel with navigation controls, indicators, and Livewire support.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'UI Components', 'url' => '#'], ['label' => 'Carousel', 'url' => '#']]">

    <h1>Carousel Component</h1>
    <p>The Carousel component provides a fully-featured image carousel with navigation controls, slide indicators, and
        smooth transitions. It uses Alpine.js for client-side interactivity and is fully compatible with Livewire for
        dynamic content.</p>

    <h2>Usage</h2>
    <p>Pass custom slides as an array. Each slide should contain an image source, alt text, title, description, and
        optional CTA button:</p>
    <pre><code class="language-html">&lt;x-carousel :slides="$slides" /&gt;</code></pre>

    <p>In your controller or Livewire component:</p>
    <pre><code class="language-php">$slides = [
    [
        'imgSrc' => '/images/slide-1.jpg',
        'imgAlt' => 'Beautiful landscape',
        'title' => 'Welcome to Our Platform',
        'description' => 'Discover amazing features and tools.',
        'ctaUrl' => '/signup',
        'ctaText' => 'Get Started',
    ],
    [
        'imgSrc' => '/images/slide-2.jpg',
        'imgAlt' => 'Team collaboration',
        'title' => 'Work Together',
        'description' => 'Collaborate seamlessly with your team.',
        'ctaUrl' => '/features',
        'ctaText' => 'Learn More',
    ],
];</code></pre>

    <div class="my-6 not-prose">
        @php
            $customSlides = [
                [
                    'imgSrc' => 'https://penguinui.s3.amazonaws.com/component-assets/carousel/default-slide-1.webp',
                    'imgAlt' => 'Vibrant abstract painting with swirling blue and light pink hues on a canvas.',
                    'title' => 'Custom Slide 1',
                    'description' => 'This is a custom slide example with your own content.',
                    'ctaUrl' => '#',
                    'ctaText' => 'Explore',
                ],
                [
                    'imgSrc' => 'https://penguinui.s3.amazonaws.com/component-assets/carousel/default-slide-2.webp',
                    'imgAlt' => 'Vibrant abstract painting with swirling red, yellow, and pink hues on a canvas.',
                    'title' => 'Custom Slide 2',
                    'description' => 'You can customize each slide with different images and content.',
                    'ctaUrl' => '#',
                    'ctaText' => 'Discover',
                ],
            ];
        @endphp
        <x-carousel :slides="$customSlides" />
    </div>

    <h2>Livewire Integration</h2>
    <p>The carousel works seamlessly with Livewire. Pass slides from your Livewire component:</p>
    <pre><code class="language-html">&lt;x-carousel :slides="$this->slides" /&gt;</code></pre>

    <p>In your Livewire component:</p>
    <pre><code class="language-php">class HeroCarousel extends Component
{
    public array $slides = [];

    public function mount()
    {
        $this->slides = [
            [
                'imgSrc' => '/images/promotion-1.jpg',
                'imgAlt' => 'Special promotion',
                'title' => 'Limited Time Offer',
                'description' => 'Get 50% off on all plans this month.',
                'ctaUrl' => '/pricing',
                'ctaText' => 'View Plans',
            ],
            // ... more slides
        ];
    }

    public function render()
    {
        return view('livewire.hero-carousel');
    }
}</code></pre>

    <h2>Slide Structure</h2>
    <p>Each slide in the <code>slides</code> array must follow this structure:</p>
    <table>
        <thead>
            <tr>
                <th>Key</th>
                <th>Type</th>
                <th>Required</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><code>imgSrc</code></td>
                <td>string</td>
                <td>Yes</td>
                <td>URL or path to the slide image</td>
            </tr>
            <tr>
                <td><code>imgAlt</code></td>
                <td>string</td>
                <td>Yes</td>
                <td>Alt text for the image (accessibility)</td>
            </tr>
            <tr>
                <td><code>title</code></td>
                <td>string</td>
                <td>Yes</td>
                <td>Title text displayed on the slide</td>
            </tr>
            <tr>
                <td><code>description</code></td>
                <td>string</td>
                <td>Yes</td>
                <td>Description text displayed below the title</td>
            </tr>
            <tr>
                <td><code>ctaUrl</code></td>
                <td>string|null</td>
                <td>No</td>
                <td>URL for the call-to-action button. If <code>null</code>, the button is hidden</td>
            </tr>
            <tr>
                <td><code>ctaText</code></td>
                <td>string</td>
                <td>No</td>
                <td>Text displayed on the call-to-action button</td>
            </tr>
        </tbody>
    </table>

    <h2>Autoplay</h2>
    <p>Enable automatic slide progression with the <code>autoplay</code> prop. You can also control the interval between slides:</p>
    <pre><code class="language-html">&lt;x-carousel :slides="$slides" :autoplay="true" :interval="3000" /&gt;</code></pre>

    <p>When autoplay is enabled, a pause/play button appears in the bottom-right corner, allowing users to control the autoplay.</p>

    <div class="my-6 not-prose">
        @php
            $autoplaySlides = [
                [
                    'imgSrc' => 'https://penguinui.s3.amazonaws.com/component-assets/carousel/default-slide-1.webp',
                    'imgAlt' => 'Vibrant abstract painting with swirling blue and light pink hues on a canvas.',
                    'title' => 'Autoplay Enabled',
                    'description' => 'This carousel automatically advances slides every 3 seconds.',
                    'ctaUrl' => '#',
                    'ctaText' => 'Learn More',
                ],
                [
                    'imgSrc' => 'https://penguinui.s3.amazonaws.com/component-assets/carousel/default-slide-2.webp',
                    'imgAlt' => 'Vibrant abstract painting with swirling red, yellow, and pink hues on a canvas.',
                    'title' => 'Pause Control',
                    'description' => 'Users can pause or resume autoplay using the button in the corner.',
                    'ctaUrl' => '#',
                    'ctaText' => 'Explore',
                ],
            ];
        @endphp
        <x-carousel :slides="$autoplaySlides" :autoplay="true" :interval="3000" />
    </div>

    <h2>Starting Index</h2>
    <p>Control which slide is displayed initially using the <code>startIndex</code> prop (1-based index):</p>
    <pre><code class="language-html">&lt;x-carousel :slides="$slides" :startIndex="2" /&gt;</code></pre>

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
                <td><code>slides</code></td>
                <td>array</td>
                <td>Default 3 slides</td>
                <td>Array of slide objects. Each slide must contain <code>imgSrc</code>, <code>imgAlt</code>,
                    <code>title</code>, <code>description</code>, and optionally <code>ctaUrl</code> and
                    <code>ctaText</code>
                </td>
            </tr>
            <tr>
                <td><code>startIndex</code></td>
                <td>int</td>
                <td><code>1</code></td>
                <td>The initial slide to display (1-based index). For example, <code>1</code> shows the first slide, <code>2</code> shows the second slide, etc.</td>
            </tr>
            <tr>
                <td><code>autoplay</code></td>
                <td>bool</td>
                <td><code>false</code></td>
                <td>Whether the carousel should automatically advance to the next slide. When enabled, a pause/play button appears in the bottom-right corner.</td>
            </tr>
            <tr>
                <td><code>interval</code></td>
                <td>int</td>
                <td><code>5000</code></td>
                <td>The time in milliseconds between automatic slide transitions when autoplay is enabled.</td>
            </tr>
        </tbody>
    </table>

    <h2>Features</h2>
    <ul>
        <li><strong>Navigation Controls:</strong> Previous and next buttons for manual navigation</li>
        <li><strong>Slide Indicators:</strong> Clickable dots at the bottom to jump to any slide</li>
        <li><strong>Smooth Transitions:</strong> Opacity-based transitions between slides (1000ms duration)</li>
        <li><strong>Infinite Loop:</strong> Automatically loops from last slide to first and vice versa</li>
        <li><strong>Autoplay:</strong> Optional automatic slide progression with pause/play controls</li>
        <li><strong>Customizable Start Index:</strong> Control which slide is displayed initially</li>
        <li><strong>Responsive Design:</strong> Adapts to different screen sizes with responsive padding and text sizes</li>
        <li><strong>Accessibility:</strong> Proper ARIA labels and semantic HTML for screen readers</li>
        <li><strong>Dark Mode Support:</strong> Full dark mode compatibility with theme-aware colors</li>
    </ul>

    <h2>Alpine.js Integration</h2>
    <p>The carousel uses Alpine.js for client-side interactivity. The component automatically initializes Alpine.js
        data with the slides array. Navigation (previous/next), indicator clicks, and autoplay controls are handled
        entirely on the client-side, making the carousel fast and responsive without server roundtrips.</p>

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
                <td><strong>resources/views/components/carousel.blade.php</strong></td>
                <td>Carousel component file</td>
            </tr>
        </tbody>
    </table>

    <p class="pt-8 text-on-surface-muted dark:text-on-surface-muted-dark text-sm">For the detailed documentation, please
        visit the <a href="https://www.penguinui.com/components/carousel" target="_blank">Penguin UI Carousels</a>.</p>

</x-layouts.docs>

