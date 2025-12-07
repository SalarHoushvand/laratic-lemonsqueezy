@push('head')
    <title>Design System - {{ config('app.name') }}</title>
    <meta name="description"
        content="Visual reference for colors, typography, and design tokens in {{ config('app.name') }}.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'Design', 'url' => '#'], ['label' => 'Design System', 'url' => '#']]">

    @php
        $colorTokens = [
            [
                'name' => 'Surface',
                'light' => '--color-surface',
                'dark' => '--color-surface-dark',
                'on' => '--color-on-surface',
                'on-dark' => '--color-on-surface-dark',
            ],
            [
                'name' => 'Surface Alt',
                'light' => '--color-surface-alt',
                'dark' => '--color-surface-dark-alt',
                'on' => '--color-on-surface',
                'on-dark' => '--color-on-surface-dark',
            ],
            [
                'name' => 'Primary',
                'light' => '--color-primary',
                'dark' => '--color-primary-dark',
                'on' => '--color-on-primary',
                'on-dark' => '--color-on-primary-dark',
            ],
            [
                'name' => 'Secondary',
                'light' => '--color-secondary',
                'dark' => '--color-secondary-dark',
                'on' => '--color-on-secondary',
                'on-dark' => '--color-on-secondary-dark',
            ],
        ];

        $statusColors = [
            ['name' => 'Info', 'var' => '--color-info', 'on' => '--color-on-info'],
            ['name' => 'Success', 'var' => '--color-success', 'on' => '--color-on-success'],
            ['name' => 'Warning', 'var' => '--color-warning', 'on' => '--color-on-warning'],
            ['name' => 'Danger', 'var' => '--color-danger', 'on' => '--color-on-danger'],
        ];

        $textColors = [
            [
                'name' => 'Muted',
                'class' => 'text-on-surface-muted dark:text-on-surface-dark-muted',
                'description' => 'Secondary copy, helper text, and captions.',
                'dark' => '--color-on-surface-dark-muted',
                'light' => '--color-on-surface-muted',
            ],
            [
                'name' => 'On Surface',
                'class' => 'text-on-surface dark:text-on-surface-dark',
                'description' => 'Primary body copy and paragraphs.',
                'light' => '--color-on-surface',
                'dark' => '--color-on-surface-dark',
            ],
            [
                'name' => 'Strong',
                'class' => 'text-on-surface-strong dark:text-on-surface-dark-strong',
                'description' => 'Emphasis text, stats, and bold highlights.',
                'light' => '--color-on-surface-strong',
                'dark' => '--color-on-surface-dark-strong',
            ],
        ];
    @endphp

    <div>
        <h1>Design System</h1>
        <p class="text-on-surface-muted dark:text-on-surface-dark-muted">Visual reference for theme colors,
            typography, and utilities.</p>
    </div>

    {{-- Color Palette --}}
    <div class="mt-12">
        <h2 class="heading-3 mb-6">Color Tokens</h2>

        <div class="grid gap-6">
            @foreach ($colorTokens as $token)
                <div>
                    <div class="mb-4 flex items-center justify-between">
                        <h3 class="text-lg font-semibold">{{ $token['name'] }}</h3>
                        <x-badge variant="outline">Theme Aware</x-badge>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        {{-- Light Mode Swatch --}}
                        <div>
                            <p
                                class="mb-2 text-xs uppercase tracking-wide text-on-surface-muted dark:text-on-surface-dark-muted">
                                Light</p>
                            <div class="flex h-24 items-center justify-center rounded-radius border-2 border-outline text-2xl font-bold dark:border-outline-dark"
                                style="background-color: var({{ $token['light'] }}); color: var({{ $token['on'] }});">
                                Aa
                            </div>
                            <p
                                class="mt-2 text-xs font-mono whitespace-nowrap text-on-surface-muted dark:text-on-surface-dark-muted">
                                {{ $token['light'] }} <br> {{ $token['on'] }}</p>
                        </div>

                        {{-- Dark Mode Swatch --}}
                        <div>
                            <p
                                class="mb-2 text-xs uppercase tracking-wide text-on-surface-muted dark:text-on-surface-dark-muted">
                                Dark</p>
                            <div class="flex h-24 items-center justify-center rounded-radius border-2 border-outline text-2xl font-bold dark:border-outline-dark"
                                style="background-color: var({{ $token['dark'] }}); color: var({{ $token['on-dark'] }});">
                                Aa
                            </div>
                            <p
                                class="mt-2 text-xs font-mono whitespace-nowrap text-on-surface-muted dark:text-on-surface-dark-muted">
                                {{ $token['dark'] }} <br> {{ $token['on-dark'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Status Colors --}}
    <div class="mt-12">
        <h2 class="heading-3 mb-6">Status Colors</h2>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($statusColors as $status)
                <div>
                    <div class="flex p-4 items-center justify-center rounded-radius text-3xl font-bold"
                        style="background-color: var({{ $status['var'] }}); color: var({{ $status['on'] }});">
                        Aa
                    </div>
                    <p class="mt-3 font-semibold">{{ $status['name'] }}</p>
                    <p class="mt-1 text-xs font-mono text-on-surface-muted dark:text-on-surface-dark-muted">
                        {{ $status['var'] }} <br> {{ $status['on'] }}</p>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Text Colors --}}
    <div class="mt-12">
        <h2 class="heading-3 mb-6">Text Colors</h2>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($textColors as $textColor)
                <div class="rounded-radius border border-outline p-4 dark:border-outline-dark">
                    <p class="text-xs uppercase tracking-wide text-on-surface-muted dark:text-on-surface-dark-muted mb-2">
                        {{ $textColor['name'] }}
                    </p>
                    <p class="{{ $textColor['class'] }} text-xl font-semibold">
                        The quick brown fox jumps over the lazy dog.
                    </p>
                    <p class="mt-3 text-xs text-on-surface-muted dark:text-on-surface-dark-muted">
                        {{ $textColor['description'] }}
                    </p>
                    <p class="mt-3 text-xs font-mono text-on-surface-muted dark:text-on-surface-dark-muted">
                        {{ $textColor['light'] }} <br> {{ $textColor['dark'] }}</p>
                 
                </div>
            @endforeach
        </div>
    </div>

    {{-- Typography Scale --}}
    <div class="mt-16">
        <h2 class="heading-3 mb-6">Typography Scale</h2>

        <div class="space-y-6">
            @foreach (['heading-1', 'heading-2', 'heading-3', 'heading-4', 'heading-5', 'heading-6'] as $heading)
                <div class="rounded-radius border border-outline  px-6 py-4 dark:border-outline-dark  not-prose">
                    <x-badge variant="outline" class="mb-4">{{ $heading }}</x-badge>
                    <p class="{{ $heading }}">The quick brown fox jumps over the lazy dog</p>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Font Families --}}
    <div class="mt-16">
        <h2 class="heading-3 mb-6">Font Families</h2>

        <div class="grid gap-6 lg:grid-cols-3">
            <div class="panel">
                <p class="mb-2 text-xs uppercase tracking-wide text-on-surface-muted dark:text-on-surface-dark-muted">
                    Body Font</p>
                <p class="text-3xl text-on-surface dark:text-on-surface-dark" style="font-family: var(--font-body);">
                    Grumpy wizards make toxic brew
                </p>
                <p class="mt-3 text-xs font-mono text-on-surface-muted dark:text-on-surface-dark-muted">--font-body</p>
            </div>

            <div class="panel">
                <p class="mb-2 text-xs uppercase tracking-wide text-on-surface-muted dark:text-on-surface-dark-muted">
                    Title Font</p>
                <p class="heading-3 text-on-surface dark:text-on-surface-dark" style="font-family: var(--font-title);">
                    Grumpy wizards make toxic brew
                </p>
                <p class="mt-3 text-xs font-mono text-on-surface-muted dark:text-on-surface-dark-muted">--font-title</p>
            </div>

            <div class="panel">
                <p class="mb-2 text-xs uppercase tracking-wide text-on-surface-muted dark:text-on-surface-dark-muted">
                    Mono Font</p>
                <p class="font-mono text-2xl text-on-surface dark:text-on-surface-dark">
                    const code = true;
                </p>
                <p class="mt-3 text-xs font-mono text-on-surface-muted dark:text-on-surface-dark-muted">font-mono</p>
            </div>
        </div>
    </div>
</x-layouts.docs>
