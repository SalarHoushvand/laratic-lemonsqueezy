@php
    $currentSize = request('size', 'md');
@endphp

<x-layouts.guest>
    @push('head')
        <title>{{ config('app.name', 'Laravel') }} - {{ __('Icon Preview') }}</title>
        <meta name="description" content="{{ __('Preview all available icons in different sizes and variants.') }}">
        <style>
            /* Minimal overlay for copy affordance */
            .copy-wrap { position: relative; display: inline-flex; align-items: center; justify-content: center; }
            .copy-overlay {
                position: absolute; inset: 0;
                display: flex; align-items: center; justify-content: center;
                opacity: 0; transition: opacity .15s ease;
                pointer-events: none;
                border-radius: var(--radius, 0.5rem);
            }
            .copy-wrap:hover .copy-overlay { opacity: .95; }
        </style>
    @endpush

    <div class="px-6 py-12">
        <div class="hidden dark:block absolute inset-0 -z-10 bg-pattern pointer-events-none" aria-hidden="true"></div>

        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12">
                <h1 class="heading-2 mb-4 text-on-surface-strong dark:text-on-surface-dark-strong">
                    {{ __('Icon Preview') }}
                </h1>
                <p class="text-sm text-on-surface-muted dark:text-on-surface-dark-muted max-w-2xl mx-auto">
                    {{ __('Explore all available icons in different sizes and variants. Click any icon to copy its Blade tag.') }}
                </p>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-between gap-6 mb-12">
                <div class="w-full sm:w-80">
                    <div class="relative">
                        <x-icons.magnifying-glass class="absolute left-3 top-1/2 transform -translate-y-1/2 text-on-surface/50 dark:text-on-surface-dark/50" size="sm" />
                        <input 
                            type="text" 
                            id="iconSearch" 
                            placeholder="Search icons..." 
                            class="w-full pl-10 pr-4 py-2 bg-surface-alt dark:bg-surface-dark-alt border border-outline dark:border-outline-dark rounded-radius text-on-surface dark:text-on-surface-dark placeholder-on-surface/50 dark:placeholder-on-surface-dark/50 focus:border-primary dark:focus:border-primary-dark focus:ring-0 focus:outline-none"
                        />
                    </div>
                </div>

                <div class="bg-surface-alt dark:bg-surface-dark-alt rounded-radius border border-outline dark:border-outline-dark p-2">
                    <div class="flex space-x-1">
                        <button
                            class="px-4 py-2 text-sm font-medium rounded-radius transition-all duration-200 size-btn {{ $currentSize === 'xs' ? 'bg-primary text-on-primary dark:bg-primary-dark dark:text-on-primary-dark' : 'text-on-surface dark:text-on-surface-dark hover:bg-surface dark:hover:bg-surface-dark-alt' }}"
                            data-size="xs">XS</button>
                        <button
                            class="px-4 py-2 text-sm font-medium rounded-radius transition-all duration-200 size-btn {{ $currentSize === 'sm' ? 'bg-primary text-on-primary dark:bg-primary-dark dark:text-on-primary-dark' : 'text-on-surface dark:text-on-surface-dark hover:bg-surface dark:hover:bg-surface-dark-alt' }}"
                            data-size="sm">SM</button>
                        <button
                            class="px-4 py-2 text-sm font-medium rounded-radius transition-all duration-200 size-btn {{ $currentSize === 'md' ? 'bg-primary text-on-primary dark:bg-primary-dark dark:text-on-primary-dark' : 'text-on-surface dark:text-on-surface-dark hover:bg-surface dark:hover:bg-surface-dark-alt' }}"
                            data-size="md">MD</button>
                        <button
                            class="px-4 py-2 text-sm font-medium rounded-radius transition-all duration-200 size-btn {{ $currentSize === 'lg' ? 'bg-primary text-on-primary dark:bg-primary-dark dark:text-on-primary-dark' : 'text-on-surface dark:text-on-surface-dark hover:bg-surface dark:hover:bg-surface-dark-alt' }}"
                            data-size="lg">LG</button>
                        <button
                            class="px-4 py-2 text-sm font-medium rounded-radius transition-all duration-200 size-btn {{ $currentSize === 'xl' ? 'bg-primary text-on-primary dark:bg-primary-dark dark:text-on-primary-dark' : 'text-on-surface dark:text-on-surface-dark hover:bg-surface dark:hover:bg-surface-dark-alt' }}"
                            data-size="xl">XL</button>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <p class="text-sm text-on-surface dark:text-on-surface-dark" id="resultsCounter">
                    Showing <span id="visibleCount">{{ count($icons ?? []) }}</span> of <span id="totalCount">{{ count($icons ?? []) }}</span> icons
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-6" id="iconGrid">
                @php
                    $iconFiles = glob(resource_path('views/components/icons/*.blade.php'));
                    $icons = [];
                    if ($iconFiles !== false) {
                        foreach ($iconFiles as $file) {
                            $filename = basename($file, '.blade.php');
                            if (!in_array($filename, [
                                'arrow-right-start-on-rectangle',
                                'banknotes',
                                'arrow-top-right-on-square',
                            ])) {
                                $icons[] = $filename;
                            }

                        }
                        sort($icons);
                    }
                @endphp

                @forelse ($icons as $iconName)
                    <div class="group bg-surface dark:bg-surface-dark-alt border border-outline dark:border-outline-dark rounded-radius p-6 text-center hover:shadow-lg transition-all duration-300 hover:border-primary dark:hover:border-primary-dark">
                        <div class="font-medium text-sm mb-4 text-on-surface-strong dark:text-on-surface-dark-strong group-hover:text-primary dark:group-hover:text-primary-dark transition-colors duration-200">
                            {{ $iconName }}
                        </div>

                        @php
                            $componentName = 'icons.' . $iconName;
                            $variants = ['outline','solid','mini','micro'];
                        @endphp

                        <div class="grid grid-cols-2 gap-4 mb-2">
                            @foreach ($variants as $variant)
                                <div class="flex flex-col items-center space-y-2">
                                    <div class="text-xs text-on-surface dark:text-on-surface-dark font-medium capitalize">{{ $variant }}</div>

                                    @if (view()->exists('components.' . $componentName))
                                        @php
                                            $code = '<x-' . $componentName . ' variant="' . $variant . '" size="' . $currentSize . '" />';
                                        @endphp

                                        <!-- Clickable icon that copies its full Blade tag -->
                                        <button
                                            type="button"
                                            class="copy-wrap rounded-radius p-2 bg-transparent border border-transparent hover:border-outline dark:hover:border-outline-dark"
                                            data-code='{{ $code }}'
                                            title="Click to copy"
                                        >
                                            <x-dynamic-component
                                                :component="$componentName"
                                                :variant="$variant"
                                                :size="$currentSize"
                                                class="text-on-surface dark:text-on-surface-dark"
                                            />
                                            <span class="copy-overlay rounded-radius bg-surface/90 dark:bg-surface-dark/90 text-xs px-2 py-1 text-on-surface-strong dark:text-on-surface-dark-strong">
                                                Copy
                                            </span>
                                        </button>
                                    @else
                                        <div class="w-6 h-6 bg-surface-alt dark:bg-surface-dark rounded-radius"></div>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <!-- Tiny helper text -->
                        <div class="text-[11px] text-on-surface/70 dark:text-on-surface-dark/70">
                            Click any icon to copy its Blade tag
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <x-icons.magnifying-glass class="mx-auto mb-4 text-on-surface/50 dark:text-on-surface-dark/50" size="lg" />
                        <h3 class="text-lg font-medium text-on-surface dark:text-on-surface-dark mb-2">No icons found</h3>
                        <p class="text-sm text-on-surface/70 dark:text-on-surface-dark/70">No icon files were found in the components/icons directory</p>
                    </div>
                @endforelse
            </div>

            <div id="noResults" class="hidden text-center py-12">
                <x-icons.magnifying-glass class="mx-auto mb-4 text-on-surface/50 dark:text-on-surface-dark/50" size="lg" />
                <h3 class="text-lg font-medium text-on-surface dark:text-on-surface-dark mb-2">No icons found</h3>
                <p class="text-sm text-on-surface/70 dark:text-on-surface-dark/70">Try adjusting your search terms</p>
            </div>

            <!-- Icon Library Attribution -->
            <div class="mt-16 pt-8 border-t border-outline dark:border-outline-dark">
                <div class="text-center">
                    <p class="text-sm text-on-surface/70 dark:text-on-surface-dark/70 mb-4">
                        Icons provided by:
                    </p>
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-6">
                        <a 
                            href="https://heroicons.com" 
                            target="_blank" 
                            rel="noopener noreferrer"
                            class="flex items-center gap-2 text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 transition-colors duration-200"
                        >
                           
                            <span class="font-medium">Hero Icons</span>
                        </a>
                        <span class="text-on-surface/30 dark:text-on-surface-dark/30">•</span>
                        <a 
                            href="https://icons.getbootstrap.com" 
                            target="_blank" 
                            rel="noopener noreferrer"
                            class="flex items-center gap-2 text-purple-600 dark:text-purple-400 hover:text-purple-700 dark:hover:text-purple-300 transition-colors duration-200"
                        >
                           
                            <span class="font-medium">Bootstrap Icons</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('head')
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sizeButtons = document.querySelectorAll('.size-btn');
            const searchInput = document.getElementById('iconSearch');
            const iconGrid = document.getElementById('iconGrid');
            const noResults = document.getElementById('noResults');
            
            // Get all icon cards after DOM is loaded
            const iconCards = iconGrid.querySelectorAll('.group');

            // Size buttons: reload with ?size=
            sizeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    sizeButtons.forEach(btn => {
                        btn.classList.remove('bg-primary','text-on-primary','dark:bg-primary-dark','dark:text-on-primary-dark');
                        btn.classList.add('text-on-surface','dark:text-on-surface-dark','hover:bg-surface','dark:hover:bg-surface-dark-alt');
                    });
                    this.classList.remove('text-on-surface','dark:text-on-surface-dark','hover:bg-surface','dark:hover:bg-surface-dark-alt');
                    this.classList.add('bg-primary','text-on-primary','dark:bg-primary-dark','dark:text-on-primary-dark');

                    const url = new URL(window.location);
                    url.searchParams.set('size', this.dataset.size);
                    window.location.href = url.toString();
                });
            });

            // Initialize count on page load
            document.getElementById('visibleCount').textContent = iconCards.length;
            document.getElementById('totalCount').textContent = iconCards.length;

            // Search filter
            searchInput.addEventListener('input', function() {
                const term = this.value.toLowerCase();
                let visibleCount = 0;

                iconCards.forEach(card => {
                    const name = card.querySelector('.font-medium').textContent.toLowerCase();
                    const show = name.includes(term);
                    card.style.display = show ? 'block' : 'none';
                    if (show) {
                        card.style.animation = 'fadeIn 0.3s ease-in-out';
                        visibleCount++;
                    }
                });

                document.getElementById('visibleCount').textContent = visibleCount;
                if (term.length > 0 && visibleCount === 0) {
                    noResults.classList.remove('hidden');
                } else {
                    noResults.classList.add('hidden');
                }
            });

            // Delegated click-to-copy for any element with data-code
            document.addEventListener('click', function(e) {
                const btn = e.target.closest('[data-code]');
                if (!btn) return;

                const code = btn.getAttribute('data-code');
                copyText(code).then(() => flashCopied(btn));
            });

            function copyText(text) {
                if (navigator.clipboard && window.isSecureContext) {
                    return navigator.clipboard.writeText(text);
                } else {
                    // Fallback
                    const ta = document.createElement('textarea');
                    ta.value = text;
                    ta.style.position = 'fixed';
                    ta.style.opacity = '0';
                    document.body.appendChild(ta);
                    ta.select();
                    try { document.execCommand('copy'); } catch (e) {}
                    document.body.removeChild(ta);
                    return Promise.resolve();
                }
            }

            function flashCopied(btn) {
                // Brief "Copied!" flash in the overlay
                const overlay = btn.querySelector('.copy-overlay');
                if (!overlay) return;
                const original = overlay.textContent;
                overlay.textContent = 'Copied!';
                overlay.style.opacity = '1';
                setTimeout(() => {
                    overlay.textContent = original;
                    overlay.style.opacity = '';
                }, 900);
            }
        });
    </script>
    @endpush
</x-layouts.guest>

