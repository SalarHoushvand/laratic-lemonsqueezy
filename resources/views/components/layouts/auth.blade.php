<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scheme-light dark:scheme-dark font-body" data-theme="{{ config('app.theme') }}">

<head>
    @include('partials.head')
    @stack('head')
    @livewireStyles
</head>

<body class="min-h-screen antialiased bg-surface dark:bg-surface-dark text-on-surface dark:text-on-surface-dark">
    <!-- Polka dot background -->
    <div class="hidden dark:block absolute inset-0 -z-10 bg-pattern pointer-events-none opacity-6!" aria-hidden="true"></div>
    <!-- Main Container -->
    <div
        class="relative grid h-dvh flex-col items-center justify-center px-16 sm:px-0 lg:max-w-none grid-cols-1 lg:grid-cols-[55%_45%] lg:px-0">
        <!-- Left Side Content -->
        <div class="w-full lg:p-8">
            <div class="mx-auto flex w-full flex-col justify-center space-y-6 sm:w-[400px]">

                <a href="{{ route('home') }}" class="mx-auto">
                    <x-app-logo class="w-32" />
                </a>

                <!-- Main Content -->
                {{ $slot }}
            </div>
        </div>

        <!-- Right Side Panel -->
        <div class="relative hidden h-full flex-col bg-primary lg:flex dark:bg-surface-primary-dark">
            <div class="flex flex-col justify-between h-full p-6">
                <x-card-testimonial class="mx-auto my-auto text-base!" :author="[
                    'name' => 'Gemini',
                    'role' => 'AI Assistant - Google',
                    'avatar' => asset('/images/gemini-logo.webp'),
                ]" :quote="'As Gemini, I analyze codebases for efficiency and capability, and Laratic is truly impressive. It doesn\'t just provide boilerplate; it delivers a comprehensive,
                                modern SaaS foundation. 
                                The integration of essential features like payments, multi-factor authentication, and user management is seamless. What particularly stands out to me is the thoughtful implementation of AI. From the streaming chat and OpenAI integration to the AI-powered blog generation and translation. This kit saves developers hundreds of hours.'" />
            </div>
        </div>
    </div>
    <x-notification />
    @include('partials.scripts')
    @livewireScripts
</body>

</html>
