@push('head')
    <title>Extra Pages - Privacy & Terms - {{ config('app.name') }}</title>
    <meta name="description"
        content="Single reference for the privacy policy and terms of service marketing pages, including structure and editing tips.">
@endpush

<x-layouts.docs :breadcrumbs="[
    ['label' => 'Extra Pages', 'url' => '#'],
    ['label' => 'Legal', 'url' => '#'],
    ['label' => 'Privacy & Terms', 'url' => '#'],
]">

    <h1>Privacy & Terms Pages</h1>
    <p class="text-on-surface-muted dark:text-on-surface-dark-muted">
        {{ config('app.name') }} provides a well designed privacy and terms of service pages that you can use in your
        project.
    </p>

    <img src="{{ asset('images/docs/legal-pages-dark.webp') }}" alt="Privacy & Terms Pages"
        class="hidden dark:block border-0!">
    <img src="{{ asset('images/docs/legal-pages-light.webp') }}" alt="Privacy & Terms Pages" class="dark:hidden border-0!">

    <p class="text-on-surface-muted dark:text-on-surface-dark-muted">You can use these pages as a template to create your own privacy and terms of service pages. Or even copy and make 
        more pages such as cookie policy, GDPR compliance, etc.
    </p>

</x-layouts.docs>
