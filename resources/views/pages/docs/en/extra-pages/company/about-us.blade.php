@push('head')
    <title>Extra Pages - About Us - {{ config('app.name') }}</title>
    <meta name="description"
        content="Break down the About Us storytelling page and the Blade components that compose it.">
@endpush

<x-layouts.docs :breadcrumbs="[
    ['label' => 'Extra Pages', 'url' => '#'],
    ['label' => 'Company', 'url' => '#'],
    ['label' => 'About Us', 'url' => '#'],
]">

    <h1>About Us Page</h1>
    <p class="text-on-surface-muted dark:text-on-surface-dark-muted">
       Use this page to tell the story of your product and your company. {{ config('app.name') }} provides a set of Blade components that you can use to create a beautiful about us page.
    </p>
    <img src="{{ asset('images/docs/about-us-dark.webp') }}" alt="About Us Page" class="hidden dark:block ">
    <img src="{{ asset('images/docs/about-us-light.webp') }}" alt="About Us Page" class="dark:hidden ">
    <h2>Component lineup</h2>
    <ul>
        <li><x-badge variant="outline-primary">Hero</x-badge>
            <code>x-blocks.about-us.hero</code> &mdash; renders the page header with dynamic product name copy.</li>
        <li><x-badge variant="outline-primary">Our Story</x-badge>
            <code>x-blocks.about-us.our-story</code> shows imagery plus two paragraphs of narrative text.</li>
        <li><x-badge variant="outline-primary">Statistics</x-badge>
            <code>x-blocks.about-us.statistics</code> (see file for metric array) highlights traction.</li>
        <li><x-badge variant="outline-primary">Our Team</x-badge>
            <code>x-blocks.about-us.our-team</code> seeds a list of headshots + roles. Swap the inline array for your
            real team.</li>
        <li><x-badge variant="outline-primary">Contact Us</x-badge>
            reuses the <code>livewire:forms.contact</code> component so prospects can reach out without leaving the page.</li>
    </ul>


</x-layouts.docs>


