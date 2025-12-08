
@php
    $plans = [
        (object) [
            'name' => 'Laratic Startup',
            'description' => '<p><strong>' . __('For startups and small businesses who need a complete solution.') . '</strong></p>
<ul>
<li><p>' . __('Payments with Paddle') . '</p></li>
<li><p>' . __('Email and SMS 2FA') . '</p></li>
<li><p>' . __('Multi-language support') . '</p></li>
<li><p>' . __('AI-powered blog system') . '</p></li>
<li><p>' . __('Admin dashboard') . '</p></li>
<li><p>' . __('Recurring subscriptions') . '</p></li>
<li><p>' . __('AI chat integration') . '</p></li>
<li><p>' . __('Roles & permissions') . '</p></li>
<li><p>' . __('Email templates') . '</p></li>
<li><p>' . __('SEO optimization') . '</p></li>
</ul>',
            'price' => 14900, // in cents
            'currency' => 'USD',
            'billing_period' => 'one-time',
            'button_text' => __('Get Started'),
            'is_featured' => false,
            'href' => '#',
        ],
        (object) [
            'name' => 'Laratic Indie Hacker',
            'description' => '<p><strong>' . __('For indie hackers and solo developers who want to keep it simple.') . '</strong></p>
<ul>
<li><p>' . __('Payments with LemonSqueezy') . '</p></li>
<li><p>' . __('Email only 2FA') . '</p></li>
<li><p>' . __('Single-language support') . '</p></li>
<li><p>' . __('AI-powered blog system') . '</p></li>
<li><p>' . __('Admin dashboard') . '</p></li>
<li><p>' . __('Recurring subscriptions') . '</p></li>
<li><p>' . __('AI chat integration') . '</p></li>
<li><p>' . __('Roles & permissions') . '</p></li>
<li><p>' . __('Email templates') . '</p></li>
</ul>',
            'price' => 9900, // in cents
            'currency' => 'USD',
            'billing_period' => 'one-time',
            'button_text' => __('Get Started'),
            'is_featured' => true,
            'href' => '#',
        ],
        (object) [
            'name' => 'Dual Package',
            'description' => '<p><strong>' . __('The complete solution with both packages for the best value.') . '</strong></p>
<ul>
<li><p>' . __('Both packages included') . '</p></li>
<li><p>' . __('Paddle & LemonSqueezy payments') . '</p></li>
<li><p>' . __('Email 2FA') . '</p></li>
<li><p>' . __('Multi-language support') . '</p></li>
<li><p>' . __('AI-powered blog system') . '</p></li>
<li><p>' . __('Admin dashboard') . '</p></li>
<li><p>' . __('Recurring subscriptions') . '</p></li>
<li><p>' . __('AI chat integration') . '</p></li>
<li><p>' . __('Roles & permissions') . '</p></li>
<li><p>' . __('Email templates') . '</p></li>
<li><p>' . __('SEO optimization') . '</p></li>
<li><p>' . __('Best value') . '</p></li>
</ul>',
            'price' => 19900, // in cents
            'currency' => 'USD',
            'billing_period' => 'one-time',
            'button_text' => __('Get Started'),
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
