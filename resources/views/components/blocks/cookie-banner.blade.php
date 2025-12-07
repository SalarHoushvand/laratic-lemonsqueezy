{{-- TODO: Replace with your own Google Analytics ID --}}
@props(['gaId' => env('GOOGLE_ANALYTICS_ID')])

{{-- Cookie Banner --}}
<div id="cookie-banner" x-data="cookieConsent()" x-cloak x-show="show" role="region" aria-live="polite"
    aria-describedby="cookie-banner-description"
    class="fixed bottom-0 inset-x-0 z-50 bg-surface-alt/70 backdrop-blur-md text-xs text-pretty md:text-sm dark:bg-surface-dark-alt text-on-surface dark:text-on-surface-dark px-4 py-2 border-t border-outline dark:border-outline-dark flex flex-col items-end md:flex-row md:items-center md:justify-between gap-2.5">
    <span id="cookie-banner-description">
        {{ __('We use cookies to improve your experience and collect anonymous analytics.') }}
        {{ __('You can accept or decline non-essential cookies.') }}
        @if (Route::has('privacy'))
            <a href="{{ route('privacy') }}" class="link" target="_blank"
                rel="noopener noreferrer">{{ __('Privacy Policy') }}</a>
        @endif
    </span>
    <div class="gap-2 flex-shrink-0 flex flex-col md:flex-row items-stretch md:items-center pb-2 md:pb-0">
        <x-button size="sm" variant="outline" x-on:click="decline()" :aria-label="__('Decline cookies')">
            {{ __('Decline') }}
        </x-button>
        <x-button size="sm" variant="primary" x-on:click="accept()" :aria-label="__('Accept cookies')">
            {{ __('Accept') }}
        </x-button>
    </div>
</div>

@push('scripts')
    <script>
        function cookieConsent() {
            const COOKIE_NAME = 'cookie_consent';
            const isSecure = window.location.protocol === 'https:';

            return {
                show: false,
                gaId: @json($gaId),
                init() {
                    const consent = this.getCookie(COOKIE_NAME);
                    if (consent === 'yes') {
                        this.enableScripts();
                    } else if (consent === 'no') {
                        // explicitly declined, keep banner hidden
                    } else {
                        // no record -> show banner
                        this.show = true;
                    }
                },
                accept() {
                    this.setCookie(COOKIE_NAME, 'yes', 365);
                    this.enableScripts();
                    this.show = false;
                },
                decline() {
                    this.setCookie(COOKIE_NAME, 'no', 365);
                    this.show = false;
                },
                enableScripts() {
                    this.loadAnalytics();
                    this.loadMoreScripts(); //load more scripts here
                },
                loadAnalytics() {
                    if (document.getElementById('ga-script')) return;
                    if (!this.gaId || this.gaId === 'G-XXXXXXXXXX') return;

                    // Validate GA ID format (should start with G-)
                    if (!this.gaId.startsWith('G-')) {
                        console.warn('Invalid Google Analytics ID format');
                        return;
                    }

                    try {
                        const g = document.createElement('script');
                        g.id = 'ga-script';
                        g.async = true;
                        g.src = 'https://www.googletagmanager.com/gtag/js?id=' + encodeURIComponent(this.gaId);
                        g.onerror = () => console.warn('Failed to load Google Analytics script');
                        document.head.appendChild(g);

                        window.dataLayer = window.dataLayer || [];

                        function gtag(...args) {
                            dataLayer.push(args);
                        }
                        window.gtag = gtag;
                        gtag('js', new Date());
                        gtag('config', this.gaId);
                    } catch (error) {
                        console.error('Error loading Google Analytics:', error);
                    }
                },
                loadMoreScripts() {
                    //add more scripts here
                },
                // Cookie helpers
                setCookie(name, value, days) {
                    let expires = '';
                    if (days) {
                        const d = new Date();
                        d.setTime(d.getTime() + days * 24 * 60 * 60 * 1000);
                        expires = '; expires=' + d.toUTCString();
                    }
                    const secureFlag = isSecure ? '; Secure' : '';
                    document.cookie = name + '=' + encodeURIComponent(value || '') + expires + '; path=/; SameSite=Lax' +
                        secureFlag;
                },
                getCookie(name) {
                    const nameEQ = name + '=';
                    const parts = document.cookie.split(';');
                    for (let part of parts) {
                        part = part.trim();
                        if (part.startsWith(nameEQ)) {
                            const value = part.substring(nameEQ.length);
                            return value === '' ? null : decodeURIComponent(value);
                        }
                    }
                    return null;
                }
            }
        }
    </script>
@endpush
