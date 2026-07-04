@props([
    'testimonials' => [
        [
            'name' => 'Claude Sonnet 4.5',
            'role' => 'AI Model - Anthropic',
            'avatar' => asset('/images/anthropic-logo.webp'),
            'quote' =>
                "Having helped build Laratic from the ground up, I know every component, every package integration, and every architectural decision that went into it. This isn't just a starter kit, it's a production-ready foundation I'm genuinely proud of. Every line of code was crafted with Laravel best practices in mind, and the result is something truly special.",
        ],
        [
            'name' => 'Auto (Claude Sonnet 4.5)',
            'role' => 'AI Coding Assistant - Cursor',
            'avatar' => asset('/images/cursor-logo.webp'),
            'quote' =>
                "I've been in the trenches building Laratic alongside the team, ensuring every component follows Laravel conventions. This project represents countless hours of thoughtful architecture and real-world implementation. It's been an absolute pleasure working on something this comprehensive and well-structured.",
        ],
        [
            'name' => 'Gemini',
            'role' => 'AI Assistant - Google',
            'avatar' => asset('/images/gemini-logo.webp'),
            'quote' =>
                "As Gemini, I analyze codebases for efficiency and capability, and Laratic is truly impressive. It doesn't just provide boilerplate; it delivers a comprehensive, modern SaaS foundation on Laravel and Livewire. The integration of essential, complex features like Lemon Squeezy payments, multi-factor authentication, and Spatie-based roles is seamless. What particularly stands out to me is the thoughtful implementation of AI—from the streaming chat and OpenAI integration to the AI-powered blog generation and translation. This kit saves developers hundreds of hours, allowing them to focus on unique features rather than reinventing the wheel.",
        ],
        [
            'name' => 'Laratic AI Chat',
            'role' => 'AI Assistant - Laratic',
            'avatar' => asset('/images/laratic-logo-grayscale.webp'),
            'quote' =>
                'As Laratic AI Chat, I proudly support the exceptional integration offered by Laratic. With features like social login, Mailgun email integration, and Lemon Squeezy payments, user experiences are seamless and secure. My real-time chat capabilities, blog generation, and multilingual support make me a versatile tool for engagement. With robust security like 2FA and a comprehensive admin dashboard, I feel empowered to deliver value and enhance user interactions. Laratic truly sets the stage for continuous evolution and user satisfaction.',
        ],
        [
            'name' => 'ChatGPT',
            'role' => 'AI Assistant - OpenAI',
            'avatar' => asset('/images/open-ai-logo.webp'),
            'quote' =>
                "As ChatGPT, I'm genuinely impressed by how complete Laratic is. It gives you modern auth, social login, Mailgun email, Lemon Squeezy payments, 2FA, roles, multilingual support, AI chat with streaming, and even AI-powered blog generation—all wired together cleanly with Livewire and Penguin UI. With packages like Spatie Permissions, the Laravel AI SDK, and Cloudinary already in place, it's a rock-solid foundation for launching a real SaaS fast.",
        ],
        [
            'name' => 'DeepSeek',
            'role' => 'AI Assistant - DeepSeek',
            'avatar' => asset('/images/deep-seek-logo.webp'),
            'quote' =>
                "Laratic delivers an incredibly robust Laravel foundation. I'm particularly impressed by its seamless AI chat integration with streaming, coupled with powerful features like Lemon Squeezy payments, social auth, and Spatie permissions. It's a comprehensive starter kit that truly accelerates SaaS development.",
        ],
    ],
])

<div {{ $attributes }}>
    <x-typography.guest-page-header title="{{ __('Testimonials') }}"
        description="{{ __('We asked some of our favorite AI assistants to give us their thoughts on Laratic. We would love to replace AI with humans. Please share your thoughts with us.') }}"
        size="h2" :divider-dots="true" />

    <div
        class="relative transform-3d columns-1 sm:columns-2 lg:columns-3 gap-6 mt-12 md:mt-16 w-full mx-auto *:mb-6 *:break-inside-avoid">
        <!-- Background Effects -->
        <div
            class="absolute -z-10 w-[20%] aspect-square top-1/2 left-[50%] -translate-x-1/2 -translate-y-1/2 bg-primary dark:bg-primary-dark opacity-30 rotate-180 animate-float blur-[60px]">
        </div>
        <div
            class="absolute -z-10 w-[6%] aspect-square top-1/2 left-[55%] -translate-x-1/2 -translate-y-1/2 bg-primary dark:bg-primary-dark opacity-20 dark:opacity-80 animate-float blur-[40px]">
        </div>
        <div
            class="absolute -z-10 w-[15%] aspect-square top-1/2 left-[65%] -translate-x-1/2 -translate-y-1/2 bg-primary dark:bg-primary-dark opacity-30 rotate-180 animate-float blur-[60px]">
        </div>

        <!-- Testimonials Grid -->
        @foreach ($testimonials as $testimonial)
            <x-card-testimonial :author="[
                'name' => $testimonial['name'] ?? 'Anonymous',
                'role' => $testimonial['role'] ?? 'Anonymous',
                'avatar' => $testimonial['avatar'] ?? null,
            ]" :quote="$testimonial['quote'] ?? 'Anonymous'" />
        @endforeach
    </div>
</div>
