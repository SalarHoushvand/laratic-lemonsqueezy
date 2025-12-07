<div {{ $attributes }}>
    <div class="flex flex-col justify-center items-center gap-4">
        <h2 class="heading-3 text-center max-w-xl">
            {{ __('Everything You Need') }}
        </h2>
        <div class="flex items-center justify-center gap-2">
            <div class="size-2 bg-primary dark:bg-primary-dark rounded-full"></div>
            <div class="size-2 bg-primary dark:bg-primary-dark rounded-full"></div>
            <div class="size-2 bg-primary dark:bg-primary-dark rounded-full"></div>
            <div class="size-2 bg-primary dark:bg-primary-dark rounded-full"></div>
            <div class="size-2 bg-primary dark:bg-primary-dark rounded-full"></div>
        </div>
        <p class="text-center max-w-md text-on-surface-muted dark:text-on-surface-dark-muted">
            {{ __('Features that will help you ship your SaaS application faster.') }}
        </p>
    </div>

    <div class="mt-12 max-w-6xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
            <!-- Authentication -->
            <div
                class="bg-surface-alt/20 dark:bg-surface-dark-alt/20 rounded-radius p-6 border border-outline dark:border-outline-dark">
                <div class="flex items-center gap-3 mb-4">
                    <div class="size-10 rounded-lg bg-blue-500 dark:bg-blue-500 flex items-center justify-center">
                        <x-icons.shield-check variant="micro" class="text-blue-50 dark:text-blue-50" size="lg" />
                    </div>
                    <h3 class="heading-5 text-on-surface-strong dark:text-on-surface-dark-strong">
                        {{ __('Authentication') }}
                    </h3>
                </div>
                <ul class="list-disc list-inside space-y-2 text-sm text-on-surface-muted dark:text-on-surface-dark-muted">
                    <li>{{ __('Email verification') }}</li>
                    <li>{{ __('Two-factor authentication') }}</li>
                    <li>{{ __('Password reset') }}</li>
                    <li>{{ __('Social logins') }}</li>
                </ul>
            </div>

            <!-- AI Integration -->
            <div
                class="bg-surface-alt/20 dark:bg-surface-dark-alt/10 rounded-radius p-6 border border-outline dark:border-outline-dark">
                <div class="flex items-center gap-3 mb-4">
                    <div
                        class="size-10 rounded-lg bg-violet-500 dark:bg-violet-500 flex items-center justify-center">
                        <x-icons.sparkles variant="micro" class="text-violet-50 dark:text-violet-50" size="md" />
                    </div>
                    <h3 class="heading-5 text-on-surface-strong dark:text-on-surface-dark-strong">
                        {{ __('AI Integration') }}
                    </h3>
                </div>
                <ul class="list-disc list-inside space-y-2 text-sm text-on-surface-muted dark:text-on-surface-dark-muted">
                    <li>{{ __('Plug-and-play AI chat with streaming') }}</li>
                    <li>{{ __('OpenAI integration') }}</li>
                    <li>{{ __('AI dashboard') }}</li>
                    <li>{{ __('Post generation and translation') }}</li>
                    <li>{{ __('AI usage tracking and cost calculation') }}</li>
                </ul>
            </div>

            <!-- Admin Dashboard -->
            <div
                class="bg-surface-alt/20 dark:bg-surface-dark-alt/10 rounded-radius p-6 border border-outline dark:border-outline-dark">
                <div class="flex items-center gap-3 mb-4">
                    <div
                        class="size-10 rounded-lg bg-cyan-500 dark:bg-cyan-500 flex items-center justify-center">
                        <x-icons.chart-bar variant="micro" class="text-cyan-50 dark:text-cyan-50"
                            size="md" />
                    </div>
                    <h3 class="heading-5 text-on-surface-strong dark:text-on-surface-dark-strong">
                        {{ __('Admin Dashboard') }}
                    </h3>
                </div>
                <ul class="list-disc list-inside space-y-2 text-sm text-on-surface-muted dark:text-on-surface-dark-muted">
                    <li>{{ __('Analytics and metrics') }}</li>
                    <li>{{ __('User management') }}</li>
                    <li>{{ __('Order management') }}</li>
                    <li>{{ __('Transaction management') }}</li>
                    <li>{{ __('AI usage tracking') }}</li>
                    <li>{{ __('Blog management') }}</li>
                </ul>
            </div>

            <!-- Payment System -->
            <div
                class="bg-surface-alt/20 dark:bg-surface-dark-alt/10 rounded-radius p-6 border border-outline dark:border-outline-dark">
                <div class="flex items-center gap-3 mb-4">
                    <div
                        class="size-10 rounded-lg bg-emerald-500 dark:bg-emerald-500 flex items-center justify-center">
                        <x-icons.credit-card variant="micro" class="text-emerald-50 dark:text-emerald-50"
                            size="md" />
                    </div>
                    <h3 class="heading-5 text-on-surface-strong dark:text-on-surface-dark-strong">
                        {{ __('Payment System') }}
                    </h3>
                </div>
                <ul class="list-disc list-inside space-y-2 text-sm text-on-surface-muted dark:text-on-surface-dark-muted">
                    <li>{{ __('Recurring subscriptions') }}</li>
                    <li>{{ __('One-time purchases') }}</li>
                    <li>{{ __('Payment and order management') }}</li>
                    <li>{{ __('Transaction tracking') }}</li>
                </ul>
            </div>

            <!-- Blog System -->
            <div
                class="bg-surface-alt/20 dark:bg-surface-dark-alt/10 rounded-radius p-6 border border-outline dark:border-outline-dark">
                <div class="flex items-center gap-3 mb-4">
                    <div
                        class="size-10 rounded-lg bg-fuchsia-500 dark:bg-fuchsia-500 flex items-center justify-center">
                        <x-icons.document-text variant="micro" class="text-fuchsia-50 dark:text-fuchsia-50"
                            size="md" />
                    </div>
                    <h3 class="heading-5 text-on-surface-strong dark:text-on-surface-dark-strong">
                        {{ __('Blog System') }}
                    </h3>
                </div>
                <ul class="list-disc list-inside space-y-2 text-sm text-on-surface-muted dark:text-on-surface-dark-muted">
                    <li>{{ __('AI-powered post generation') }}</li>
                    <li>{{ __('Integrated Markdown editor') }}</li>
                    <li>{{ __('Organize content with categories') }}</li>
                    <li>{{ __('Supports multiple languages') }}</li>
                    <li>{{ __('Built-in SEO optimization') }}</li>
                    <li>{{ __('Newsletter integration') }}</li>
                </ul>
            </div>

            <!-- Customizable Style -->
            <div
                class="bg-surface-alt/20 dark:bg-surface-dark-alt/10 rounded-radius p-6 border border-outline dark:border-outline-dark">
                <div class="flex items-center gap-3 mb-4">
                    <div
                        class="size-10 rounded-lg bg-amber-500 dark:bg-amber-500 flex items-center justify-center">
                        <x-icons.paint-brush variant="micro" class="text-amber-50 dark:text-amber-50" size="md" />
                    </div>
                    <h3 class="heading-5 text-on-surface-strong dark:text-on-surface-dark-strong">
                        {{ __('Customizable Style') }}
                    </h3>
                </div>
                <ul class="list-disc list-inside space-y-2 text-sm text-on-surface-muted dark:text-on-surface-dark-muted">
                    <li>{{ __('Prebuilt themes') }}</li>
                    <li>{{ __('Dark mode support') }}</li>
                    <li>{{ __('Easily adjust brand colors and typography') }}</li>
                    <li>{{ __('Utility-first styling powered by Tailwind CSS') }}</li>
                </ul>
            </div>

            <!-- Marketing -->
            <div
                class="bg-surface-alt/20 dark:bg-surface-dark-alt/10 rounded-radius p-6 border border-outline dark:border-outline-dark">
                <div class="flex items-center gap-3 mb-4">
                    <div
                        class="size-10 rounded-lg bg-purple-500 dark:bg-purple-500 flex items-center justify-center">
                        <x-icons.megaphone variant="micro" class="text-purple-50 dark:text-purple-50" size="md" />
                    </div>
                    <h3 class="heading-5 text-on-surface-strong dark:text-on-surface-dark-strong">
                        {{ __('Marketing') }}
                    </h3>
                </div>
                <ul class="list-disc list-inside space-y-2 text-sm text-on-surface-muted dark:text-on-surface-dark-muted">
                    <li>{{ __('Homepage') }}</li>
                    <li>{{ __('Pricing page') }}</li>
                    <li>{{ __('About us page') }}</li>
                    <li>{{ __('Blog listing and posts') }}</li>
                    <li>{{ __('All pages SEO optimized') }}</li>
                    <li>{{ __('Newsletter integration') }}</li>
                    <li>{{ __('Automatic XML sitemap generator') }}</li>
                </ul>
            </div>

            <!-- Developer Friendly -->
            <div
                class="bg-surface-alt/20 dark:bg-surface-dark-alt/10 rounded-radius p-6 border border-outline dark:border-outline-dark">
                <div class="flex items-center gap-3 mb-4">
                    <div
                        class="size-10 rounded-lg bg-orange-500 dark:bg-orange-500 flex items-center justify-center">
                        <x-icons.code-bracket variant="micro" class="text-orange-50 dark:text-orange-50" size="md" />
                    </div>
                    <h3 class="heading-5 text-on-surface-strong dark:text-on-surface-dark-strong">
                        {{ __('Developer Friendly') }}
                    </h3>
                </div>
                <ul class="list-disc list-inside space-y-2 text-sm text-on-surface-muted dark:text-on-surface-dark-muted">
                    <li>{{ __('Works seamlessly with AI coding assistants like Cursor') }}</li>
                    <li>{{ __('Comprehensive documentation') }}</li>
                    <li>{{ __('Clean, maintainable codebase') }}</li>
                    <li>{{ __('Pre-built components and assets for rapid expansion') }}</li>
                </ul>
            </div>

            <!-- Translation -->
            <div
                class="bg-surface-alt/20 dark:bg-surface-dark-alt/10 rounded-radius p-6 border border-outline dark:border-outline-dark">
                <div class="flex items-center gap-3 mb-4">
                    <div
                        class="size-10 rounded-lg bg-pink-500 dark:bg-pink-500 flex items-center justify-center">
                        <x-icons.language variant="micro" class="text-pink-50 dark:text-pink-50" size="md" />
                    </div>
                    <h3 class="heading-5 text-on-surface-strong dark:text-on-surface-dark-strong">
                        {{ __('Translation') }}
                    </h3>
                </div>
                <ul class="list-disc list-inside space-y-2 text-sm text-on-surface-muted dark:text-on-surface-dark-muted">
                    <li>{{ __('AI-powered translation') }}</li>
                    <li>{{ __('Add any language you need') }}</li>
                    <li>{{ __('Translate posts in seconds') }}</li>
                    <li>{{ __('Language switcher') }}</li>
                </ul>
            </div>

            <!-- Roles & Permissions -->
            <div
                class="bg-surface-alt/20 dark:bg-surface-dark-alt/10 rounded-radius p-6 border border-outline dark:border-outline-dark">
                <div class="flex items-center gap-3 mb-4">
                    <div class="size-10 rounded-lg bg-slate-500 dark:bg-slate-500 flex items-center justify-center">
                        <x-icons.users variant="micro" class="text-slate-50 dark:text-slate-50" size="md" />
                    </div>
                    <h3 class="heading-5 text-on-surface-strong dark:text-on-surface-dark-strong">
                        {{ __('Roles & Permissions') }}
                    </h3>
                </div>
                <ul class="list-disc list-inside space-y-2 text-sm text-on-surface-muted dark:text-on-surface-dark-muted">
                    <li>{{ __('Predefined roles like admin and user') }}</li>
                    <li>{{ __('Fine-grained permission system') }}</li>
                    <li>{{ __('Route and UI access control based on roles') }}</li>
                    <li>{{ __('Manage roles and permissions from the admin dashboard') }}</li>
                </ul>
            </div>

            <!-- Documentation -->
            <div
                class="bg-surface-alt/20 dark:bg-surface-dark-alt/10 rounded-radius p-6 border border-outline dark:border-outline-dark">
                <div class="flex items-center gap-3 mb-4">
                    <div
                        class="size-10 rounded-lg bg-indigo-500 dark:bg-indigo-500 flex items-center justify-center">
                        <x-icons.book-open variant="micro" class="text-indigo-50 dark:text-indigo-50" size="md" />
                    </div>
                    <h3 class="heading-5 text-on-surface-strong dark:text-on-surface-dark-strong">
                        {{ __('Documentation') }}
                    </h3>
                </div>
                <ul class="list-disc list-inside space-y-2 text-sm text-on-surface-muted dark:text-on-surface-dark-muted">
                    <li>{{ __('Docs template and layout') }}</li>
                    <li>{{ __('Changelog') }}</li>
                    <li>{{ __('Code highlighting') }}</li>
                    <li>{{ __('Getting started guides to launch faster') }}</li>
                </ul>
            </div>

            <!-- Email -->
            <div
                class="bg-surface-alt/20 dark:bg-surface-dark-alt/10 rounded-radius p-6 border border-outline dark:border-outline-dark">
                <div class="flex items-center gap-3 mb-4">
                    <div
                        class="size-10 rounded-lg bg-rose-500 dark:bg-rose-500 flex items-center justify-center">
                        <x-icons.envelope variant="micro" class="text-rose-50 dark:text-rose-50" size="md" />
                    </div>
                    <h3 class="heading-5 text-on-surface-strong dark:text-on-surface-dark-strong">
                        {{ __('Email') }}
                    </h3>
                </div>
                <ul class="list-disc list-inside space-y-2 text-sm text-on-surface-muted dark:text-on-surface-dark-muted">
                    <li>{{ __('Transactional emails ready out of the box') }}</li>
                    <li>{{ __('Prebuilt email templates') }}</li>
                    <li>{{ __('Password reset and verification emails configured') }}</li>
                    <li>{{ __('Mailgun-ready configuration for quick setup') }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>
