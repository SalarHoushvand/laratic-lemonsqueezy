@push('head')
    <title>Card Components - {{ config('app.name') }}</title>
    <meta name="description"
        content="Learn how to use Card components. Flexible card components for e-commerce products and subscription plans.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'UI Components', 'url' => '#'], ['label' => 'Card', 'url' => '#']]">

    <h1>Card Components</h1>
    <p>Card components provide structured containers for displaying product information, pricing plans, blog posts, and
        other content in a clean, organized format.</p>

    <h2>E-commerce Card</h2>
    <p>The <code>card-ecommerce</code> component displays product information with an image, name, description, price,
        and action button.</p>

    <pre><code class="language-html">&lt;x-card-ecommerce 
    img="/images/grand-theft-office.webp"
    name="Premium Headphones"
    description="High-quality wireless headphones with noise cancellation"
    :price="29900"
    currency="USD"
    href="/products/headphones"
    buttonLabel="View Details"
/&gt;</code></pre>

    <div class="my-6 not-prose">
        <x-card-ecommerce img="/images/grand-theft-office.webp" name="Grand Theft Office"
            description="A collection of GTA Online items" :price="29900" currency="USD" href="#"
            buttonLabel="Buy Now" />
    </div>

    <h3>Featured E-commerce Card</h3>
    <p>Use the <code>isFeatured</code> prop to highlight special products:</p>
    <pre><code class="language-html">&lt;x-card-ecommerce 
    img="/images/grand-theft-office.webp"
    name="Limited Edition Watch"
    description="Exclusive timepiece with premium materials"
    :price="59900"
    currency="USD"
    href="/products/watch"
    buttonLabel="Shop Now"
    :isFeatured="true"
/&gt;</code></pre>

    <div class="my-6 not-prose">
        <x-card-ecommerce img="/images/grand-theft-office.webp" name="Limited Edition Watch"
            description="Exclusive timepiece with premium materials" :price="59900" currency="USD"
            href="/products/watch" buttonLabel="Shop Now" :isFeatured="true" />
    </div>

    <h3>Without Price</h3>
    <p>Omit the price prop for products with custom pricing:</p>
    <pre><code class="language-html">&lt;x-card-ecommerce 
    img="/images/grand-theft-office.webp"
    name="Custom Service"
    description="Contact us for personalized pricing"
    href="/contact"
    buttonLabel="Get Quote"
