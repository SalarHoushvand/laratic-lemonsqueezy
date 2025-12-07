@php
    $faqs = [
        [
            'question' => 'What is Laratic?',
            'answer' =>
                'Laratic is a comprehensive Laravel SaaS starter template built with Laravel 12 and Livewire 3. It provides everything you need to launch your SaaS application quickly, including authentication, subscriptions, AI integration, multi-language support, and a beautiful modern UI.',
        ],
        [
            'question' => 'What features are included?',
            'answer' =>
                'Laratic includes authentication (email, phone, social login), subscription management with Paddle, AI-powered features, blog/post system, admin dashboard, two-factor authentication, multi-language support, email notifications, and much more. All built with Laravel 12 and Livewire 3.',
        ],
        [
            'question' => 'Can I customize the template for my needs?',
            'answer' =>
                'Absolutely! Laratic is built with clean, well-documented code following Laravel best practices. You can easily customize every aspect of the application - from the UI components to the business logic. All code is yours to modify and extend.',
        ],

        [
            'question' => 'Is there documentation and support available?',
            'answer' =>
                'Yes! Laratic includes comprehensive documentation covering setup, customization, and deployment. We also provide email support to help you get started and answer any questions you may have during development.',
        ],

        [
            'question' => 'Can I use this for commercial projects?',
            'answer' =>
                'Yes! Once you purchase Laratic, you can use it for unlimited commercial projects. There are no ongoing royalties or revenue sharing - you own the code completely and can build as many SaaS applications as you want.',
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
                    <x-icons.question-mark-circle variant="micro" size="md" class="shrink-0 text-primary dark:text-primary-dark" />
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
