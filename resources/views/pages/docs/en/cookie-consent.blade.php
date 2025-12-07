@push('head')
    <title>Cookie Consent Banner - {{ config('app.name') }}</title>
    <meta name="description" content="Learn how to use the cookie consent banner component with Google Analytics integration and how to add additional tracking scripts.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'Cookie Consent Banner', 'url' => '#']]">

    <h1>Cookie Consent Banner</h1>
    <p>This application includes a simple cookie consent banner component that lets you add Google Analytics and other tracking scripts to your application.</p>
    <img src="{{ asset('images/docs/cookie-banner-dark.webp') }}" alt="Cookie Consent Banner" class="hidden dark:block">
    <img src="{{ asset('images/docs/cookie-banner-light.webp') }}" alt="Cookie Consent Banner" class="dark:hidden">
    <p>By default, the cookie banner is added to the guest layout. To add it to other layouts or pages, include it like this:</p>
    <pre><code>&lt;x-blocks.cookie-banner /&gt;</code></pre>

    <h2>Google Analytics Support</h2>
    <p>The component has built-in support for Google Analytics 4 (GA4). It validates the GA ID format and only loads the Google Tag Manager script after the user gives consent.</p>

    <h3>How to Add Your Google Analytics Tag</h3>
    <p>Set the <code>GOOGLE_ANALYTICS_ID</code> environment variable in your <code>.env</code> file:</p>

    <pre><code>GOOGLE_ANALYTICS_ID=G-XXXXXXXXXX</code></pre>

    <h2>How to Add More Tracking Scripts</h2>
    <p>To add additional tracking scripts, modify the <code>loadMoreScripts()</code> method in the component. This method runs automatically after the user accepts cookies.</p>

    <h3>Step 1: Locate the Component</h3>
    <p>The cookie banner component is located at:</p>
    <pre><code>resources/views/components/blocks/cookie-banner.blade.php</code></pre>

    <h3>Step 2: Add Your Scripts</h3>
    <p>Find the <code>loadMoreScripts()</code> method and add your tracking scripts. Here's an example:</p>

    <h4>Example: Adding Facebook Pixel</h4>
    <pre><code>loadMoreScripts() {
    // Facebook Pixel
    if (document.getElementById('fb-pixel')) return;
    
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    
    const fbPixel = document.createElement('script');
    fbPixel.id = 'fb-pixel';
    fbPixel.innerHTML = 'fbq("init", "YOUR_PIXEL_ID"); fbq("track", "PageView");';
    document.head.appendChild(fbPixel);
}</code></pre>

    <h3>Step 3: Call the Method</h3>
    <p>Make sure the <code>enableScripts()</code> method calls <code>loadMoreScripts()</code>:</p>

    <pre><code>enableScripts() {
    this.loadAnalytics();
    this.loadMoreScripts();
}</code></pre>

   
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
                <td><strong>resources/views/components/blocks/cookie-banner.blade.php</strong></td>
                <td>Cookie consent banner component</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Layout</x-badge></td>
                <td><strong>resources/views/components/layouts/guest.blade.php</strong></td>
                <td>Guest layout where the component is included by default</td>
            </tr>
        </tbody>
    </table>

</x-layouts.docs>