/&gt;</code></pre>

    <div class="my-6 not-prose">
        <x-card-ecommerce img="/images/grand-theft-office.webp" name="Custom Service"
            description="Contact us for personalized pricing" href="/contact" buttonLabel="Get Quote" />
    </div>

    <h2>Subscription Plan Card</h2>
    <p>The <code>card-subscription-plan</code> component displays pricing plans with features, pricing details, and
        call-to-action buttons.</p>

    <h3>Basic Plan Card</h3>
    <pre><code class="language-html">&lt;x-card-subscription-plan class="max-w-md" :plan="(object)[
        'name' => 'Starter',
        'description' => 'Perfect for individuals getting started',
        'price' => 999,
        'currency' => 'USD',
        'billing_period' => 'month',
        'paddle_id' => 'pri_123',
        'features' => [
            'Up to 10 active projects with full access to core features',
            '5GB of secure cloud storage for your files',
            'Email support from our responsive team',
            'Access to professionally designed basic templates',
            'Join our community forum to connect with other users',
            'Monthly reports on your usage and performance',
            'Mobile app access to manage projects on the go',
        ]
    ]" /&gt;</code></pre>

    <div class="my-6 not-prose">
        <x-card-subscription-plan class="max-w-md" :plan="(object) [
            'name' => 'Starter',
            'description' => 'Perfect for individuals getting started',
            'price' => 999,
            'currency' => 'USD',
            'billing_period' => 'month',
            'paddle_id' => 'pri_123',
            'features' => [
                'Up to 10 active projects with full access to core features',
                '5GB of secure cloud storage for your files',
                'Email support from our responsive team',
                'Access to professionally designed basic templates',
                'Join our community forum to connect with other users',
                'Monthly reports on your usage and performance',
                'Mobile app access to manage projects on the go',
            ],
        ]" />
    </div>

    <h3>Featured Plan Card</h3>
    <p>Use <code>is_featured</code> to highlight the most popular plan:</p>
    <pre><code class="language-html">&lt;x-card-subscription-plan class="max-w-md" :plan="(object)[
        'name' => 'Professional',
        'description' => 'Best for growing teams',
        'price' => 2999,
        'currency' => 'USD',
        'billing_period' => 'month',
        'is_featured' => true,
        'paddle_id' => 'pri_456',
        'features' => [
            'Unlimited projects with access to all premium features',
            '100GB of secure cloud storage for your files and data',
            'Priority support with faster response times from our team',
            'Advanced analytics and reporting tools for insights',
        ]
    ]" /&gt;</code></pre>

    <div class="my-6 not-prose">
        <x-card-subscription-plan class="max-w-md" :plan="(object) [
            'name' => 'Professional',
            'description' => 'Best for growing teams',
            'price' => 2999,
            'currency' => 'USD',
            'billing_period' => 'month',
            'is_featured' => true,
            'paddle_id' => 'pri_456',
            'features' => [
                'Unlimited projects with access to all premium features',
                '100GB of secure cloud storage for your files and data',
                'Priority support with faster response times from our team',
                'Advanced analytics and reporting tools for insights',
            ],
        ]" />
    </div>

    <h3>With Free Trial</h3>
    <p>Add trial period information:</p>
    <pre><code class="language-html">&lt;x-card-subscription-plan class="max-w-md" :plan="(object)[
        'name' => 'Enterprise',
        'description' => 'For large organizations',
        'price' => 9999,
        'currency' => 'USD',
        'billing_period' => 'month',
        'trial_period' => 14,
        'trial_interval' => 'day',
        'paddle_id' => 'pri_789',
        'features' => [
            'Unlimited everything with no restrictions on usage',
            'Dedicated support with a personal account manager',
            'Custom integrations tailored to your workflow',
            'SLA guarantee with 99.9% uptime commitment',
        ]
    ]" /&gt;</code></pre>

    <div class="my-6 not-prose">
        <x-card-subscription-plan class="max-w-md" :plan="(object) [
            'name' => 'Enterprise',
            'description' => 'For large organizations',
            'price' => 9999,
            'currency' => 'USD',
            'billing_period' => 'month',
            'trial_period' => 14,
            'trial_interval' => 'day',
            'paddle_id' => 'pri_789',
            'features' => [
                'Unlimited everything with no restrictions on usage',
                'Dedicated support with a personal account manager',
                'Custom integrations tailored to your workflow',
                'SLA guarantee with 99.9% uptime commitment',
            ],
        ]" />
    </div>

    <h3>One-Time Payment</h3>
    <p>For lifetime access plans:</p>
    <pre><code class="language-html">&lt;x-card-subscription-plan class="max-w-md" :plan="(object)[
        'name' => 'Lifetime',
        'description' => 'Pay once, use forever',
        'price' => 29900,
        'currency' => 'USD',
        'billing_period' => 'one-time',
        'href' => route('checkout', 'lifetime'),
        'button_text' => 'Buy Now',
        'features' => [
            'All features included with full access to everything',
            'Lifetime updates and new features at no extra cost',
            'No recurring fees with a one-time payment only',
        ]
    ]" /&gt;</code></pre>

    <div class="my-6 not-prose">
        <x-card-subscription-plan class="max-w-md" :plan="(object) [
            'name' => 'Lifetime',
            'description' => 'Pay once, use forever',
            'price' => 29900,
            'currency' => 'USD',
            'billing_period' => 'one-time',
            'href' => '#',
            'button_text' => 'Buy Now',
            'features' => [
                'All features included with full access to everything',
                'Lifetime updates and new features at no extra cost',
                'No recurring fees with a one-time payment only',
            ],
        ]" />
    </div>

    <h2>Post Card</h2>
    <p>The <code>card-post</code> component displays blog post information in a vertical layout, perfect for grid
        displays.</p>

    <h3>Basic Post Card</h3>
    <pre><code class="language-html">&lt;x-card-post class="max-w-sm" :post="$post"/&gt;</code></pre>

    <div class="my-6 not-prose">
        <x-card-post class="max-w-sm" :post="(object) [
            'title' => 'Getting Started with Laravel 12',
            'description' => 'Learn how to build modern web applications with Laravel 12 framework.',
            'image_url' => '/images/amsterdam.webp',
            'slug' => 'getting-started-with-laravel-12',
            'created_at' => now(),
        ]" />
    </div>

    <h3>Post Card Grid</h3>
    <p>Post cards work beautifully in responsive grid layouts:</p>
    <pre><code class="language-html">&lt;div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"&gt;
    @@foreach ($posts as $post)
        &lt;x-card-post :post="$post" /&gt;
    @@endforeach
