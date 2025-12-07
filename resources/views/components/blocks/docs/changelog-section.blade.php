@props([
    'title',
    'version' => null,
    'github' => null,
    'new' => null,
    'changed' => null,
    'fixed' => null,
])

<article class="relative">
    <div class="flex items-baseline gap-4 mb-2">
        <h2>
            {{ $title }}
        </h2>
        @if ($github)
            <a href="{{ $github }}">
                <x-badge class="font-mono" size="xs">
                    <x-icons.github variant="micro" size="sm" />
                    @if ($version)
                        v{{ $version }}
                    @endif
                </x-badge>
            </a>
        @elseif ($version)
            <p class="text-on-surface-muted dark:text-on-surface-dark-muted font-mono">v{{ $version }}</p>
        @endif
    </div>

    <div class="space-y-4 pl-6 border-l-2 border-outline dark:border-outline-dark">
        @if ($new?->isNotEmpty())
            <div>
                <div class="flex items-center gap-2 mb-3">
                    <h3><x-badge variant="outline-info" size="sm">New</x-badge></h3>
                </div>
                <div class="space-y-1.5 text-sm">
                    {{ $new }}
                </div>
            </div>
        @endif

        @if ($changed?->isNotEmpty())
            <div>
                <div class="flex items-center gap-2 mb-3">
                    <h3><x-badge variant="outline-warning" size="sm">Changed</x-badge></h3>
                </div>
                <div class="space-y-1.5 text-sm">
                    {{ $changed }}
                </div>
            </div>
        @endif

        @if ($fixed?->isNotEmpty())
            <div>
                <div class="flex items-center gap-2 mb-3">
                    <h3><x-badge variant="outline-success" size="sm">Fixed</x-badge></h3>
                </div>
                <div class="space-y-1.5 text-sm">
                    {{ $fixed }}
                </div>
            </div>
        @endif
    </div>
</article>

