<!-- Alternating Block -->
<div {{ $attributes }}>
    <x-typography.guest-page-header
        title="{{ __('Features') }}"
        description="{{ __('Everything you need to bring your idea to life.') }}"
        size="h2"
        :divider-dots="true" />

    <!-- Feature 1 -->
    <div
        class="mt-12 md:mt-24 max-w-6xl text-center md:text-left mx-auto flex flex-col-reverse justify-center items-center gap-8 md:gap-16 md:flex-row">
        <div class="w-full md:w-2/5 my-auto space-y-4">
            {{-- Heading for desktop --}}
            <div class="hidden md:block ">
                <h3 class="heading-3 text-on-surface-strong dark:text-on-surface-dark-strong">
                    {{ __('Authentication') }}
                </h3>
                <p class=" text-on-surface-muted dark:text-on-surface-dark-muted">
                    {{ __('Clean, production-ready authentication with:') }}
                </p>
            </div>
            <ul class="space-y-2 text-sm md:text-base text-left list-disc list-inside marker:text-primary dark:marker:text-primary-dark">
                <li>
                    {{ __('Email Verification') }}
                </li>
                <li>
                    {{ __('Two-Factor Authentication') }}
                </li>
                <li>
                    {{ __('Password Reset') }}
                </li>
                <li>
                    {{ __('Social Login') }}
                </li>
            </ul>

            {{-- <x-button variant="primary" size="sm" href="{{ route('register') }}"
                class="w-fit mx-auto md:mx-0 flex items-center mt-4 md:mt-8">
                {{ __('Sign up today') }}
            </x-button> --}}
        </div>

        <div class="relative w-full md:w-3/5">
            <div class="block md:hidden space-y-2 mb-4">
                {{-- Heading for mobile --}}
                <h3 class="heading-4 text-on-surface-strong dark:text-on-surface-dark-strong">
                    {{ __('Authentication') }}
                </h3>
                <p class=" text-on-surface-muted dark:text-on-surface-dark-muted text-sm text-pretty">
                    {{ __('Clean, production-ready authentication with:') }}
                </p>
            </div>
            <div class="relative">
                <img src="{{ asset('images/2fa-dark.webp') }}"
                    alt="{{ __('A clean, modern dashboard with key SaaS metrics') }}"
                    class="w-full h-auto hidden dark:block" loading="lazy" decoding="async">
                <img src="{{ asset('images/2fa-light.webp') }}"
                    alt="{{ __('A clean, modern dashboard with key SaaS metrics') }}"
                    class="w-full h-auto block dark:hidden" loading="lazy" decoding="async">
            </div>
            <div
                class="hidden lg:block absolute -z-10 size-35 top-[70%] left-[60%] -translate-x-1/2 -translate-y-1/2 bg-primary dark:bg-primary-dark opacity-50 rotate-180 animate-float blur-[60px]">
            </div>
            <div
                class="hidden lg:block absolute -z-10 size-30 top-1/3 left-[40%] -translate-x-1/2 -translate-y-1/2 bg-primary dark:bg-primary-dark opacity-50 rotate-180 animate-float blur-[60px]">
            </div>
        </div>
    </div>

    <!-- Feature 2 -->
    <div
        class="mt-12 md:mt-24 max-w-7xl text-center md:text-left mx-auto flex flex-col justify-center items-center gap-8 md:gap-16 md:flex-row">

        <div class="relative w-full md:w-3/5">
            <div class="block md:hidden space-y-2 mb-4">
                {{-- Heading for mobile --}}
                <h3 class="heading-4 text-on-surface-strong dark:text-on-surface-dark-strong">
                    <span class="text-primary dark:text-primary-dark">{{ __('AI') }}</span>
                    {{ __('Integration') }}
                </h3>
                <p class=" text-on-surface-muted dark:text-on-surface-dark-muted text-sm text-pretty">
                    {{ __('Easily bring the power of AI to your application with:') }}
                </p>
            </div>
            <div class="relative">
                <div class="relative">
                    <img src="{{ asset('images/ai-integration-dark.webp') }}"
                        alt="{{ __('A clean, modern dashboard with key SaaS metrics') }}"
                        class="w-full h-auto hidden dark:block" loading="lazy" decoding="async">
                    <img src="{{ asset('images/ai-integration-light.webp') }}"
                        alt="{{ __('A clean, modern dashboard with key SaaS metrics') }}"
                        class="w-full h-auto block dark:hidden" loading="lazy" decoding="async">
                </div>
            </div>
            <div
                class="hidden lg:block absolute -z-10 w-40 h-40 top-[70%] left-[30%] -translate-x-1/2 -translate-y-1/2 bg-primary dark:bg-primary-dark opacity-50 -rotate-180 animate-float blur-[60px]">
            </div>
            <div
                class="hidden lg:block absolute -z-10 w-30 h-30 top-1/3 left-[50%] -translate-x-1/2 -translate-y-1/2 bg-primary dark:bg-primary-dark opacity-50 -rotate-180 animate-float blur-[60px]">
            </div>
        </div>
        <div class="w-full md:w-2/5 my-auto space-y-4">

            {{-- Heading for desktop --}}
            <div class="hidden md:block ">
                <h3 class="heading-3 text-on-surface-strong dark:text-on-surface-dark-strong">
                    <span class="text-primary dark:text-primary-dark">{{ __('AI') }}</span>
                    {{ __('Integration') }}
                </h3>
                <p class=" text-on-surface-muted dark:text-on-surface-dark-muted">
                    {{ __('Easily bring the power of AI to your application with:') }}
                </p>
            </div>
            <ul class="space-y-2 text-sm md:text-base text-left list-disc list-inside marker:text-primary dark:marker:text-primary-dark">
                <li>
                    {{ __('Plug & Play AI Chat with Streaming') }}
                </li>
                <li>
                    <span> {{ __('Back-end AI Integration') }}: <span
                            class="text-on-surface-muted dark:text-on-surface-dark-muted text-sm">{{ __('That you can use to implement your own AI features') }}</span></span>
                </li>
                <li>
                    {{ __('AI Usage Tracking and Cost Calculation') }}
                </li>
            </ul>

            {{-- <x-button variant="primary" size="sm" href="{{ route('register') }}"
                class="w-fit mx-auto md:mx-0 flex items-center gap-2 ">
                {{ __('Sign up today') }}
            </x-button> --}}
        </div>
    </div>


    <!-- Feature 3 -->
    <div
        class="mt-12 md:mt-24 max-w-6xl text-center md:text-left mx-auto flex flex-col-reverse justify-center items-center gap-8 md:gap-16 md:flex-row">
        <div class="w-full md:w-2/5 my-auto space-y-4">
            {{-- Heading for desktop --}}
            <div class="hidden md:block ">
                <h3 class="heading-3 text-on-surface-strong dark:text-on-surface-dark-strong">
                    {{ __('Powerful') }} <span class="text-primary dark:text-primary-dark">{{ __('Blog') }}</span>
                </h3>
                <p class=" text-on-surface-muted dark:text-on-surface-dark-muted">
                    {{ __('Create, edit, translate, and manage blog posts with the help of built-in AI to help you generate content faster.') }}
                </p>
            </div>
            <ul class="space-y-2 text-sm md:text-base text-left list-disc list-inside marker:text-primary dark:marker:text-primary-dark">
                <li>
                    {{ __('AI-powered post generation, with cover image') }}
                </li>
                <li>
                    {{ __('Integrated markdown text editor') }}
                </li>
                <li>
                    {{ __('Organize content with categories') }}
                </li>
                <li>
                    {{ __('Supports Multiple Languages') }}
                </li>
                <li>
                    {{ __('Built-in SEO optimization for better discoverability') }}
                </li>
                <li>
                    {{ __('Newsletter integration for easy email marketing') }}
                </li>
            </ul>

            <x-button variant="primary" size="sm" href="{{ route('register') }}"
                class="w-fit mx-auto md:mx-0 flex items-center mt-4 md:mt-8">
                {{ __('See a demo') }}
            </x-button>
        </div>

        <div class="relative w-full md:w-3/5">
            <div class="block md:hidden space-y-2 mb-4">
                {{-- Heading for mobile --}}
                <h3 class="heading-4 text-on-surface-strong dark:text-on-surface-dark-strong">
                    {{ __('Powerful') }} <span class="text-primary dark:text-primary-dark">{{ __('Blog') }}</span>
                </h3>
                <p class=" text-on-surface-muted dark:text-on-surface-dark-muted text-sm text-pretty">
                    {{ __('Create, edit, translate, and manage blog posts with the help of built-in AI to help you generate content faster.') }}
                </p>
            </div>
            <div class="relative">
                <img src="{{ asset('images/blog-dark.webp') }}"
                    alt="{{ __('A clean, modern dashboard with key SaaS metrics') }}"
                    class="w-full h-auto hidden dark:block" loading="lazy" decoding="async">
                <img src="{{ asset('images/blog-light.webp') }}"
                    alt="{{ __('A clean, modern dashboard with key SaaS metrics') }}"
                    class="w-full h-auto block dark:hidden" loading="lazy" decoding="async">
            </div>
            <div
                class="hidden lg:block absolute -z-10 size-35 top-[70%] left-[60%] -translate-x-1/2 -translate-y-1/2 bg-primary dark:bg-primary-dark opacity-50 rotate-180 animate-float blur-[60px]">
            </div>
            <div
                class="hidden lg:block absolute -z-10 size-30 top-1/3 left-[40%] -translate-x-1/2 -translate-y-1/2 bg-primary dark:bg-primary-dark opacity-50 rotate-180 animate-float blur-[60px]">
            </div>
        </div>
    </div>


    <!-- Feature 4 -->
    <div
        class="mt-12 md:mt-24 max-w-7xl text-center md:text-left mx-auto flex flex-col justify-center items-center gap-8 md:gap-16 md:flex-row">

        <div class="relative w-full md:w-3/5">
            <div class="block md:hidden space-y-2 mb-4">
                {{-- Heading for mobile --}}
                <h3 class="heading-4 text-on-surface-strong dark:text-on-surface-dark-strong">
                    {{ __('Translation Made Easy') }}
                </h3>
                <p class=" text-on-surface-muted dark:text-on-surface-dark-muted text-sm text-pretty">
                    {{ __('Translate posts into multiple languages with the built-in AI translator.') }}
                </p>
            </div>
            <div class="relative">
                <div class="relative">
                    <img src="{{ asset('images/ai-translation-dark.webp') }}"
                        alt="{{ __('A clean, modern dashboard with key SaaS metrics') }}"
                        class="w-full h-auto hidden dark:block" loading="lazy" decoding="async">
                    <img src="{{ asset('images/ai-translation-light.webp') }}"
                        alt="{{ __('A clean, modern dashboard with key SaaS metrics') }}"
                        class="w-full h-auto block dark:hidden" loading="lazy" decoding="async">
                </div>
            </div>
            <div
                class="hidden lg:block absolute -z-10 w-40 h-40 top-[70%] left-[30%] -translate-x-1/2 -translate-y-1/2 bg-primary dark:bg-primary-dark opacity-50 -rotate-180 animate-float blur-[60px]">
            </div>
            <div
                class="hidden lg:block absolute -z-10 w-30 h-30 top-1/3 left-[50%] -translate-x-1/2 -translate-y-1/2 bg-primary dark:bg-primary-dark opacity-50 -rotate-180 animate-float blur-[60px]">
            </div>
        </div>
        <div class="w-full md:w-2/5 my-auto space-y-4">

            {{-- Heading for desktop --}}
            <div class="hidden md:block ">
                <h3 class="heading-3 text-on-surface-strong dark:text-on-surface-dark-strong">
                    {{ __('Translation Made Easy') }}
                </h3>
                <p class=" text-on-surface-muted dark:text-on-surface-dark-muted">
                    {{ __('Translate posts into multiple languages with the built-in AI translator.') }}
                </p>
            </div>
            <ul class="space-y-2 text-sm md:text-base text-left list-disc list-inside marker:text-primary dark:marker:text-primary-dark">
                <li>
                    {{ __('AI-powered translation') }}
                </li>
                <li>
                    {{ __('Add any language you need') }}
                </li>
                <li>
                    {{ __('Translate posts in seconds') }}
                </li>
            </ul>

            {{-- <x-button variant="primary" size="sm" href="{{ route('register') }}"
                class="w-fit mx-auto md:mx-0 flex items-center gap-2 ">
                {{ __('Sign up today') }}
            </x-button> --}}
        </div>
    </div>


    <!-- Feature 5 -->
    <div
        class="mt-12 md:mt-24 max-w-6xl text-center md:text-left mx-auto flex flex-col-reverse justify-center items-center gap-8 md:gap-16 md:flex-row">
        <div class="w-full md:w-2/5 my-auto space-y-4">
            {{-- Heading for desktop --}}
            <div class="hidden md:block ">
                <h3 class="heading-3 text-on-surface-strong dark:text-on-surface-dark-strong">
                    <span class="text-primary dark:text-primary-dark">{{ __('Payment') }}</span> {{ __('System') }}
                </h3>
                <p class=" text-on-surface-muted dark:text-on-surface-dark-muted">
                    {{ __('Support subscriptions and one-time purchases with the built-in LemonSqueezy payment system.') }}
                </p>
            </div>
            <ul class="space-y-2 text-sm md:text-base text-left list-disc list-inside marker:text-primary dark:marker:text-primary-dark">
                <li>
                    {{ __('Recurring subscriptions') }}
                </li>
                <li>
                    {{ __('One-time purchases') }}
                </li>
                <li>
                    {{ __('Payment & Order Management') }}
                </li>
                <li>
                    {{ __('Transaction Tracking') }}
                </li>
            </ul>

            {{-- <x-button variant="primary" size="sm" href="{{ route('register') }}"
                class="w-fit mx-auto md:mx-0 flex items-center mt-4 md:mt-8">
                {{ __('See a demo') }}
            </x-button> --}}
        </div>

        <div class="relative w-full md:w-3/5">
            <div class="block md:hidden space-y-2 mb-4">
                {{-- Heading for mobile --}}
                <h3 class="heading-4 text-on-surface-strong dark:text-on-surface-dark-strong">
                    <span class="text-primary dark:text-primary-dark">{{ __('Payment') }}</span> {{ __('System') }}
                </h3>
                <p class=" text-on-surface-muted dark:text-on-surface-dark-muted text-sm text-pretty">
                    {{ __('Support subscriptions and one-time purchases with the built-in LemonSqueezy payment system.') }}
                </p>
            </div>
            <div class="relative">
                <img src="{{ asset('images/payment-dark.webp') }}"
                    alt="{{ __('A clean, modern dashboard with key SaaS metrics') }}"
                    class="w-full h-auto hidden dark:block" loading="lazy" decoding="async">
                <img src="{{ asset('images/payment-light.webp') }}"
                    alt="{{ __('A clean, modern dashboard with key SaaS metrics') }}"
                    class="w-full h-auto block dark:hidden" loading="lazy" decoding="async">
            </div>
            <div
                class="hidden lg:block absolute -z-10 size-35 top-[70%] left-[60%] -translate-x-1/2 -translate-y-1/2 bg-primary dark:bg-primary-dark opacity-50 rotate-180 animate-float blur-[60px]">
            </div>
            <div
                class="hidden lg:block absolute -z-10 size-30 top-1/3 left-[40%] -translate-x-1/2 -translate-y-1/2 bg-primary dark:bg-primary-dark opacity-50 rotate-180 animate-float blur-[60px]">
            </div>
        </div>
    </div>

    <!-- Feature 6 -->
    <div
        class="mt-12 md:mt-24 max-w-7xl text-center md:text-left mx-auto flex flex-col justify-center items-center gap-8 md:gap-16 md:flex-row">

        <div class="relative w-full md:w-3/5">
            <div class="block md:hidden space-y-2 mb-4">
                {{-- Heading for mobile --}}
                <h3 class="heading-4 text-on-surface-strong dark:text-on-surface-dark-strong">
                    {{ __('Admin Dashboard') }}
                </h3>
                <p class=" text-on-surface-muted dark:text-on-surface-dark-muted text-sm text-pretty">
                    {{ __('A comprehensive admin dashboard to manage your application.') }}
                </p>
            </div>
            <div class="relative">
                <div class="relative">
                    <img src="{{ asset('images/admin-dashboard-dark.webp') }}"
                        alt="{{ __('A clean, modern dashboard with key SaaS metrics') }}"
                        class="w-full h-auto hidden dark:block" loading="lazy" decoding="async">
                    <img src="{{ asset('images/admin-dashboard-light.webp') }}"
                        alt="{{ __('A clean, modern dashboard with key SaaS metrics') }}"
                        class="w-full h-auto block dark:hidden" loading="lazy" decoding="async">
                </div>
            </div>
            <div
                class="hidden lg:block absolute -z-10 w-40 h-40 top-[70%] left-[30%] -translate-x-1/2 -translate-y-1/2 bg-primary dark:bg-primary-dark opacity-50 -rotate-180 animate-float blur-[60px]">
            </div>
            <div
                class="hidden lg:block absolute -z-10 w-30 h-30 top-1/3 left-[50%] -translate-x-1/2 -translate-y-1/2 bg-primary dark:bg-primary-dark opacity-50 -rotate-180 animate-float blur-[60px]">
            </div>
        </div>
        <div class="w-full md:w-2/5 my-auto space-y-4">

            {{-- Heading for desktop --}}
            <div class="hidden md:block ">
                <h3 class="heading-3 text-on-surface-strong dark:text-on-surface-dark-strong">
                    {{ __('Admin Dashboard') }}
                </h3>
                <p class=" text-on-surface-muted dark:text-on-surface-dark-muted">
                    {{ __('A comprehensive admin dashboard to manage your application.') }}
                </p>
            </div>
            <ul class="space-y-2 text-sm md:text-base text-left list-disc list-inside marker:text-primary dark:marker:text-primary-dark">
                <li>
                    {{ __('Analytics and Metrics') }}
                </li>
                <li>
                    {{ __('User Management') }}
                </li>
                <li>
                    {{ __('Order Management') }}
                </li>
                <li>
                    {{ __('Transaction Management') }}
                </li>
                <li>
                    {{ __('AI Usage Tracking') }}
                </li>
                <li>
                    {{ __('Blog Management') }}
                </li>
            </ul>

            {{-- <x-button variant="primary" size="sm" href="{{ route('register') }}"
                class="w-fit mx-auto md:mx-0 flex items-center gap-2 ">
                {{ __('Sign up today') }}
            </x-button> --}}
        </div>
    </div>


</div>