&lt;/div&gt;</code></pre>

    <div class="my-6 not-prose">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <x-card-post :post="(object) [
                'title' => 'Mastering Tailwind CSS',
                'description' => 'Build beautiful interfaces with utility-first CSS.',
                'image_url' => '/images/amsterdam.webp',
                'slug' => 'mastering-tailwind-css',
                'created_at' => now()->subDays(1),
            ]" />
            <x-card-post :post="(object) [
                'title' => 'Testing with Pest',
                'description' => 'Write elegant tests with the Pest testing framework.',
                'image_url' => '/images/paris.webp',
                'slug' => 'testing-with-pest',
                'created_at' => now()->subDays(2),
            ]" />
            <x-card-post :post="(object) [
                'title' => 'Laravel Performance',
                'description' => 'Optimize your Laravel applications for peak performance.',
                'image_url' => '/images/alps.webp',
                'slug' => 'laravel-performance',
                'created_at' => now()->subDays(3),
            ]" />
        </div>
    </div>

    <h2>Horizontal Post Card</h2>
    <p>The <code>card-post-horizontal</code> component displays blog post information in a horizontal layout, ideal for
        featured posts.</p>

    <h3>Basic Horizontal Card</h3>
    <pre><code class="language-html">&lt;x-card-post-horizontal :post="$post" /&gt;</code></pre>

    <div class="my-6 not-prose">
        <x-card-post-horizontal :post="(object) [
            'title' => 'Building APIs with Laravel',
            'description' =>
                'A comprehensive guide to creating robust RESTful APIs using Laravel framework and best practices.',
            'image_url' => '/images/amsterdam.webp',
            'slug' => 'building-apis-with-laravel',
            'author' => 'John Doe',
            'created_at' => now()->subDays(3),
        ]" />
    </div>

    <h2>Testimonial Card</h2>
    <p>The <code>card-testimonial</code> component displays customer testimonials with a quote, author information, and
        avatar.</p>

    <h3>Basic Testimonial Card</h3>
    <pre><code class="language-html">&lt;x-card-testimonial 
    :author="[
        'name' => 'John Doe',
        'role' => 'CEO',
        'avatar' => '/images/avatars/avatar-1.webp'
    ]"
    quote="Simply put, this software transformed my workflow! Its intuitive interface and powerful features make tasks a breeze."
