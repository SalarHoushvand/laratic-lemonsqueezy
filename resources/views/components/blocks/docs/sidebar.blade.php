@props(['breadcrumbs' => null])

<div x-data="{ sidebarIsOpen: false, showSearch: false }" class="relative flex w-full flex-col md:flex-row">

    {{-- Screen reader skip link --}}
    <a class="sr-only" href="#main-content">{{ __('Skip to main content') }}</a>

    {{-- Mobile sidebar overlay --}}
    <div x-cloak x-show="sidebarIsOpen" x-on:click="sidebarIsOpen = false" x-transition.opacity
        class="fixed inset-0 z-20 bg-surface-dark/10 backdrop-blur-xs md:hidden" aria-hidden="true"></div>

    {{-- Sidebar --}}
    <nav x-cloak x-bind:class="sidebarIsOpen ? 'translate-x-0' : '-translate-x-60'"
        class="fixed left-0 top-0 z-30 flex h-svh w-60 shrink-0 flex-col border-r border-outline bg-surface p-4 transition-transform duration-300 md:relative md:h-full md:w-64 md:translate-x-0 dark:border-outline-dark dark:bg-surface-dark"
        aria-label="sidebar navigation">
        {{-- Logo --}}
        <a href="{{ route('home') }}" class="mb-4 flex items-center space-x-2 lg:ml-0">
            <x-app-logo class="w-20" />
            <x-badge variant="primary">{{ __('Docs') }}</x-badge>
        </a>

        <div class="mt-4 pb-2">
            {{-- You can add quick actions here --}}
            <x-blocks.docs.search />

        </div>
        {{-- Sidebar links --}}
        <div x-data="{
            scrollToActive() {
                this.$nextTick(() => {
                    const activeLink = this.$el.querySelector('.sidebar-link-active');
                    if (activeLink) {
                        const container = this.$el;
                        const linkRect = activeLink.getBoundingClientRect();
                        const containerRect = container.getBoundingClientRect();
                        const scrollTop = container.scrollTop;
                        const linkTop = scrollTop + linkRect.top - containerRect.top;
                        container.scrollTo({
                            top: linkTop - containerRect.height / 2 + linkRect.height / 2,
                            behavior: 'smooth'
                        });
                    }
                });
            }
        }" x-init="scrollToActive()"
            class="flex flex-col gap-2 overflow-y-auto pb-6 relative pt-6">

            <x-blocks.docs.sidebar-link href="{{ route('docs.show', ['topic' => 'introduction']) }}" :active="request()->routeIs('docs.show') && request()->route('topic') === 'introduction'">
                <x-icons.book-open variant="micro" size="sm"
                    class="text-on-surface-muted dark:text-on-surface-dark-muted" />
                <span>{{ __('Introduction') }}</span>
            </x-blocks.docs.sidebar-link>

            <x-blocks.docs.sidebar-link href="{{ route('docs.show', ['topic' => 'installation']) }}" :active="request()->routeIs('docs.show') && request()->route('topic') === 'installation'">
                <x-icons.wrench-screwdriver variant="micro" size="sm"
                    class="text-on-surface-muted dark:text-on-surface-dark-muted" />
                <span>{{ __('Installation') }}</span>
            </x-blocks.docs.sidebar-link>



            <x-blocks.docs.sidebar-link href="{{ route('docs.show', ['topic' => 'changelog']) }}" :active="request()->routeIs('docs.show') && request()->route('topic') === 'changelog'">
                <x-icons.clock variant="micro" size="sm"
                    class="text-on-surface-muted dark:text-on-surface-dark-muted" />
                <span>{{ __('Changelog') }}</span>
            </x-blocks.docs.sidebar-link>

            <x-blocks.docs.sidebar-link href="{{ route('docs.show', ['topic' => 'design-system']) }}" :active="request()->routeIs('docs.show') && request()->route('topic') === 'design-system'">
                <x-icons.swatch variant="micro" size="sm"
                    class="text-on-surface-muted dark:text-on-surface-dark-muted" />
                <span>{{ __('Design System') }}</span>
            </x-blocks.docs.sidebar-link>

            <x-blocks.docs.sidebar-link href="{{ route('docs.show', ['topic' => 'themes']) }}" :active="request()->routeIs('docs.show') && request()->route('topic') === 'themes'">
                <x-icons.paint-brush variant="micro" size="sm"
                    class="text-on-surface-muted dark:text-on-surface-dark-muted" />
                <span>{{ __('Themes') }}</span>
            </x-blocks.docs.sidebar-link>

            {{-- Authentication Section --}}
            <x-blocks.docs.sidebar-topic title="Authentication" />
            <ul class="pl-4">
                <li class="border-l border-outline px-2 py-0.5 dark:border-outline-dark">
                    <x-blocks.docs.sidebar-link
                        href="{{ route('docs.show', ['topic' => 'two-factor-authentication']) }}" :active="request()->routeIs('docs.show') && request()->route('topic') === 'two-factor-authentication'">
                        <span>{{ __('Two-Factor Authentication') }}</span>
                    </x-blocks.docs.sidebar-link>
                </li>
                <li class="border-l border-outline px-2 py-0.5 dark:border-outline-dark">
                    <x-blocks.docs.sidebar-link href="{{ route('docs.show', ['topic' => 'auth/social-login/index']) }}"
                        :active="request()->routeIs('docs.show') && (request()->route('topic') === 'auth/social-login/index' || request()->route('topic') === 'auth/social-login')">
                        <span>{{ __('Social Login') }}</span>
                    </x-blocks.docs.sidebar-link>
                </li>
                <li class="border-l border-outline px-2 py-0.5 dark:border-outline-dark">
                    <x-blocks.docs.sidebar-link
                        href="{{ route('docs.show', ['topic' => 'auth/social-login/google']) }}" :active="request()->routeIs('docs.show') && request()->route('topic') === 'auth/social-login/google'">
                        <span>{{ __('Google Setup') }}</span>
                    </x-blocks.docs.sidebar-link>
                </li>
                <li class="border-l border-outline px-2 py-0.5 dark:border-outline-dark">
                    <x-blocks.docs.sidebar-link
                        href="{{ route('docs.show', ['topic' => 'auth/social-login/github']) }}" :active="request()->routeIs('docs.show') && request()->route('topic') === 'auth/social-login/github'">
                        <span>{{ __('GitHub Setup') }}</span>
                    </x-blocks.docs.sidebar-link>
                </li>
            </ul>

            {{-- AI Integration Section --}}
            <x-blocks.docs.sidebar-topic title="AI Integration" />
            <ul class="pl-4">
                <li class="border-l border-outline px-2 py-0.5 dark:border-outline-dark">
                    <x-blocks.docs.sidebar-link href="{{ route('docs.show', ['topic' => 'ai/index']) }}"
                        :active="request()->routeIs('docs.show') && request()->route('topic') === 'ai/index'">
                        <span>{{ __('Overview') }}</span>
                    </x-blocks.docs.sidebar-link>
                </li>
                <li class="border-l border-outline px-2 py-0.5 dark:border-outline-dark">
                    <x-blocks.docs.sidebar-link href="{{ route('docs.show', ['topic' => 'ai/simple']) }}"
                        :active="request()->routeIs('docs.show') && request()->route('topic') === 'ai/simple'">
                        <span>{{ __('Simple AI Integration') }}</span>
                    </x-blocks.docs.sidebar-link>
                </li>
                <li class="border-l border-outline px-2 py-0.5 dark:border-outline-dark">
                    <x-blocks.docs.sidebar-link href="{{ route('docs.show', ['topic' => 'ai/chat']) }}"
                        :active="request()->routeIs('docs.show') && request()->route('topic') === 'ai/chat'">
                        <span>{{ __('Chat with streaming') }}</span>
                    </x-blocks.docs.sidebar-link>
                </li>
                <li class="border-l border-outline px-2 py-0.5 dark:border-outline-dark">
                    <x-blocks.docs.sidebar-link href="{{ route('docs.show', ['topic' => 'ai/usage']) }}"
                        :active="request()->routeIs('docs.show') && request()->route('topic') === 'ai/usage'">
                        <span>{{ __('AI Usage') }}</span>
                    </x-blocks.docs.sidebar-link>
                </li>
            </ul>

            {{-- Billing & Paddle Section --}}
            <x-blocks.docs.sidebar-topic title="Billing & Payments" />
            <ul class="pl-4">
                <li class="border-l border-outline px-2 py-0.5 dark:border-outline-dark">
                    <x-blocks.docs.sidebar-link href="{{ route('docs.show', ['topic' => 'paddle-setup']) }}"
                        :active="request()->routeIs('docs.show') && request()->route('topic') === 'paddle-setup'">
                        <span>{{ __('Paddle Setup') }}</span>
                    </x-blocks.docs.sidebar-link>
                </li>
                <li class="border-l border-outline px-2 py-0.5 dark:border-outline-dark">
                    <x-blocks.docs.sidebar-link href="{{ route('docs.show', ['topic' => 'paddle-subscriptions']) }}"
                        :active="request()->routeIs('docs.show') && request()->route('topic') === 'paddle-subscriptions'">
                        <span>{{ __('Subscription Plans') }}</span>
                    </x-blocks.docs.sidebar-link>
                </li>
                <li class="border-l border-outline px-2 py-0.5 dark:border-outline-dark">
                    <x-blocks.docs.sidebar-link href="{{ route('docs.show', ['topic' => 'paddle-products']) }}"
                        :active="request()->routeIs('docs.show') && request()->route('topic') === 'paddle-products'">
                        <span>{{ __('One-Time Products') }}</span>
                    </x-blocks.docs.sidebar-link>
                </li>
                <li class="border-l border-outline px-2 py-0.5 dark:border-outline-dark">
                    <x-blocks.docs.sidebar-link href="{{ route('docs.show', ['topic' => 'paddle-orders']) }}"
                        :active="request()->routeIs('docs.show') && request()->route('topic') === 'paddle-orders'">
                        <span>{{ __('Orders & Transactions') }}</span>
                    </x-blocks.docs.sidebar-link>
                </li>
                <li class="border-l border-outline px-2 py-0.5 dark:border-outline-dark">
                    <x-blocks.docs.sidebar-link href="{{ route('docs.show', ['topic' => 'paddle-webhooks']) }}"
                        :active="request()->routeIs('docs.show') && request()->route('topic') === 'paddle-webhooks'">
                        <span>{{ __('Webhooks & Testing') }}</span>
                    </x-blocks.docs.sidebar-link>
                </li>
            </ul>

            <x-blocks.docs.sidebar-link href="{{ route('docs.show', ['topic' => 'newsletter']) }}" :active="request()->routeIs('docs.show') && request()->route('topic') === 'newsletter'">
                <span>{{ __('Newsletter') }}</span>
            </x-blocks.docs.sidebar-link>

            <x-blocks.docs.sidebar-link href="{{ route('docs.show', ['topic' => 'email-notifications']) }}"
                :active="request()->routeIs('docs.show') && request()->route('topic') === 'email-notifications'">
                <span>{{ __('Email Notifications') }}</span>
            </x-blocks.docs.sidebar-link>

            <x-blocks.docs.sidebar-link href="{{ route('docs.show', ['topic' => 'sending-text-messages']) }}"
                :active="request()->routeIs('docs.show') && request()->route('topic') === 'sending-text-messages'">
                <span>{{ __('Sending Text Messages') }}</span>
            </x-blocks.docs.sidebar-link>

            <x-blocks.docs.sidebar-link href="{{ route('docs.show', ['topic' => 'admin/file-upload']) }}"
                :active="request()->routeIs('docs.show') && request()->route('topic') === 'admin/file-upload'">
                <span>{{ __('Cloudinary File Uploads') }}</span>
            </x-blocks.docs.sidebar-link>

            <x-blocks.docs.sidebar-link href="{{ route('docs.show', ['topic' => 'admin/database-seeders']) }}"
                :active="request()->routeIs('docs.show') && request()->route('topic') === 'admin/database-seeders'">
                <span>{{ __('Database Seeders') }}</span>
            </x-blocks.docs.sidebar-link>

            <x-blocks.docs.sidebar-link href="{{ route('docs.show', ['topic' => 'cookie-consent']) }}"
                :active="request()->routeIs('docs.show') && request()->route('topic') === 'cookie-consent'">
                <span>{{ __('Cookie Consent Banner') }}</span>
            </x-blocks.docs.sidebar-link>

            <x-blocks.docs.sidebar-link href="{{ route('docs.show', ['topic' => 'sitemap']) }}" :active="request()->routeIs('docs.show') && request()->route('topic') === 'sitemap'">
                <span>{{ __('Sitemap') }}</span>
            </x-blocks.docs.sidebar-link>

            <x-blocks.docs.sidebar-link href="{{ route('docs.show', ['topic' => 'translation-extractor']) }}"
                :active="request()->routeIs('docs.show') && request()->route('topic') === 'translation-extractor'">
                <span>{{ __('Translation Extractor') }}</span>
            </x-blocks.docs.sidebar-link>

            <x-blocks.docs.sidebar-link href="{{ route('docs.show', ['topic' => 'typography']) }}" :active="request()->routeIs('docs.show') && request()->route('topic') === 'typography'">
                <span>{{ __('Typography') }}</span>
            </x-blocks.docs.sidebar-link>

            <x-blocks.docs.sidebar-link href="{{ route('docs.show', ['topic' => 'tests']) }}" :active="request()->routeIs('docs.show') && request()->route('topic') === 'tests'">
                <span>{{ __('Tests') }}</span>
            </x-blocks.docs.sidebar-link>

            {{-- Blog Section --}}
            <x-blocks.docs.sidebar-topic title="Blog" />
            <ul class="pl-4">
                <li class="border-l border-outline px-2 py-0.5 dark:border-outline-dark">
                    <x-blocks.docs.sidebar-link href="{{ route('docs.show', ['topic' => 'blog/index']) }}"
                        :active="request()->routeIs('docs.show') && request()->route('topic') === 'blog/index'">
                        <span>{{ __('Overview') }}</span>
                    </x-blocks.docs.sidebar-link>
                </li>
                <li class="border-l border-outline px-2 py-0.5 dark:border-outline-dark">
                    <x-blocks.docs.sidebar-link href="{{ route('docs.show', ['topic' => 'blog/posts']) }}"
                        :active="request()->routeIs('docs.show') && request()->route('topic') === 'blog/posts'">
                        <span>{{ __('Post Management') }}</span>
                    </x-blocks.docs.sidebar-link>
                </li>
                <li class="border-l border-outline px-2 py-0.5 dark:border-outline-dark">
                    <x-blocks.docs.sidebar-link href="{{ route('docs.show', ['topic' => 'blog/ai-generation']) }}"
                        :active="request()->routeIs('docs.show') && request()->route('topic') === 'blog/ai-generation'">
                        <span>{{ __('AI Content Generation') }}</span>
                    </x-blocks.docs.sidebar-link>
                </li>
                <li class="border-l border-outline px-2 py-0.5 dark:border-outline-dark">
                    <x-blocks.docs.sidebar-link href="{{ route('docs.show', ['topic' => 'blog/translations']) }}"
                        :active="request()->routeIs('docs.show') && request()->route('topic') === 'blog/translations'">
                        <span>{{ __('Translations') }}</span>
                    </x-blocks.docs.sidebar-link>
                </li>
                <li class="border-l border-outline px-2 py-0.5 dark:border-outline-dark">
                    <x-blocks.docs.sidebar-link href="{{ route('docs.show', ['topic' => 'blog/categories']) }}"
                        :active="request()->routeIs('docs.show') && request()->route('topic') === 'blog/categories'">
                        <span>{{ __('Categories') }}</span>
                    </x-blocks.docs.sidebar-link>
                </li>
                <li class="border-l border-outline px-2 py-0.5 dark:border-outline-dark">
                    <x-blocks.docs.sidebar-link href="{{ route('docs.show', ['topic' => 'blog/seo']) }}"
                        :active="request()->routeIs('docs.show') && request()->route('topic') === 'blog/seo'">
                        <span>{{ __('SEO') }}</span>
                    </x-blocks.docs.sidebar-link>
                </li>
                <li class="border-l border-outline px-2 py-0.5 dark:border-outline-dark">
                    <x-blocks.docs.sidebar-link href="{{ route('docs.show', ['topic' => 'blog/faq']) }}"
                        :active="request()->routeIs('docs.show') && request()->route('topic') === 'blog/faq'">
                        <span>{{ __('FAQ') }}</span>
                    </x-blocks.docs.sidebar-link>
                </li>
            </ul>

            {{-- Managing Users Section --}}
            <x-blocks.docs.sidebar-topic title="Managing Users" />
            <ul class="pl-4">
                <li class="border-l border-outline px-2 py-0.5 dark:border-outline-dark">
                    <x-blocks.docs.sidebar-link href="{{ route('docs.show', ['topic' => 'manage-users/index']) }}"
                        :active="request()->routeIs('docs.show') && request()->route('topic') === 'manage-users/index'">
                        <span>{{ __('Manage Users') }}</span>
                    </x-blocks.docs.sidebar-link>
                </li>
                <li class="border-l border-outline px-2 py-0.5 dark:border-outline-dark">
                    <x-blocks.docs.sidebar-link
                        href="{{ route('docs.show', ['topic' => 'manage-users/roles-and-permissions']) }}"
                        :active="request()->routeIs('docs.show') && request()->route('topic') === 'manage-users/roles-and-permissions'">
                        <span>{{ __('Roles and Permissions') }}</span>
                    </x-blocks.docs.sidebar-link>
                </li>
            </ul>

            {{-- Extra Pages Section --}}
            <x-blocks.docs.sidebar-topic title="Extra Pages" />
            <ul class="pl-4">
                <li class="border-l border-outline px-2 py-0.5 dark:border-outline-dark">
                    <x-blocks.docs.sidebar-link
                        href="{{ route('docs.show', ['topic' => 'extra-pages/custom-error-pages']) }}"
                        :active="request()->routeIs('docs.show') && request()->route('topic') === 'extra-pages/custom-error-pages'">
                        <span>{{ __('Custom Error Pages') }}</span>
                    </x-blocks.docs.sidebar-link>
                </li>

                <li class="border-l border-outline px-2 py-0.5 dark:border-outline-dark">
                    <x-blocks.docs.sidebar-link
                        href="{{ route('docs.show', ['topic' => 'extra-pages/pre-launch-waitlist']) }}"
                        :active="request()->routeIs('docs.show') && request()->route('topic') === 'extra-pages/pre-launch-waitlist'">
                        <span>{{ __('Pre-launch Waitlist') }}</span>
                    </x-blocks.docs.sidebar-link>
                </li>

                <li
                    class="px-2 pt-4 text-xs font-semibold uppercase tracking-wide text-on-surface-muted dark:text-on-surface-dark-muted">
                    {{ __('Design') }}
                </li>
                <li class="border-l border-outline px-2 py-0.5 dark:border-outline-dark">
                    <x-blocks.docs.sidebar-link
                        href="{{ route('docs.show', ['topic' => 'extra-pages/design/icons-preview']) }}"
                        :active="request()->routeIs('docs.show') && request()->route('topic') === 'extra-pages/design/icons-preview'">
                        <span>{{ __('Icons Preview') }}</span>
                    </x-blocks.docs.sidebar-link>
                </li>


                <li
                    class="px-2 pt-4 text-xs font-semibold uppercase tracking-wide text-on-surface-muted dark:text-on-surface-dark-muted">
                    {{ __('Company') }}
                </li>
                <li class="border-l border-outline px-2 py-0.5 dark:border-outline-dark">
                    <x-blocks.docs.sidebar-link
                        href="{{ route('docs.show', ['topic' => 'extra-pages/company/careers']) }}"
                        :active="request()->routeIs('docs.show') && request()->route('topic') === 'extra-pages/company/careers'">
                        <span>{{ __('Careers') }}</span>
                    </x-blocks.docs.sidebar-link>
                </li>
                <li class="border-l border-outline px-2 py-0.5 dark:border-outline-dark">
                    <x-blocks.docs.sidebar-link
                        href="{{ route('docs.show', ['topic' => 'extra-pages/company/about-us']) }}"
                        :active="request()->routeIs('docs.show') && request()->route('topic') === 'extra-pages/company/about-us'">
                        <span>{{ __('About Us') }}</span>
                    </x-blocks.docs.sidebar-link>
                </li>
                <li class="border-l border-outline px-2 py-0.5 dark:border-outline-dark">
                    <x-blocks.docs.sidebar-link
                        href="{{ route('docs.show', ['topic' => 'extra-pages/company/contact-forms']) }}"
                        :active="request()->routeIs('docs.show') && request()->route('topic') === 'extra-pages/company/contact-forms'">
                        <span>{{ __('Contact Forms') }}</span>
                    </x-blocks.docs.sidebar-link>
                </li>

                <li
                    class="px-2 pt-4 text-xs font-semibold uppercase tracking-wide text-on-surface-muted dark:text-on-surface-dark-muted">
                    {{ __('Legal') }}
                </li>
                <li class="border-l border-outline px-2 py-0.5 dark:border-outline-dark">
                    <x-blocks.docs.sidebar-link
                        href="{{ route('docs.show', ['topic' => 'extra-pages/legal/privacy-terms']) }}"
                        :active="request()->routeIs('docs.show') && request()->route('topic') === 'extra-pages/legal/privacy-terms'">
                        <span>{{ __('Privacy & Terms') }}</span>
                    </x-blocks.docs.sidebar-link>
                </li>
            </ul>

            {{-- Documentation Section --}}
            <x-blocks.docs.sidebar-topic title="Documentation" />
            <ul class="pl-4">
                <li class="border-l border-outline px-2 py-0.5 dark:border-outline-dark">
                    <x-blocks.docs.sidebar-link
                        href="{{ route('docs.show', ['topic' => 'documentation/changelog']) }}" :active="request()->routeIs('docs.show') && request()->route('topic') === 'documentation/changelog'">

                        <span>{{ __('Changelog') }}</span>
                    </x-blocks.docs.sidebar-link>
                </li>
                <li class="border-l border-outline px-2 py-0.5 dark:border-outline-dark">
                    <x-blocks.docs.sidebar-link href="{{ route('docs.show', ['topic' => 'documentation/search']) }}"
                        :active="request()->routeIs('docs.show') && request()->route('topic') === 'documentation/search'">

                        <span>{{ __('Search') }}</span>
                    </x-blocks.docs.sidebar-link>
                </li>
                <li class="border-l border-outline px-2 py-0.5 dark:border-outline-dark">
                    <x-blocks.docs.sidebar-link
                        href="{{ route('docs.show', ['topic' => 'documentation/layout-and-breadcrumbs']) }}"
                        :active="request()->routeIs('docs.show') && request()->route('topic') === 'documentation/layout-and-breadcrumbs'">

                        <span>{{ __('Layout & Breadcrumbs') }}</span>
                    </x-blocks.docs.sidebar-link>
                </li>
                <li class="border-l border-outline px-2 py-0.5 dark:border-outline-dark">
                    <x-blocks.docs.sidebar-link
                        href="{{ route('docs.show', ['topic' => 'documentation/translations']) }}"
                        :active="request()->routeIs('docs.show') && request()->route('topic') === 'documentation/translations'">

                        <span>{{ __('Doc Translations') }}</span>
                    </x-blocks.docs.sidebar-link>
                </li>
            </ul>

            {{-- UI Components Section --}}
            <x-blocks.docs.sidebar-topic title="UI Components" />
            <ul class="pl-4">
                <li class="border-l border-outline px-2 py-0.5 dark:border-outline-dark">
                    <x-blocks.docs.sidebar-link
                        href="{{ route('docs.show', ['topic' => 'ui-components/accordion']) }}" :active="request()->routeIs('docs.show') && request()->route('topic') === 'ui-components/accordion'">
                        <span>{{ __('Accordion') }}</span>
                    </x-blocks.docs.sidebar-link>
                </li>
                <li class="border-l border-outline px-2 py-0.5 dark:border-outline-dark">
                    <x-blocks.docs.sidebar-link href="{{ route('docs.show', ['topic' => 'ui-components/alert']) }}"
                        :active="request()->routeIs('docs.show') && request()->route('topic') === 'ui-components/alert'">
                        <span>{{ __('Alert') }}</span>
                    </x-blocks.docs.sidebar-link>
                </li>
                <li class="border-l border-outline px-2 py-0.5 dark:border-outline-dark">
                    <x-blocks.docs.sidebar-link href="{{ route('docs.show', ['topic' => 'ui-components/avatar']) }}"
                        :active="request()->routeIs('docs.show') && request()->route('topic') === 'ui-components/avatar'">
                        <span>{{ __('Avatar') }}</span>
                    </x-blocks.docs.sidebar-link>
                </li>
                <li class="border-l border-outline px-2 py-0.5 dark:border-outline-dark">
                    <x-blocks.docs.sidebar-link href="{{ route('docs.show', ['topic' => 'ui-components/badge']) }}"
                        :active="request()->routeIs('docs.show') && request()->route('topic') === 'ui-components/badge'">
                        <span>{{ __('Badge') }}</span>
                    </x-blocks.docs.sidebar-link>
                </li>
                <li class="border-l border-outline px-2 py-0.5 dark:border-outline-dark">
                    <x-blocks.docs.sidebar-link href="{{ route('docs.show', ['topic' => 'ui-components/banner']) }}"
                        :active="request()->routeIs('docs.show') && request()->route('topic') === 'ui-components/banner'">
                        <span>{{ __('Banner') }}</span>
                    </x-blocks.docs.sidebar-link>
                </li>
                <li class="border-l border-outline px-2 py-0.5 dark:border-outline-dark">
                    <x-blocks.docs.sidebar-link
                        href="{{ route('docs.show', ['topic' => 'ui-components/breadcrumb']) }}" :active="request()->routeIs('docs.show') && request()->route('topic') === 'ui-components/breadcrumb'">
                        <span>{{ __('Breadcrumb') }}</span>
                    </x-blocks.docs.sidebar-link>
                </li>
                <li class="border-l border-outline px-2 py-0.5 dark:border-outline-dark">
                    <x-blocks.docs.sidebar-link href="{{ route('docs.show', ['topic' => 'ui-components/button']) }}"
                        :active="request()->routeIs('docs.show') && request()->route('topic') === 'ui-components/button'">
                        <span>{{ __('Button') }}</span>
                    </x-blocks.docs.sidebar-link>
                </li>
                <li class="border-l border-outline px-2 py-0.5 dark:border-outline-dark">
                    <x-blocks.docs.sidebar-link href="{{ route('docs.show', ['topic' => 'ui-components/card']) }}"
                        :active="request()->routeIs('docs.show') && request()->route('topic') === 'ui-components/card'">
                        <span>{{ __('Card') }}</span>
                    </x-blocks.docs.sidebar-link>
                </li>
                <li class="border-l border-outline px-2 py-0.5 dark:border-outline-dark">
                    <x-blocks.docs.sidebar-link
                        href="{{ route('docs.show', ['topic' => 'ui-components/carousel']) }}" :active="request()->routeIs('docs.show') && request()->route('topic') === 'ui-components/carousel'">
                        <span>{{ __('Carousel') }}</span>
                    </x-blocks.docs.sidebar-link>
                </li>
                <li class="border-l border-outline px-2 py-0.5 dark:border-outline-dark">
                    <x-blocks.docs.sidebar-link
                        href="{{ route('docs.show', ['topic' => 'ui-components/checkbox']) }}" :active="request()->routeIs('docs.show') && request()->route('topic') === 'ui-components/checkbox'">
                        <span>{{ __('Checkbox') }}</span>
                    </x-blocks.docs.sidebar-link>
                </li>
                <li class="border-l border-outline px-2 py-0.5 dark:border-outline-dark">
                    <x-blocks.docs.sidebar-link
                        href="{{ route('docs.show', ['topic' => 'ui-components/combobox']) }}" :active="request()->routeIs('docs.show') && request()->route('topic') === 'ui-components/combobox'">
                        <span>{{ __('Combobox') }}</span>
                    </x-blocks.docs.sidebar-link>
                </li>
                <li class="border-l border-outline px-2 py-0.5 dark:border-outline-dark">
                    <x-blocks.docs.sidebar-link href="{{ route('docs.show', ['topic' => 'ui-components/counter']) }}"
                        :active="request()->routeIs('docs.show') && request()->route('topic') === 'ui-components/counter'">
                        <span>{{ __('Counter') }}</span>
                    </x-blocks.docs.sidebar-link>
                </li>
                <li class="border-l border-outline px-2 py-0.5 dark:border-outline-dark">
                    <x-blocks.docs.sidebar-link
                        href="{{ route('docs.show', ['topic' => 'ui-components/dropdown']) }}" :active="request()->routeIs('docs.show') && request()->route('topic') === 'ui-components/dropdown'">
                        <span>{{ __('Dropdown') }}</span>
                    </x-blocks.docs.sidebar-link>
                </li>
                <li class="border-l border-outline px-2 py-0.5 dark:border-outline-dark">
                    <x-blocks.docs.sidebar-link
                        href="{{ route('docs.show', ['topic' => 'ui-components/input-file']) }}" :active="request()->routeIs('docs.show') && request()->route('topic') === 'ui-components/input-file'">
                        <span>{{ __('File Input') }}</span>
                    </x-blocks.docs.sidebar-link>
                </li>
                <li class="border-l border-outline px-2 py-0.5 dark:border-outline-dark">
                    <x-blocks.docs.sidebar-link href="{{ route('docs.show', ['topic' => 'ui-components/input']) }}"
                        :active="request()->routeIs('docs.show') && request()->route('topic') === 'ui-components/input'">
                        <span>{{ __('Input') }}</span>
                    </x-blocks.docs.sidebar-link>
                </li>
                <li class="border-l border-outline px-2 py-0.5 dark:border-outline-dark">
                    <x-blocks.docs.sidebar-link
                        href="{{ route('docs.show', ['topic' => 'ui-components/line-chart']) }}" :active="request()->routeIs('docs.show') && request()->route('topic') === 'ui-components/line-chart'">
                        <span>{{ __('Line Chart') }}</span>
                    </x-blocks.docs.sidebar-link>
                </li>
                <li class="border-l border-outline px-2 py-0.5 dark:border-outline-dark">
                    <x-blocks.docs.sidebar-link href="{{ route('docs.show', ['topic' => 'ui-components/modal']) }}"
                        :active="request()->routeIs('docs.show') && request()->route('topic') === 'ui-components/modal'">
                        <span>{{ __('Modal') }}</span>
                    </x-blocks.docs.sidebar-link>
                </li>
                <li class="border-l border-outline px-2 py-0.5 dark:border-outline-dark">
                    <x-blocks.docs.sidebar-link
                        href="{{ route('docs.show', ['topic' => 'ui-components/notification']) }}"
                        :active="request()->routeIs('docs.show') && request()->route('topic') === 'ui-components/notification'">
                        <span>{{ __('Notification') }}</span>
                    </x-blocks.docs.sidebar-link>
                </li>
                <li class="border-l border-outline px-2 py-0.5 dark:border-outline-dark">
                    <x-blocks.docs.sidebar-link
                        href="{{ route('docs.show', ['topic' => 'ui-components/progress']) }}" :active="request()->routeIs('docs.show') && request()->route('topic') === 'ui-components/progress'">
                        <span>{{ __('Progress') }}</span>
                    </x-blocks.docs.sidebar-link>
                </li>
                <li class="border-l border-outline px-2 py-0.5 dark:border-outline-dark">
                    <x-blocks.docs.sidebar-link href="{{ route('docs.show', ['topic' => 'ui-components/radio']) }}"
                        :active="request()->routeIs('docs.show') && request()->route('topic') === 'ui-components/radio'">
                        <span>{{ __('Radio') }}</span>
                    </x-blocks.docs.sidebar-link>
                </li>
                <li class="border-l border-outline px-2 py-0.5 dark:border-outline-dark">
                    <x-blocks.docs.sidebar-link
                        href="{{ route('docs.show', ['topic' => 'ui-components/range-slider']) }}"
                        :active="request()->routeIs('docs.show') && request()->route('topic') === 'ui-components/range-slider'">
                        <span>{{ __('Range Slider') }}</span>
                    </x-blocks.docs.sidebar-link>
                </li>
                <li class="border-l border-outline px-2 py-0.5 dark:border-outline-dark">
                    <x-blocks.docs.sidebar-link href="{{ route('docs.show', ['topic' => 'ui-components/select']) }}"
                        :active="request()->routeIs('docs.show') && request()->route('topic') === 'ui-components/select'">
                        <span>{{ __('Select') }}</span>
                    </x-blocks.docs.sidebar-link>
                </li>
                <li class="border-l border-outline px-2 py-0.5 dark:border-outline-dark">
                    <x-blocks.docs.sidebar-link
                        href="{{ route('docs.show', ['topic' => 'ui-components/share-widget']) }}"
                        :active="request()->routeIs('docs.show') && request()->route('topic') === 'ui-components/share-widget'">
                        <span>{{ __('Share Widget') }}</span>
                    </x-blocks.docs.sidebar-link>
                </li>
                <li class="border-l border-outline px-2 py-0.5 dark:border-outline-dark">
                    <x-blocks.docs.sidebar-link href="{{ route('docs.show', ['topic' => 'ui-components/steps']) }}"
                        :active="request()->routeIs('docs.show') && request()->route('topic') === 'ui-components/steps'">
                        <span>{{ __('Steps') }}</span>
                    </x-blocks.docs.sidebar-link>
                </li>
                <li class="border-l border-outline px-2 py-0.5 dark:border-outline-dark">
                    <x-blocks.docs.sidebar-link href="{{ route('docs.show', ['topic' => 'ui-components/table']) }}"
                        :active="request()->routeIs('docs.show') && request()->route('topic') === 'ui-components/table'">
                        <span>{{ __('Table') }}</span>
                    </x-blocks.docs.sidebar-link>
                </li>
                <li class="border-l border-outline px-2 py-0.5 dark:border-outline-dark">
                    <x-blocks.docs.sidebar-link href="{{ route('docs.show', ['topic' => 'ui-components/tabs']) }}"
                        :active="request()->routeIs('docs.show') && request()->route('topic') === 'ui-components/tabs'">
                        <span>{{ __('Tabs') }}</span>
                    </x-blocks.docs.sidebar-link>
                </li>
                <li class="border-l border-outline px-2 py-0.5 dark:border-outline-dark">
                    <x-blocks.docs.sidebar-link
                        href="{{ route('docs.show', ['topic' => 'ui-components/textarea']) }}" :active="request()->routeIs('docs.show') && request()->route('topic') === 'ui-components/textarea'">
                        <span>{{ __('Textarea') }}</span>
                    </x-blocks.docs.sidebar-link>
                </li>
                <li class="border-l border-outline px-2 py-0.5 dark:border-outline-dark">
                    <x-blocks.docs.sidebar-link href="{{ route('docs.show', ['topic' => 'ui-components/toggle']) }}"
                        :active="request()->routeIs('docs.show') && request()->route('topic') === 'ui-components/toggle'">
                        <span>{{ __('Toggle') }}</span>
                    </x-blocks.docs.sidebar-link>
                </li>
                <li class="border-l border-outline px-2 py-0.5 dark:border-outline-dark">
                    <x-blocks.docs.sidebar-link href="{{ route('docs.show', ['topic' => 'ui-components/tooltip']) }}"
                        :active="request()->routeIs('docs.show') && request()->route('topic') === 'ui-components/tooltip'">
                        <span>{{ __('Tooltip') }}</span>
                    </x-blocks.docs.sidebar-link>
                </li>
            </ul>


        </div>
    </nav>

    {{-- Top navbar & main content area --}}
    <div class="flex h-full w-full flex-col bg-surface dark:bg-surface-dark">
        {{-- On mobile, the sidebar is fixed off-canvas, so no margin-left.
             On md+ the sidebar is relative and takes 64px width, so we add md:ml-64. --}}

        <x-blocks.docs.top-navbar :breadcrumbs="$breadcrumbs" />

        <div id="main-content" class="flex-1 min-h-0 p-4 overflow-y-auto">
            {{ $slot }}
        </div>
    </div>
</div>
