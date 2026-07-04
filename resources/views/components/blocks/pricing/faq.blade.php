@php
    $faqs = [
        [
            'question' => 'What is Laratic?',
            'answer' =>
                'Laratic is a comprehensive Laravel SaaS starter kit built with Laravel and Livewire. It provides everything you need to launch your SaaS application quickly, including authentication, subscriptions, AI integration, multi-language support, and a beautiful modern UI.',
        ],
        [
            'question' => 'What features are included?',
            'answer' =>
                'Laratic includes authentication (email, social login), subscription management with Lemon Squeezy, AI-powered features, blog/post system, admin dashboard, two-factor authentication, multi-language support, email notifications, and much more.',
        ],
        [
            'question' => 'Can I customize the template for my needs?',
            'answer' =>
                'Absolutely! Laratic is built with clean, well-documented code following Laravel best practices. You can easily customize every aspect of the application - from the UI components to the business logic. All code is yours to modify and extend.',
        ],
        [
            'question' => 'Is there documentation and support available?',
            'answer' =>
                'Yes! Laratic includes comprehensive documentation at laratickit.com covering setup, customization, and deployment. You can also open GitHub issues for bugs and questions.',
        ],
        [
            'question' => 'Can I use this for commercial projects?',
            'answer' =>
                'Yes! Laratic is released under the MIT license. You can use it for unlimited commercial projects with no ongoing royalties or revenue sharing.',
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