/&gt;</code></pre>

    <div class="my-6 not-prose">
        <x-card-testimonial :author="[
            'name' => 'John Doe',
            'role' => 'CEO',
            'avatar' => '/images/avatars/avatar-1.webp',
        ]"
            quote="Simply put, this software transformed my workflow! Its intuitive interface and powerful features make tasks a breeze. A game-changer for productivity!" />
    </div>


    <h2>E-commerce Card Props</h2>
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
                <td><code>img</code></td>
                <td>string|null</td>
                <td><code>null</code></td>
                <td>Product image URL</td>
            </tr>
            <tr>
                <td><code>name</code></td>
                <td>string|null</td>
                <td><code>null</code></td>
                <td>Product name</td>
            </tr>
            <tr>
                <td><code>description</code></td>
                <td>string|null</td>
                <td><code>null</code></td>
                <td>Product description (max 2 lines displayed)</td>
            </tr>
            <tr>
                <td><code>price</code></td>
                <td>int|null</td>
                <td><code>null</code></td>
                <td>Price in cents (e.g., 2999 for $29.99)</td>
            </tr>
            <tr>
                <td><code>currency</code></td>
                <td>string|null</td>
                <td><code>null</code></td>
                <td>Currency code (e.g., USD, EUR, GBP)</td>
            </tr>
            <tr>
                <td><code>href</code></td>
                <td>string|null</td>
                <td><code>null</code></td>
                <td>URL for the action button</td>
            </tr>
            <tr>
                <td><code>buttonLabel</code></td>
                <td>string</td>
                <td><code>View</code></td>
                <td>Text for the action button</td>
            </tr>
            <tr>
                <td><code>isFeatured</code></td>
                <td>bool</td>
                <td><code>false</code></td>
                <td>Highlights the card with special styling</td>
            </tr>
        </tbody>
    </table>

    <h2>Subscription Plan Card Props</h2>
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
                <td><code>plan</code></td>
                <td>object</td>
                <td>-</td>
                <td>Required. Plan object containing all plan details (see structure below)</td>
            </tr>
        </tbody>
    </table>

    <h3>Plan Object Structure</h3>
    <table>
        <thead>
            <tr>
                <th>Property</th>
                <th>Type</th>
                <th>Required</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><code>name</code></td>
                <td>string</td>
                <td>Yes</td>
                <td>Plan name</td>
            </tr>
            <tr>
                <td><code>description</code></td>
                <td>string</td>
                <td>Yes</td>
                <td>Plan description</td>
            </tr>
            <tr>
                <td><code>price</code></td>
                <td>int</td>
                <td>Yes</td>
                <td>Price in cents</td>
            </tr>
            <tr>
                <td><code>currency</code></td>
                <td>string</td>
                <td>No</td>
                <td>Currency code (defaults to USD)</td>
            </tr>
            <tr>
                <td><code>billing_period</code></td>
                <td>string</td>
                <td>No</td>
                <td>Billing frequency: <code>month</code>, <code>year</code>, <code>one-time</code></td>
            </tr>
            <tr>
                <td><code>is_featured</code></td>
                <td>bool</td>
                <td>No</td>
                <td>Show "Most Popular" badge and special styling</td>
            </tr>
            <tr>
                <td><code>paddle_id</code></td>
                <td>string</td>
                <td>No</td>
                <td>Paddle price ID (used if href not provided)</td>
            </tr>
            <tr>
                <td><code>href</code></td>
                <td>string</td>
                <td>No</td>
                <td>Custom URL for the subscribe button</td>
            </tr>
            <tr>
                <td><code>button_text</code></td>
                <td>string</td>
                <td>No</td>
                <td>Custom button text (defaults to "Subscribe")</td>
            </tr>
            <tr>
                <td><code>trial_period</code></td>
                <td>int</td>
                <td>No</td>
                <td>Number of trial days/months</td>
            </tr>
            <tr>
                <td><code>trial_interval</code></td>
                <td>string</td>
                <td>No</td>
                <td>Trial interval unit: <code>day</code>, <code>month</code></td>
            </tr>
            <tr>
                <td><code>features</code></td>
                <td>array</td>
                <td>No</td>
                <td>Array of feature strings to display with checkmarks</td>
            </tr>
        </tbody>
    </table>

    <h2>Post Card Props</h2>
    <p>Both <code>card-post</code> and <code>card-post-horizontal</code> accept a post object with the following
        properties:</p>
    <table>
        <thead>
            <tr>
                <th>Property</th>
                <th>Type</th>
                <th>Required</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><code>title</code></td>
                <td>string</td>
                <td>No</td>
                <td>Post title</td>
            </tr>
            <tr>
                <td><code>description</code></td>
                <td>string</td>
                <td>No</td>
                <td>Post description or excerpt</td>
            </tr>
            <tr>
                <td><code>image_url</code></td>
                <td>string|null</td>
                <td>No</td>
                <td>URL of the post's featured image</td>
            </tr>
            <tr>
                <td><code>slug</code></td>
                <td>string</td>
                <td>No</td>
                <td>Post slug for generating links</td>
            </tr>
            <tr>
                <td><code>created_at</code></td>
                <td>Carbon</td>
                <td>No</td>
                <td>Post creation date</td>
            </tr>
            <tr>
                <td><code>author</code></td>
                <td>string</td>
                <td>No</td>
                <td>Post author name (only displayed in horizontal card)</td>
            </tr>
        </tbody>
    </table>

    <h2>Testimonial Card Props</h2>
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
                <td><code>author</code></td>
                <td>array</td>
                <td>See below</td>
                <td>Author information object containing name, role, and avatar</td>
            </tr>
            <tr>
                <td><code>quote</code></td>
                <td>string</td>
                <td>See below</td>
                <td>The testimonial quote text</td>
            </tr>
        </tbody>
    </table>

    <h3>Author Object Structure</h3>
    <table>
        <thead>
            <tr>
                <th>Property</th>
                <th>Type</th>
                <th>Required</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><code>name</code></td>
                <td>string</td>
                <td>No</td>
                <td>Author's full name</td>
            </tr>
            <tr>
                <td><code>role</code></td>
                <td>string</td>
                <td>No</td>
                <td>Author's job title or role</td>
            </tr>
            <tr>
                <td><code>avatar</code></td>
                <td>string</td>
                <td>No</td>
                <td>URL to the author's avatar image</td>
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
                <td><strong>resources/views/components/card-ecommerce.blade.php</strong></td>
                <td>E-commerce product card</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Component</x-badge></td>
                <td><strong>resources/views/components/card-subscription-plan.blade.php</strong></td>
                <td>Subscription pricing plan card</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Component</x-badge></td>
                <td><strong>resources/views/components/card-post.blade.php</strong></td>
                <td>Vertical blog post card</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Component</x-badge></td>
                <td><strong>resources/views/components/card-post-horizontal.blade.php</strong></td>
                <td>Horizontal blog post card</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Component</x-badge></td>
                <td><strong>resources/views/components/card-testimonial.blade.php</strong></td>
                <td>Customer testimonial card</td>
            </tr>
        </tbody>
    </table>

    <p class="pt-8 text-on-surface-muted dark:text-on-surface-muted-dark text-sm">For the detailed documentation, please
        visit the <a href="https://www.penguinui.com/components/card" target="_blank">Penguin UI Cards</a>.</p>

</x-layouts.docs>
