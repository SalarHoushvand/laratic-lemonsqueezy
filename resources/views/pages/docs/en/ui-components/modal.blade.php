@push('head')
    <title>Modal Component - {{ config('app.name') }}</title>
    <meta name="description"
        content="Learn how to use the Modal component. A flexible modal dialog component for displaying content above the main page.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'UI Components', 'url' => '#'], ['label' => 'Modal', 'url' => '#']]">

    <h1>Modal Component</h1>
    <p>The Modal component provides a dialog overlay for displaying content above the main page.</p>

    <h2>Basic Usage</h2>
    <p>Use the modal-trigger component to open a modal with header, content, and footer:</p>
    <pre><code class="language-html">&lt;x-modal-trigger target="example-modal"&gt;
    &lt;x-button&gt;Open Modal&lt;/x-button&gt;
&lt;/x-modal-trigger&gt;

&lt;x-modal name="example-modal" maxWidth="md"&gt;
    &lt;x-slot:header&gt;
        &lt;h3 class="font-semibold"&gt;Modal Title&lt;/h3&gt;
    &lt;/x-slot:header&gt;

    &lt;div class="p-4"&gt;
        &lt;p&gt;This is the modal content.&lt;/p&gt;
    &lt;/div&gt;

    &lt;x-slot:footer&gt;
        &lt;x-button variant="ghost" x-on:click="modalIsOpen = false" class="w-full sm:w-fit"&gt;
            Cancel
        &lt;/x-button&gt;
        &lt;x-button variant="primary" class="w-full sm:w-fit"&gt;
            Confirm
        &lt;/x-button&gt;
    &lt;/x-slot:footer&gt;
&lt;/x-modal&gt;</code></pre>

    <div class="my-6 not-prose">
        <x-modal-trigger target="demo-modal">
            <x-button>Open Modal</x-button>
        </x-modal-trigger>

        <x-modal name="demo-modal" maxWidth="md">
            <x-slot:header>
                <h3 class="font-semibold">Modal Title</h3>
            </x-slot:header>

            <div class="p-4">
                <p>This is the modal content.</p>
            </div>

            <x-slot:footer>
                <x-button variant="ghost" x-on:click="modalIsOpen = false" class="w-full sm:w-fit">
                    Cancel
                </x-button>
                <x-button variant="primary" class="w-full sm:w-fit">
                    Confirm
                </x-button>
            </x-slot:footer>
        </x-modal>
    </div>

    <h2>Opening from Livewire</h2>
    <p>Dispatch an event from your Livewire component to open a modal:</p>
    <pre><code class="language-php">// In your Livewire component
public function showModal()
{
    $this->dispatch('open-modal', name: 'my-modal');
}

// Or close it
public function closeModal()
{
    $this->dispatch('close-modal');
}</code></pre>

    <p>In your Blade view:</p>
    <pre><code class="language-html">&lt;x-button wire:click="showModal"&gt;Open Modal&lt;/x-button&gt;

&lt;x-modal name="my-modal"&gt;
    &lt;x-slot:header&gt;
        &lt;h3 class="font-semibold"&gt;Title&lt;/h3&gt;
    &lt;/x-slot:header&gt;

    &lt;div class="p-4"&gt;
        &lt;p&gt;Modal content&lt;/p&gt;
    &lt;/div&gt;
&lt;/x-modal&gt;</code></pre>

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
                <td><code>name</code></td>
                <td>string|null</td>
                <td><code>null</code></td>
                <td>Unique name for the modal. Required when using modal-trigger or dispatching events.</td>
            </tr>
            <tr>
                <td><code>maxWidth</code></td>
                <td>string</td>
                <td><code>2xl</code></td>
                <td>Maximum width of the modal. Options: <code>sm</code>, <code>md</code>, <code>lg</code>, <code>xl</code>, <code>2xl</code>, <code>3xl</code>, <code>4xl</code></td>
            </tr>
            <tr>
                <td><code>show</code></td>
                <td>bool</td>
                <td><code>false</code></td>
                <td>Whether the modal is initially open.</td>
            </tr>
            <tr>
                <td><code>backdropBlur</code></td>
                <td>string</td>
                <td><code>sm</code></td>
                <td>Backdrop blur intensity. Options: <code>none</code>, <code>sm</code>, <code>md</code>, <code>lg</code>, <code>xl</code>, <code>2xl</code>, <code>3xl</code></td>
            </tr>
            <tr>
                <td><code>backdropOpacity</code></td>
                <td>string</td>
                <td><code>sm</code></td>
                <td>Backdrop opacity level. Options: <code>none</code>, <code>sm</code>, <code>md</code>, <code>lg</code>, <code>xl</code>, <code>2xl</code>, <code>3xl</code></td>
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
                <td><code>header</code></td>
                <td>Modal header section. Displayed at the top with a close button.</td>
            </tr>
            <tr>
                <td>Default slot</td>
                <td>Main modal content area.</td>
            </tr>
            <tr>
                <td><code>footer</code></td>
                <td>Modal footer section. Typically used for action buttons.</td>
            </tr>
            <tr>
                <td><code>trigger</code></td>
                <td>Optional trigger element inside the modal component (alternative to using <code>x-modal-trigger</code>).</td>
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
                <td><strong>resources/views/components/modal.blade.php</strong></td>
                <td>Modal component file</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Component</x-badge></td>
                <td><strong>resources/views/components/modal-trigger.blade.php</strong></td>
                <td>Modal trigger helper component</td>
            </tr>
        </tbody>
    </table>

    <p class="pt-8 text-on-surface-muted dark:text-on-surface-muted-dark text-sm">For the detailed documentation, please
        visit the <a href="https://www.penguinui.com/components/modal" target="_blank">Penguin UI Modals</a>.</p>
</x-layouts.docs>

