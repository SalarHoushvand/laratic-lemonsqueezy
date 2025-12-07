@push('head')
    <title>Translation Extractor - {{ config('app.name') }}</title>
    <meta name="description"
        content="Document the translations:extract Artisan command, its options, and how it keeps your JSON language files in sync.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'Documentation', 'url' => '#'], ['label' => 'Translation Extractor', 'url' => '#']]">

    <h1>Translation Extractor</h1>
    <p class="text-on-surface-muted dark:text-on-surface-dark-muted">
        The <code>translations:extract</code> command scans PHP and Blade files for string-based translation helpers and
        keeps your <code>lang/&lt;locale&gt;.json</code> files up to date. It lives in
        <code>App\Console\Commands\ExtractTranslations</code> and can run against the whole project or a curated list of
        folders.
    </p>

    <x-alert variant="soft-primary" class="my-6">
        Existing translations are never overwritten. Newly discovered keys are appended with the key itself as the
        placeholder value so translators can fill them in later.
    </x-alert>

    <h2>Signature & options</h2>
    <p>
        The command definition mirrors its usage examples, so what you see in the table below is exactly what the
        <code>$signature</code> block declares:
    </p>

    <pre><code class="language-bash">php artisan translations:extract

--lang=en : Target language (resources/lang/&lt;lang&gt;.json)
--paths=* : Limit scan to one or more directories
--dry-run : Only show keys without writing any files</code></pre>

    <div class="overflow-x-auto my-6">
        <table>
            <thead>
                <tr>
                    <th>Option</th>
                    <th>Type</th>
                    <th>Default</th>
                    <th>What it controls</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>--lang=</code></td>
                    <td>String</td>
                    <td><code>en</code></td>
                    <td>Chooses which <code>lang/&lt;locale&gt;.json</code> file to update (or create if missing).</td>
                </tr>
                <tr>
                    <td><code>--paths=</code></td>
                    <td>Array of paths</td>
                    <td><code>app</code>, <code>resources/views</code></td>
                    <td>Limits the scan to specific directories when you do not want to traverse the whole codebase.
                    </td>
                </tr>
                <tr>
                    <td><code>--dry-run</code></td>
                    <td>Boolean flag</td>
                    <td><code>false</code></td>
                    <td>Prints keys to the console instead of touching any files—perfect for CI or quick audits.</td>
                </tr>
            </tbody>
        </table>
    </div>


    <h2>Usage</h2>

    <h3>Baseline extraction</h3>
    <pre><code class="language-bash">php artisan translations:extract</code></pre>
    <p>Scans <code>app/</code> and <code>resources/views/</code>, then updates <code>lang/en.json</code>.</p>

    <h3>French translations with custom folders</h3>
    <pre><code class="language-bash">php artisan translations:extract --lang=fr --paths=app --paths=resources/views/components</code></pre>
    <p>Targets the French JSON file while limiting the scan to the application logic and Blade components.</p>

    <h3>Dry-run in CI</h3>
    <pre><code class="language-bash">php artisan translations:extract --dry-run --paths=resources/views/pages</code></pre>
    <p>Lists the missing keys in the console so the pipeline can fail if translators need to catch up.</p>

    <h2>Where to find it</h2>
    <ul>
        <li><x-badge variant="outline-primary">Command</x-badge>
            <code>app/Console/Commands/ExtractTranslations.php</code>
        </li>
        <li><x-badge variant="outline-primary">Language store</x-badge>
            <code>lang/&lt;locale&gt;.json</code>
        </li>
    </ul>

</x-layouts.docs>
