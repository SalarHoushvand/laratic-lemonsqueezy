@push('head')
    <title>Extra Pages - Pre-launch Waitlist - {{ config('app.name') }}</title>
    <meta name="description"
        content="Explain what appears on /waitlist, the Livewire form behind it, and how submissions are stored.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'Extra Pages', 'url' => '#'], ['label' => 'Pre-launch Waitlist', 'url' => '#']]">

    <h1>Pre-launch Waitlist Page</h1>
    <p class="text-on-surface-muted dark:text-on-surface-dark-muted">
        The waitlist experience keeps interest high while the product is still private. It lives at
        <code>/waitlist</code> and uses the minimal layout so the hero headline, consent checkboxes, and social links
        stay centered on every screen size.
    </p>

    <img src="{{ asset('images/docs/waitlist-dark.webp') }}" alt="Pre-launch Waitlist Page" class="hidden dark:block ">
    <img src="{{ asset('images/docs/waitlist-light.webp') }}" alt="Pre-launch Waitlist Page" class="dark:hidden ">

 
    <h2>Where does the submission go?</h2>
    The submissions are stored in the <code>waitlists</code> table. You can change this to instead add them to your newsletter. To do that go to Livewire > Forms > Newsletter and uncomment the code that adds them to the newsletter.

    <pre><code class="language-php">
        $validated = $this->validate();

        // replace this 
        $waitlist = WaitlistModel::create($validated);

        // With this
        NewsletterMailchimp::subscribeOrUpdate($validated['email']);
    </code></pre>
 

    <h2>Related</h2>
    <a href="{{ route('docs.show', ['topic' => 'newsletter']) }}">Newsletter</a> - Learn how to use the newsletter subscription component with Mailchimp integration.

</x-layouts.docs>
