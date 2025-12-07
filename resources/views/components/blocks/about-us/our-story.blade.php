<div {{ $attributes }}>
    <!-- Story Container -->
    <div class="mx-auto flex max-w-7xl flex-col items-center justify-center gap-16 text-center md:flex-row md:text-left">
        <!-- Image Section -->
        <div class="relative w-full md:w-1/2">
            <div class="relative">
                <img 
                    src="{{ asset('images/about-us-1.webp') }}"
                    alt="{{ __('Team collaborating in a modern office environment') }}"
                    class="mx-auto w-[70%] grayscale rounded-radius lg:mx-0 lg:mr-auto md:w-[90%]"
                    loading="lazy"
                    decoding="async"
                    width="1200"
                    height="800"
                >
            </div>
            <!-- Background Effects -->
            <div class="hidden lg:block absolute -z-10 w-40 h-40 top-[70%] left-[30%] -translate-x-1/2 -translate-y-1/2 animate-float bg-primary opacity-50 blur-[60px] -rotate-180 dark:bg-primary-dark">
            </div>
            <div class="hidden lg:block absolute -z-10 w-30 h-30 top-1/3 left-[50%] -translate-x-1/2 -translate-y-1/2 animate-float bg-primary opacity-50 blur-[60px] -rotate-180 dark:bg-primary-dark">
            </div>
        </div>

        <!-- Content Section -->
        <div class="my-auto w-full md:w-1/2">
            <h2 class="heading-3">
                {{ __('Our Story') }}
            </h2>
            <p class="mt-8 text-on-surface-muted dark:text-on-surface-dark-muted">
                {{ __(
                    ':app began with a simple vision: to help developers launch their SaaS applications faster by eliminating weeks of boilerplate work. Founded by developers who were tired of rebuilding the same foundation for every project, we saw the need for a comprehensive Laravel starter kit that provides everything needed to get a SaaS up and running quickly.',
                    ['app' => config('app.name')]
                ) }}
            </p>
            <p class="mt-8 text-on-surface-muted dark:text-on-surface-dark-muted">
                {{ __('Built with Laravel and Livewire, :app gives indie hackers, small teams, and agencies a solid foundation to build upon. Our commitment to clean code, modern best practices, and comprehensive features has helped countless developers skip the setup phase and start building real, working SaaS applications from day one. We believe that great ideas shouldn\'t be delayed by infrastructure—they should be brought to life quickly and efficiently.',
                    ['app' => config('app.name')]
                ) }}
            </p>
        </div>
    </div>
</div>
