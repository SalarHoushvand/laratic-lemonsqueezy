@push('head')
    <title>Extra Pages - Contact Forms - {{ config('app.name') }}</title>
    <meta name="description"
        content="Quick reference for the marketing contact and request demo Livewire forms.">
@endpush

<x-layouts.docs :breadcrumbs="[
    ['label' => 'Extra Pages', 'url' => '#'],
    ['label' => 'Company', 'url' => '#'],
    ['label' => 'Contact Forms', 'url' => '#'],
]">

    <h1>Contact & Request Demo Forms</h1>
    <p class="text-on-surface-muted dark:text-on-surface-dark-muted">
        Two Livewire forms handle inbound conversations: a general contact form for support or questions, and a request demo
        form for high-intent sales leads. Both reuse the same consent copy, honeypot spam trap, and toast notification
        pattern so UX stays consistent across marketing pages.
    </p>
    <img src="{{ asset('images/docs/contact-forms-dark.webp') }}" alt="Contact Forms Page" class="hidden dark:block border-0!">
    <img src="{{ asset('images/docs/contact-forms-light.webp') }}" alt="Contact Forms Page" class="dark:hidden border-0!">
  

    <p class="text-on-surface-muted dark:text-on-surface-dark-muted">
       The submissions are stored in the <code>contact_requests</code> and <code>demo_requests</code> tables. 
       In addition an email is sent to the <code>CONTACT_EMAIL</code> address(you can change this in the <code>.env</code> file) containing the details of the request.
    </p>

    <h2>Where to use them</h2>
    <ul>
        <li>You can also drop <code>&lt;livewire:forms.contact /&gt;</code> anywhere in your project to add the contact form.</li>
        <li>You can also drop <code>&lt;livewire:forms.request-demo /&gt;</code> anywhere in your project to add the request demo form.</li>
    </ul>




</x-layouts.docs>


