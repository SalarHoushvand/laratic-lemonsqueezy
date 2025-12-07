@push('head')
    <title>Combobox Components - {{ config('app.name') }}</title>
    <meta name="description"
        content="Learn how to use Combobox components. Searchable dropdown components for single selection.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'UI Components', 'url' => '#'], ['label' => 'Combobox', 'url' => '#']]">

    <h1>Combobox</h1>
    <p>Searchable dropdown component for single selection with Livewire integration.</p>

    <h2>Usage</h2>
    <pre><code class="language-html">&lt;x-combobox
    :options="$options"
    wire:model="selectedValue"
    label="Select an option"
/&gt;</code></pre>

    @php
        $basicOptions = [
            ['value' => '1', 'label' => 'Option 1'],
            ['value' => '2', 'label' => 'Option 2'],
            ['value' => '3', 'label' => 'Option 3'],
            ['value' => '4', 'label' => 'Option 4'],
        ];
    @endphp

    <div class="mt-4 not-prose max-w-md">
        <div x-data="{ selectedValue: null }">
            <x-combobox
                :options="$basicOptions"
                x-model="selectedValue"
                label="Select an option"
            />
            <p class="mt-2 text-sm text-on-surface/70 dark:text-on-surface-dark/70" x-show="selectedValue">
                Selected: <span x-text="selectedValue"></span>
            </p>
        </div>
    </div>

    <h2>With Images and Secondary Display</h2>
    <p>Display images and secondary text alongside options:</p>
    <pre><code class="language-html">&lt;x-combobox
    id="selectedTranslationLanguage"
    wire:model.live="selectedTranslationLanguage"
    wire:target="createTranslationWithAi, createManualTranslation"
    :options="$formattedOptions"
    imageKey="flag"
    displayKey="label"
    secondaryDisplayKey="localName"
    valueKey="value"
    :placeholder="__('Select a language')"
/&gt;</code></pre>

    @php
        $languageOptions = [
            [
                'value' => 'en',
                'label' => 'English',
                'localName' => 'English',
                'flag' => 'https://flagcdn.com/gb.svg',
            ],
            [
                'value' => 'fr',
                'label' => 'French',
                'localName' => 'Français',
                'flag' => 'https://flagcdn.com/fr.svg',
            ],
            [
                'value' => 'de',
                'label' => 'German',
                'localName' => 'Deutsch',
                'flag' => 'https://flagcdn.com/de.svg',
            ],
            [
                'value' => 'es',
                'label' => 'Spanish',
                'localName' => 'Español',
                'flag' => 'https://flagcdn.com/es.svg',
            ],
        ];
    @endphp

    <div class="mt-4 not-prose max-w-md">
        <div x-data="{ selectedLanguage: null }">
            <x-combobox
                :options="$languageOptions"
                x-model="selectedLanguage"
                imageKey="flag"
                displayKey="label"
                secondaryDisplayKey="localName"
                valueKey="value"
                :placeholder="__('Select a language')"
            />
            <p class="mt-2 text-sm text-on-surface/70 dark:text-on-surface-dark/70" x-show="selectedLanguage">
                Selected: <span x-text="selectedLanguage"></span>
            </p>
        </div>
    </div>

    <h2>Multi-Select Combobox</h2>
    <p>Allow users to select multiple options from a searchable dropdown list.</p>

    <h3>Usage</h3>
    <pre><code class="language-html">&lt;x-combobox-multiselect
    :options="$options"
    wire:model="selectedValues"
    label="Select categories"
    :placeholder="__('Select categories')"
