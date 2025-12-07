@push('head')
    <title>Tests - {{ config('app.name') }}</title>
    <meta name="description"
        content="Learn about the test suite included in {{ config('app.name') }}. Laratic includes basic tests to ensure your application works correctly.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'Basics', 'url' => '#'], ['label' => 'Tests', 'url' => '#']]">

    <h1>Tests</h1>
    <p>
        {{ config('app.name') }} includes some basic tests to check that your application works correctly. These simple tests
        verify that authentication, authorization, and public pages are functioning as expected. We might include more tests in
        the future.
    </p>

    <h2>Running Tests</h2>
    <p>To run all tests, use the following command:</p>
    <pre><code class="language-bash">php artisan test</code></pre>
    <p>To run a specific test file:</p>
    <pre><code class="language-bash">php artisan test tests/Feature/AuthPagesTest.php</code></pre>

</x-layouts.docs>

