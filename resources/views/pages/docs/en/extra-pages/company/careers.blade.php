@push('head')
    <title>Extra Pages - Careers - {{ config('app.name') }}</title>
    <meta name="description"
        content="Document the marketing careers page, the reusable listings component, and how to swap in real jobs.">
@endpush

<x-layouts.docs :breadcrumbs="[
    ['label' => 'Extra Pages', 'url' => '#'],
    ['label' => 'Company', 'url' => '#'],
    ['label' => 'Careers', 'url' => '#'],
]">

    <h1>Careers Page</h1>
    <p class="text-on-surface-muted dark:text-on-surface-dark-muted">
        <code>/careers</code> is a lightweight marketing page that highlights open roles using a single Blade component.
        It is a simple listing page that you add available positions and link to the application platform where the
        candidates can apply (such as linkedin or indeed).
    </p>
    <img src="{{ asset('images/docs/careers-dark.webp') }}" alt="Careers Page" class="hidden dark:block ">
    <img src="{{ asset('images/docs/careers-light.webp') }}" alt="Careers Page" class="dark:hidden ">

    <h2>Adding positions</h2>
    <p>Simply add a new array item to the <code>$listings</code> array in the <code>x-blocks.careers.listings</code>
        component:</p>
<pre><code class="language-php">$listings = [
    [
        'title' => 'Software Engineer',
        'location' => 'Remote',
        'type' => 'Full-time',
        'description' =>
            'We are looking for a software engineer with a passion for building scalable and efficient systems.',
        'url' => 'https://www.linkedin.com/jobs/view/3900000000000000000',
    ],
];</code></pre>

</x-layouts.docs>
