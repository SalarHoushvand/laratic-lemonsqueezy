@push('head')
    <title>Database Seeders - {{ config('app.name') }}</title>
    <meta name="description"
        content="Choose between the Minimal, Demo, or Heavy seeders and learn how to run them safely.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'Admin', 'url' => '#'], ['label' => 'Database Seeders', 'url' => '#']]">

    <h1>Database Seeders</h1>
    <p class="text-on-surface-muted dark:text-on-surface-dark-muted">
        {{ config('app.name') }} ships with three curated seeders so you can load just enough sample data (or a lot of it)
        depending on your environment. Each seeder calls the same underlying classes but tweaks the record counts and
        percentages to simulate different workloads.
    </p>

    <x-alert variant="soft-primary" class="my-6">
        The root <code>DatabaseSeeder</code> calls <code>DemoSeeder</code> by default, so
        <code>php artisan db:seed</code> always gives you the demo dataset unless you override it with
        <code>--class</code>.
    </x-alert>

    <h2>Side-by-side comparison</h2>
    <div class="overflow-x-auto">
        <table>
            <thead>
                <tr>
                    <th>Seeder</th>
                    <th>Ideal for</th>
                    <th>Users</th>
                    <th>AI usage per user</th>
                    <th>Subscriptions</th>
                    <th>Orders</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Minimal</strong></td>
                    <td>Fresh installs, quick demos</td>
                    <td>1 admin + 10 users</td>
                    <td>2-5 records</td>
                    <td>~20% of users</td>
                    <td>~15% of users, 1-2 orders</td>
                </tr>
                <tr>
                    <td><strong>Demo</strong></td>
                    <td>Sales demos, screenshots</td>
                    <td>1 admin + 500 users</td>
                    <td>10-30 records</td>
                    <td>~35% of users</td>
                    <td>~25% of users, 1-5 orders</td>
                </tr>
                <tr>
                    <td><strong>Heavy</strong></td>
                    <td>Stress testing, perf profiling</td>
                    <td>1 admin + 5,000 users</td>
                    <td>3-8 records (350k+ rows)</td>
                    <td>~10% of users</td>
                    <td>~30% of users, 0-2 orders</td>
                </tr>
            </tbody>
        </table>
    </div>
   
    <h2>How to run each seeder</h2>

    <h3>Basic commands</h3>
    <ul>
        <li><code>php artisan db:seed</code> &rarr; runs <code>DemoSeeder</code> via <code>DatabaseSeeder</code>.</li>
        <li><code>php artisan db:seed --class=MinimalSeeder</code> &rarr; loads the compact dataset.</li>
        <li><code>php artisan db:seed --class=DemoSeeder</code> &rarr; explicitly reseeds the demo data.</li>
        <li><code>php artisan db:seed --class=HeavySeeder</code> &rarr; kicks off the heavy scenario.</li>
    </ul>

    <h3>After a fresh migration</h3>
    <p>
        Combine migrations and seeding when you want a clean slate:
    </p>
    <pre><code class="language-bash">php artisan migrate:fresh --seed --seeder=MinimalSeeder
php artisan migrate:fresh --seed --seeder=DemoSeeder
php artisan migrate:fresh --seed --seeder=HeavySeeder</code></pre>

    <h3>Production safety</h3>
    <ul>
        <li>Laravel prompts for confirmation in <code>production</code>. Add <code>--force</code> only if you are sure:
            <code>php artisan db:seed --class=MinimalSeeder --force</code>.</li>
        <li>Heavy seeding can take several minutes; run it inside a detached terminal session and monitor disk space.</li>
        <li>Each seeder is idempotent enough for local use, but if you need a truly clean slate, favor
            <code>migrate:fresh --seed</code>.</li>
    </ul>

    <h2>Where the seeders live</h2>
    <ul>
        <li><x-badge variant="outline-primary">File</x-badge>
            <code>database/seeders/MinimalSeeder.php</code>
        </li>
        <li><x-badge variant="outline-primary">File</x-badge>
            <code>database/seeders/DemoSeeder.php</code>
        </li>
        <li><x-badge variant="outline-primary">File</x-badge>
            <code>database/seeders/HeavySeeder.php</code>
        </li>
        <li><x-badge variant="outline-primary">Entry point</x-badge>
            <code>database/seeders/DatabaseSeeder.php</code>
        </li>
    </ul>

</x-layouts.docs>

