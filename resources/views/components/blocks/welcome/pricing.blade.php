
@php
    $plans = [
        (object) [
            'name' => 'Laratic Startup',
            'description' => __('Suitable for startups and small businesses'),
            'price' => 14900, // in cents
            'currency' => 'USD',
            'billing_period' => 'one-time',
            'button_text' => __('Get Started'),
            'features' => [
                __('Payments with Paddle'),
                __('SMS & Email 2FA'),
                __('Multi-language support'),
                __('AI-powered blog system'),
                __('Admin dashboard'),
                __('Recurring subscriptions'),
                __('AI chat integration'),
                __('Roles & permissions'),
                __('Email templates'),
                __('SEO optimization'),
            ],
            'is_featured' => false,
            'href' => '#',
        ],
        (object) [
            'name' => 'Laratic Indie Hacker',
            'description' => __('Suitable for indie hackers and solo developers who want to keep it nice and simple'),
            'price' => 9900, // in cents
            'currency' => 'USD',
            'billing_period' => 'one-time',
            'button_text' => __('Get Started'),
            'features' => [
                __('Payments with Lemonsqueezy'),
                __('Email only 2FA'),
                __('Single-language support'),
                __('AI-powered blog system'),
                __('Admin dashboard'),
                __('Recurring subscriptions'),
                __('AI chat integration'),
                __('Roles & permissions'),
                __('Email templates'),
            ],
            'is_featured' => true,
            'href' => '#',
        ],
        (object) [
            'name' => 'Dual Package',
            'description' => __('Both packages included for the best value'),
            'price' => 19900, // in cents
            'currency' => 'USD',
            'billing_period' => 'one-time',
            'button_text' => __('Get Started'),
            'features' => [
                __('Both packages included'),
                __('Paddle & Lemonsqueezy'),
                __('SMS & Email 2FA'),
                __('Multi-language support'),
                __('AI-powered blog system'),
                __('Admin dashboard'),
                __('Recurring subscriptions'),
                __('AI chat integration'),
                __('Roles & permissions'),
                __('Email templates'),
                __('SEO optimization'),
                __('Best value'),
            ],
            'is_featured' => false,
            'href' => '#',
        ],
    ];
@endphp

<div {{ $attributes }}>
    <!-- Header Section -->
    <div class="flex flex-col justify-center items-center gap-4">
        <h2 class="heading-3 text-center max-w-xl">
            {{ __('Pricing') }}
        </h2>
        <div class="flex items-center justify-center gap-2">
            <div class="size-2 bg-primary dark:bg-primary-dark rounded-full"></div>
            <div class="size-2 bg-primary dark:bg-primary-dark rounded-full"></div>
            <div class="size-2 bg-primary dark:bg-primary-dark rounded-full"></div>
            <div class="size-2 bg-primary dark:bg-primary-dark rounded-full"></div>
            <div class="size-2 bg-primary dark:bg-primary-dark rounded-full"></div>
        </div>
        <p class="text-center max-w-md text-on-surface-muted dark:text-on-surface-dark-muted">
            {{ __('Affordable pricing for indie hackers and solo developers.') }}
        </p>
    </div>

    <!-- Pricing Cards Container -->
    <div class="flex flex-col lg:flex-row gap-8 w-full justify-center mx-auto px-8 mt-12">
        @foreach ($plans as $plan)
            <x-card-subscription-plan :plan="$plan" />
        @endforeach
    </div>

</div>