/&gt;</code></pre>

    @php
        $multiSelectOptions = [
            ['value' => '1', 'label' => 'Technology'],
            ['value' => '2', 'label' => 'Design'],
            ['value' => '3', 'label' => 'Business'],
            ['value' => '4', 'label' => 'Marketing'],
            ['value' => '5', 'label' => 'Development'],
        ];
    @endphp

    <div class="mt-4 not-prose max-w-md">
        <div x-data="{ selectedValues: [] }">
            <x-combobox-multiselect
                :options="$multiSelectOptions"
                x-model="selectedValues"
                label="Select categories"
                :placeholder="__('Select categories')"
            />
            <p class="mt-2 text-sm text-on-surface/70 dark:text-on-surface-dark/70" x-show="selectedValues.length > 0">
                Selected: <span x-text="selectedValues.join(', ')"></span>
            </p>
        </div>
    </div>

    <h3>Example with Categories</h3>
    <pre><code class="language-html">&lt;x-combobox-multiselect
    id="categories"
    name="categories"
    wire:model="categories"
    :options="$this->options"
    :label="__('Categories')"
    :placeholder="__('Select categories')"
    emptyStateMessage="{{ __('No categories available') }}"
    displayKey="label"
    valueKey="value"
/&gt;</code></pre>

    @php
        $categoryOptions = [
            ['value' => '1', 'label' => 'Web Development'],
            ['value' => '2', 'label' => 'Mobile Apps'],
            ['value' => '3', 'label' => 'UI/UX Design'],
            ['value' => '4', 'label' => 'Data Science'],
            ['value' => '5', 'label' => 'DevOps'],
        ];
    @endphp

    <div class="mt-4 not-prose max-w-md">
        <div x-data="{ categories: [] }">
            <x-combobox-multiselect
                id="categories-example"
                name="categories-example"
                x-model="categories"
                :options="$categoryOptions"
                :label="__('Categories')"
                :placeholder="__('Select categories')"
                emptyStateMessage="{{ __('No categories available') }}"
                displayKey="label"
                valueKey="value"
            />
            <p class="mt-2 text-sm text-on-surface/70 dark:text-on-surface-dark/70" x-show="categories.length > 0">
                Selected categories: <span x-text="categories.join(', ')"></span>
            </p>
        </div>
    </div>

    <h2>Phone Combobox</h2>
    <p>Combined country code selector with phone number input field.</p>

    <h3>Usage</h3>
    <pre><code class="language-html">&lt;x-combobox-phone
    wire:model="phoneNumber"
    label="Phone Number"
    defaultCountry="us"
/&gt;</code></pre>

    <div class="mt-4 not-prose max-w-md">
        <div x-data="{ phoneNumber: '' }">
            <x-combobox-phone
                x-model="phoneNumber"
                label="Phone Number"
                defaultCountry="us"
            />
            <p class="mt-2 text-sm text-on-surface/70 dark:text-on-surface-dark/70" x-show="phoneNumber">
                Phone: <span x-text="phoneNumber"></span>
            </p>
        </div>
    </div>

    <h2>Options Format</h2>
    <p>Options should be formatted as arrays with <code>value</code>, <code>label</code>, and optional keys:</p>
    <pre><code class="language-php">$formattedOptions = [
    [
        'value' => 'en',
        'label' => 'English',
        'localName' => 'English',
        'flag' => 'https://flagcdn.com/gb.svg',
    ],
    [
        'value' => 'fr',
        'label' => 'French',
        'localName' => 'Français',
        'flag' => 'https://flagcdn.com/fr.svg',
    ],
];</code></pre>

    <h2>Livewire Integration</h2>
    <p>The combobox supports all Livewire model modifiers:</p>
    <ul>
        <li><code>wire:model</code> - Deferred updates</li>
        <li><code>wire:model.live</code> - Real-time updates</li>
        <li><code>wire:model.defer</code> - Explicit deferred</li>
    </ul>
    <p>Use <code>wire:target</code> to specify which actions should show loading states:</p>
    <pre><code class="language-html">&lt;x-combobox
    wire:model.live="selectedValue"
    wire:target="save, update"
    :options="$options"
