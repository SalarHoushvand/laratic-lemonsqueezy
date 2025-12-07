<footer
    class="relative overflow-hidden p-16 border-t border-outline dark:border-outline-dark bg-surface-alt dark:bg-surface-dark-alt/50 backdrop-blur-md">
    <!-- Dark mode background effect -->
    <div
        class="absolute -z-10 hidden w-60 h-40 -bottom-30 left-1/2 -translate-x-1/2 rounded-full bg-primary-dark opacity-40 blur-[70px] dark:block">
    </div>

    <div class="mx-auto grid max-w-7xl grid-cols-1 gap-8 px-6 md:grid-cols-12 md:gap-16">
        <!-- Brand section -->
        <div class="col-span-1 md:col-span-6">
            <a href="{{ route('home') }}" class="block w-fit">
                <x-app-logo class="w-24" />
                <span class="sr-only">{{ __('Home') }}</span>
            </a>

            <p class="mt-4 max-w-md text-sm text-on-surface-muted dark:text-on-surface-dark-muted">
                {{ __('The all-in-one platform that simplifies workflows, boosts productivity, and helps you scale effortlessly') }}
            </p>

            <!-- Social Links -->
            <div class="mt-4 flex items-center gap-8">
                <a href="https://x.com" target="_blank"
                    class="text-on-surface transition-colors hover:text-primary dark:text-on-surface-dark dark:hover:text-primary-dark">
                    <x-icons.twitter size="sm" />
                    <span class="sr-only">{{ __('Twitter/X') }}</span>
                </a>

                <a href="https://facebook.com" target="_blank"
                    class="text-on-surface transition-colors hover:text-primary dark:text-on-surface-dark dark:hover:text-primary-dark">
                    <x-icons.facebook size="sm" />
                    <span class="sr-only">{{ __('Facebook') }}</span>
                </a>

                <a href="https://instagram.com" target="_blank"
                    class="text-on-surface transition-colors hover:text-primary dark:text-on-surface-dark dark:hover:text-primary-dark">
                    <x-icons.instagram size="sm" />
                    <span class="sr-only">{{ __('Instagram') }}</span>
                </a>

                <a href="https://discord.com" target="_blank"
                    class="text-on-surface transition-colors hover:text-primary dark:text-on-surface-dark dark:hover:text-primary-dark">
                    <x-icons.discord size="sm" />
                    <span class="sr-only">{{ __('Discord') }}</span>
                </a>
            </div>
           
            <x-theme-preference-toggle class="mt-8 mb-4" />
        </div>

        <!-- Company links -->
        <div class="col-span-1 flex flex-col gap-4 md:col-span-2">
            <p class="font-bold">{{ __('Company') }}</p>
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('about-us') }}"
                        class="text-on-surface transition-colors hover:text-primary dark:text-on-surface-dark dark:hover:text-primary-dark">
                        {{ __('About Us') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('contact') }}"
                        class="text-on-surface transition-colors hover:text-primary dark:text-on-surface-dark dark:hover:text-primary-dark">
                        {{ __('Contact Us') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('pricing') }}"
                        class="text-on-surface transition-colors hover:text-primary dark:text-on-surface-dark dark:hover:text-primary-dark">
                        {{ __('Pricing') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('careers') }}"
                        class="text-on-surface transition-colors hover:text-primary dark:text-on-surface-dark dark:hover:text-primary-dark">
                        {{ __('Careers') }}
                    </a>
                </li>
            </ul>
        </div>

        <!-- Resources links -->
        <div class="col-span-1 flex flex-col gap-4 md:col-span-2">
            <p class="font-bold">{{ __('Resources') }}</p>
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('request-demo') }}"
                        class="text-on-surface transition-colors hover:text-primary dark:text-on-surface-dark dark:hover:text-primary-dark">
                        {{ __('Request a Demo') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('blog') }}"
                        class="text-on-surface transition-colors hover:text-primary dark:text-on-surface-dark dark:hover:text-primary-dark">
                        {{ __('Blog') }}
                    </a>
                </li>
            </ul>
        </div>

        <!-- Legal links -->
        <div class="col-span-1 flex flex-col gap-4 md:col-span-2">
            <p class="font-bold">{{ __('Legal') }}</p>
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('terms') }}"
                        class="text-on-surface transition-colors hover:text-primary dark:text-on-surface-dark dark:hover:text-primary-dark">
                        {{ __('Terms') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('privacy') }}"
                        class="text-on-surface transition-colors hover:text-primary dark:text-on-surface-dark dark:hover:text-primary-dark">
                        {{ __('Privacy') }}
                    </a>
                </li>
            </ul>
        </div>
    </div>
</footer>
