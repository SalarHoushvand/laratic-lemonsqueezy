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
                'Yes. You can use Laratic to build SaaS products or platforms for your clients. As long as each client project is a custom implementation and you are not reselling Laratic itself as a competing starter kit, agency and freelance use is allowed.',
        ],
        [
            'question' => 'Can I use Laratic for multiple projects?',
            'answer' =>
                'Yes. One purchase allows you to use Laratic as a starting point for multiple SaaS projects you build for yourself or your clients, as long as you respect the license and do not redistribute Laratic as a standalone product or boilerplate.',
        ],
        [
            'question' => 'Can I use Laratic in open source projects?',
            'answer' =>
                'You can use Laratic as the base for your own application, but you should not open source a project that exposes Laratic as a reusable starter kit or template. If you want to open source a project built with Laratic, make sure the primary value is your application and not Laratic itself bundled as a boilerplate.',
        ],

        [
            'question' => 'How often is Laratic updated?',
            'answer' =>
                'We try our best to keep Laratic updated with the most recent stable versions of the underlying tools and dependencies. When you purchase Laratic, you get the full codebase and you own that code, similar to Laravel’s official starter kits. From there, it is up to you to add, remove, or update dependencies as your project evolves.',
        ],
        [
            'question' => 'Why is Laratic cheaper than most starter kits?',
            'answer' =>
                'Our goal is to make Laratic affordable for indie hackers and solo developers so they can kick off their projects without a huge upfront cost. We priced it in a way that makes financial sense for them, not because it offers less value. You still get a complete, production-ready Laravel SaaS foundation.',
        ],
        [
            'question' => 'Can I get a refund if it does not fit my needs?',
            'answer' =>
                'Because of the digital nature of the product and the fact that you receive the full source code, we do not offer refunds. Please review the feature list, documentation, and screenshots before purchasing to make sure Laratic is a good fit for your project.',
        ],
        [
            'question' => 'How can I get support?',
            'answer' =>
                'We offer email support to all our customers. You can reach out to us and we will do our best to help you. You can also check the documentation and the changelog for more information.',
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
