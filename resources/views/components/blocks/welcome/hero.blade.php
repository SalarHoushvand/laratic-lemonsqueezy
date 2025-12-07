<!-- Main Content -->
<div class="mx-auto">
    <div class="absolute -z-10 -top-20 left-1/2 h-40 w-80 -translate-x-1/2 rounded-full bg-primary opacity-30 blur-[60px] dark:bg-primary-dark"
        aria-hidden="true"></div>
    <!-- Content -->
    <div class="mx-auto flex flex-col items-center text-center gap-6 w-full max-w-3xl pt-16">
        <x-badge class="rounded-full!" size="xs">
            <x-icons.clock variant="micro" size="sm" class="text-primary dark:text-primary-dark" />
            <span>{{ __('Save Months of Development Time') }}</span>
        </x-badge>
        <!-- Heading -->
        <h1 class="heading-1 text-balance">
            {{ __('Build your') }} <span class="text-primary dark:text-primary-dark">{{ __('Laravel Apps') }}</span>
            {{ __('Fast and ship them faster') }} <br>
        </h1>
        <!-- Description -->
        <p class="max-w-md text-on-surface-muted dark:text-on-surface-dark-muted">
            {{ __('All-in-one Laravel starter kit for SaaS applications') }}
        </p>
        <!-- CTA Buttons -->
        <div class="flex items-center gap-4">
            <x-button href="{{ route('login') }}" size="md">
                {{ __('Let\'s Go') }}
            </x-button>
            <x-button href="#" variant="alternative" size="md">
                {{ __('Explore Features') }}
            </x-button>
        </div>
    </div>
</div>
