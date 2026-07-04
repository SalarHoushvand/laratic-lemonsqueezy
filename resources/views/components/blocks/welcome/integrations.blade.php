<div {{ $attributes->merge(['class' => 'p-0 md:p-8']) }}>
    <x-typography.guest-page-header
        title="{{ __('Seamless Integrations') }}"
        description="{{ __('Laratic includes a handfull of very useful integrations to get you started.') }}"
        size="h2"
        :divider-dots="true" />

    <div class="relative mx-auto w-full max-w-5xl mt-12">
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 md:gap-6">
            @foreach ([
        'github' => ['name' => 'GitHub', 'url' => 'https://github.com'],
        'google' => ['name' => 'Google', 'url' => 'https://cloud.google.com'],
        'open-ai' => ['name' => 'OpenAI', 'url' => 'https://openai.com'],
        'mailgun' => ['name' => 'Mailgun', 'url' => 'https://www.mailgun.com'],
        'mailchimp' => ['name' => 'Mailchimp', 'url' => 'https://mailchimp.com'],
        'lemon-squeezy' => ['name' => 'Lemon Squeezy', 'url' => 'https://www.lemonsqueezy.com'],
        'penguin' => ['name' => 'Penguin UI', 'url' => 'https://penguinui.com'],
    ] as $logo => $data)
                <a href="{{ $data['url'] }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="group relative flex flex-col items-center justify-center p-3 md:p-6 pb-6 md:pb-8 bg-surface-alt/20 dark:bg-surface-dark-alt/10 rounded-radius backdrop-blur-md border border-outline dark:border-outline-dark hover:border-primary dark:hover:border-primary-dark transition-all duration-300 hover:scale-105">
                    <img src="{{ asset("images/integrations/{$logo}-logo-light.webp") }}"
                        alt="{{ $data['name'] }}"
                        class="w-full dark:hidden block h-auto max-h-6 md:max-h-10 lg:max-h-12 object-contain opacity-90 group-hover:opacity-100 transition-opacity duration-300"
                        loading="lazy"
                        decoding="async">
                    <img src="{{ asset("images/integrations/{$logo}-logo-dark.webp") }}"
                        alt="{{ $data['name'] }}"
                        class="w-full hidden dark:block h-auto max-h-6 md:max-h-10 lg:max-h-12 object-contain opacity-90 group-hover:opacity-100 transition-opacity duration-300"
                        loading="lazy"
                        decoding="async">
                    <span class="absolute bottom-2 md:bottom-3 left-1/2 -translate-x-1/2 text-xs text-on-surface-muted dark:text-on-surface-dark-muted opacity-100 md:opacity-0 md:group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                        {{ $data['name'] }}
                    </span>
                </a>
            @endforeach
        </div>

        <div class="absolute rounded-full -z-10 size-1/2 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-primary dark:bg-primary-dark opacity-15 dark:opacity-15 blur-[60px]"
            aria-hidden="true">
        </div>
    </div>
</div>
{{-- / Hero --}}
