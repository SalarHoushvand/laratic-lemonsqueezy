<div class="relative" x-data="{
    query: '',
    focusedIndex: -1,
    get results() {
        if (!this.query.trim()) {
            return [];
        }
        const searchTerm = this.query.toLowerCase();
        const matches = [];
        for (const [key, item] of Object.entries(window.searchIndex || {})) {
            if (key.toLowerCase().includes(searchTerm) || (item.title && item.title.toLowerCase().includes(searchTerm))) {
                matches.push({ key, ...item });
            }
        }
        return matches.slice(0, 8);
    },
    get hasResults() {
        return this.results.length > 0;
    },
    get showResults() {
        return this.query.trim().length > 0;
    },
    navigateResults(direction) {
        if (this.results.length === 0) return;

        if (direction === 'down') {
            this.focusedIndex = this.focusedIndex < this.results.length - 1 ? this.focusedIndex + 1 : 0;
        } else {
            this.focusedIndex = this.focusedIndex > 0 ? this.focusedIndex - 1 : this.results.length - 1;
        }
    },
    selectResult() {
        if (this.focusedIndex >= 0 && this.results[this.focusedIndex]) {
            window.location.href = this.results[this.focusedIndex].url;
        }
    },
    reset() {
        this.query = '';
        this.focusedIndex = -1;
    }
}" x-on:click.away="reset()">
    <x-input type="search" variant="search" placeholder="{{ __('Search Docs...') }}" class="w-full " x-model="query"
        x-on:keydown.down.prevent="navigateResults('down')" x-on:keydown.up.prevent="navigateResults('up')"
        x-on:keydown.enter.prevent="selectResult()" x-on:keydown.escape="reset()" />
      
    <div x-cloak x-show="showResults" x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-1"
        class="absolute top-9 left-0 mt-2 right-0 w-full border border-outline dark:border-outline-dark rounded-radius bg-surface-alt dark:bg-surface-dark-alt z-50 max-h-76 overflow-y-auto">
        <template x-if="hasResults">
            <ul class="py-1">
                <template x-for="(result, index) in results" x-bind:key="result.key">
                    <li>
                        <a x-bind:href="result.url" class="block px-4 py-2.5 text-sm"
                            x-bind:class="index === focusedIndex ?
                                'bg-primary/15 dark:bg-primary-dark/15 text-on-surface-strong dark:text-on-surface-dark-strong' :
                                'text-on-surface dark:text-on-surface-dark hover:bg-surface-alt dark:hover:bg-surface-dark-alt'"
                            x-on:mouseenter="focusedIndex = index">
                            <span class="font-medium" x-text="result.title || result.key"></span>
                        </a>
                    </li>
                </template>
            </ul>
        </template>

        <template x-if="!hasResults && showResults">
            <div class="p-4">
                <x-blocks.empty-state title="No topics found" description="Try searching with different keywords"
                    icon="magnifying-glass" />

            </div>
        </template>
    </div>
</div>

@push('scripts')
    <script>
        // Dynamically build search index from sidebar links
        (function() {
            const searchIndex = {};

            // Find the sidebar navigation
            const sidebar = document.querySelector('nav[aria-label="sidebar navigation"]');
            if (!sidebar) return;

            // Get all links within the sidebar (excluding external links and section headers)
            const links = sidebar.querySelectorAll('a[href*="/docs/"]');

            links.forEach(link => {
                const href = link.getAttribute('href');
                const text = link.querySelector('span')?.textContent.trim() || link.textContent.trim();

                // Skip empty text or duplicates
                if (!text || searchIndex[text]) return;

                // Add to search index
                searchIndex[text] = {
                    title: text,
                    url: href
                };
            });

            // Make it globally available
            window.searchIndex = searchIndex;
        })();
    </script>
@endpush
