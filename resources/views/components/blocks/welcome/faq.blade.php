@php
    $faqs = [
        [
            'question' => 'What is Laratic?',
            'answer' =>
                'Laratic is a comprehensive Laravel SaaS starter kit built with Laravel, Livewire, Tailwind CSS, Alpine.js, and Penguin UI. It gives you most of the tools and features you need to launch a SaaS application quickly.',
        ],
        [
            'question' => 'What features are included?',
            'answer' =>
                'Laratic includes authentication (email, password, social login), two-factor authentication, subscription and one-time payment management, an admin dashboard, AI-powered chat and content tools, a full blog/post system, multi-language support, email notifications, and a beautiful UI built with Penguin UI components.',
        ],
        [
            'question' => 'Who is Laratic for?',
            'answer' =>
                'Laratic is built for indie hackers, small teams, and agencies who want to ship a polished SaaS quickly without rebuilding the same foundation every time. If you are comfortable with Laravel and want to skip weeks of setup work, Laratic is for you.',
        ],
        [
            'question' => 'How is Laratic different from just using Laravel directly?',
            'answer' =>
                'With plain Laravel, you start from a blank canvas and need to wire up authentication, billing, dashboards, emails, blog, translations, AI, and UI by yourself. Laratic gives you all of this out of the box, with clean architecture and ready-made screens. Instead of spending months on boilerplate, you can start by editing real, working SaaS code on day one.',
        ],
        [
            'question' => 'Can I customize the template for my needs?',
            'answer' =>
                'Absolutely. Laratic is built with clean, well-structured code that you are encouraged to modify. You can customize everything from UI components and layouts to routes, models, and business logic. Think of it as a strong starting point, not a closed system.',
        ],
        [
            'question' => 'Can I use Laratic for client projects?',
            'answer' =>
                'Yes. Laratic is released under the MIT license. You can use it to build SaaS products or platforms for your clients, modify it freely, and ship commercial applications.',
        ],
        [
            'question' => 'Can I use Laratic for multiple projects?',
            'answer' =>
                'Yes. You can use Laratic as a starting point for multiple SaaS projects you build for yourself or your clients, as long as you respect the MIT license.',
        ],
        [
            'question' => 'Can I use Laratic in open source projects?',
            'answer' =>
                'Yes. Laratic is open source under the MIT license. You can fork it, contribute back, and use it as the foundation for your own open source or commercial projects.',
        ],
        [
            'question' => 'How often is Laratic updated?',
            'answer' =>
                'We try our best to keep Laratic updated with the most recent stable versions of the underlying tools and dependencies. Clone or pull the latest from GitHub to get updates, and customize dependencies as your project evolves.',
        ],
        [
            'question' => 'How can I get support?',
            'answer' =>
                'Check the documentation at laratickit.com, open a GitHub issue for bugs or questions, or reach out via email. Community contributions are welcome.',
        ],
    ];
@endphp


<!-- FAQ Section -->
<div {{ $attributes->merge(['class' => 'flex flex-col']) }}>
    <!-- Section Header -->
    <x-typography.guest-page-header size="h2" class="mb-8" title="{{ __('Frequently Asked Questions') }}"
        description="{{ __('Frequently asked questions about Laratic.') }}" />

    <!-- FAQ List -->
    <div class="flex w-full flex-col gap-4 text-on-surface dark:text-on-surface-dark">
        @foreach ($faqs as $faq)
            <x-accordion>
                <x-slot:header>
                    <div class="flex items-center gap-2">
                        <x-icons.question-mark-circle variant="micro" size="md"
                            class="shrink-0 text-primary dark:text-primary-dark" />
                        {{ __($faq['question'], ['app' => config('app.name')]) }}
                    </div>
                </x-slot>

                <x-slot:content>
                    {{ __($faq['answer'], ['app' => config('app.name')]) }}
                </x-slot>
            </x-accordion>
        @endforeach
    </div>
</div>
