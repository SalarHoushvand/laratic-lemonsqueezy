<script>
    (function() {
        const ThemeManager = {
            THEMES: {
                DARK: 'dark',
                LIGHT: 'light',
                SYSTEM: 'system'
            },

            init() {
                try {
                    this.theme = localStorage.theme || this.THEMES.SYSTEM;
                } catch (e) {
                    this.theme = this.THEMES.SYSTEM;
                }
                
                this.darkModeMediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
                this.applyTheme();
                this.setupListeners();
            },

            applyTheme() {
                if (this.theme === this.THEMES.DARK) {
                    this.enableDarkMode();
                } else if (this.theme === this.THEMES.LIGHT) {
                    this.disableDarkMode();
                } else {
                    // System theme
                    this.darkModeMediaQuery.matches ? this.enableDarkMode() : this.disableDarkMode();
                }
            },

            enableDarkMode() {
                document.documentElement.classList.add(this.THEMES.DARK);
            },

            disableDarkMode() {
                document.documentElement.classList.remove(this.THEMES.DARK);
            },

            setupListeners() {
                this.darkModeMediaQuery.addEventListener('change', e => {
                    if (this.theme === this.THEMES.SYSTEM) {
                        this.applyTheme();
                    }
                });
            }
        };

        ThemeManager.init();
    })();
</script>