/&gt;</code></pre>

    <h2>Props Reference</h2>

    <h3>Combobox Props</h3>
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
                <td><code>options</code></td>
                <td>array</td>
                <td><code>[]</code></td>
                <td>Array of option objects</td>
            </tr>
            <tr>
                <td><code>wire:model</code></td>
                <td>string</td>
                <td>-</td>
                <td>Livewire property to bind (supports <code>.live</code>, <code>.defer</code>, etc.)</td>
            </tr>
            <tr>
                <td><code>displayKey</code></td>
                <td>string</td>
                <td><code>label</code></td>
                <td>Key for primary display text</td>
            </tr>
            <tr>
                <td><code>secondaryDisplayKey</code></td>
                <td>string|null</td>
                <td><code>null</code></td>
                <td>Key for secondary display text (shown in parentheses)</td>
            </tr>
            <tr>
                <td><code>valueKey</code></td>
                <td>string</td>
                <td><code>value</code></td>
                <td>Key for the option value</td>
            </tr>
            <tr>
                <td><code>imageKey</code></td>
                <td>string|null</td>
                <td><code>null</code></td>
                <td>Key for image URL to display with options</td>
            </tr>
            <tr>
                <td><code>placeholder</code></td>
                <td>string|null</td>
                <td><code>Please select</code></td>
                <td>Placeholder text when no option is selected</td>
            </tr>
            <tr>
                <td><code>label</code></td>
                <td>string|null</td>
                <td><code>null</code></td>
                <td>Label text displayed above the combobox</td>
            </tr>
            <tr>
                <td><code>searchable</code></td>
                <td>bool</td>
                <td><code>true</code></td>
                <td>Enable search functionality</td>
            </tr>
            <tr>
                <td><code>disabled</code></td>
                <td>bool</td>
                <td><code>false</code></td>
                <td>Disable the combobox</td>
            </tr>
        </tbody>
    </table>

    <h3>Multi-Select Combobox Props</h3>
    <p>Multi-select combobox supports all standard combobox props, plus:</p>
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
                <td><code>selectedValues</code></td>
                <td>array</td>
                <td><code>[]</code></td>
                <td>Initial selected values (array of option values)</td>
            </tr>
            <tr>
                <td><code>emptyStateMessage</code></td>
                <td>string|null</td>
                <td><code>No options available</code></td>
                <td>Message displayed when no options are available</td>
            </tr>
        </tbody>
    </table>
    <p><strong>Note:</strong> The <code>wire:model</code> property should be bound to an array. Selected values are stored as an array of option values.</p>

    <h3>Phone Combobox Props</h3>
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
                <td><code>wire:model</code></td>
                <td>string</td>
                <td>-</td>
                <td>Livewire property to bind the phone number</td>
            </tr>
            <tr>
                <td><code>defaultCountry</code></td>
                <td>string</td>
                <td><code>us</code></td>
                <td>ISO code of the default country (e.g., 'us', 'gb', 'fr')</td>
            </tr>
            <tr>
                <td><code>placeholder</code></td>
                <td>string</td>
                <td><code>+00 000-000-0000</code></td>
                <td>Placeholder for the phone number input</td>
            </tr>
            <tr>
                <td><code>label</code></td>
                <td>string</td>
                <td><code>Phone Number</code></td>
                <td>Label text displayed above the input</td>
            </tr>
            <tr>
                <td><code>disabled</code></td>
                <td>bool</td>
                <td><code>false</code></td>
                <td>Disable the phone input</td>
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
                <td><strong>resources/views/components/combobox.blade.php</strong></td>
                <td>Single-select combobox</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Component</x-badge></td>
                <td><strong>resources/views/components/combobox-multiselect.blade.php</strong></td>
                <td>Multi-select combobox</td>
            </tr>
            <tr>
                <td><x-badge variant="outline-primary">Component</x-badge></td>
                <td><strong>resources/views/components/combobox-phone.blade.php</strong></td>
                <td>Phone number input with country selector</td>
            </tr>
        </tbody>
    </table>

    <p class="pt-8 text-on-surface-muted dark:text-on-surface-muted-dark text-sm">For the detailed documentation, please
        visit the <a href="https://www.penguinui.com/components/combobox" target="_blank">Penguin UI Combobox</a>.</p>
</x-layouts.docs>
