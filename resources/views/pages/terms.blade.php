@push('head')
    <title>Terms of Service - Laratic</title>
    <meta name="description"
        content="Read Laratic's Terms of Service to understand your rights and responsibilities when using our platform. These terms outline the rules, guidelines, and policies that govern your use of our services.">
@endpush
<x-layouts.guest>
    <div class="px-6">
        <!-- Polka dot background -->
        <div class="hidden dark:block absolute inset-0 -z-10 bg-pattern pointer-events-none" aria-hidden="true"></div>
        <!-- Background Blur Effect -->
        <div class="absolute -z-10 -top-20 left-1/2 h-40 w-80 -translate-x-1/2 rounded-full bg-primary opacity-30 blur-[60px] dark:bg-primary-dark"
            aria-hidden="true"></div>

        <div class="max-w-4xl mx-auto py-12 md:py-16">
            <!-- Header Section -->
            <div class="mb-12">
                <x-typography.guest-page-header size="h1" title="{{ __('Terms of Service') }}"
                    description="{{ __('Read our Terms of Service to understand your rights and responsibilities when using our platform.') }}" />
                <div class="mt-6 text-center">
                    <p class="text-sm text-on-surface-muted dark:text-on-surface-dark-muted">
                        Last Updated: September 2024
                    </p>
                </div>
            </div>

            <!-- Content Section -->
            <div class="flex flex-col gap-4">
                <!-- Introduction -->
                <section>
                    <p class="text-sm text-on-surface-muted dark:text-on-surface-dark-muted">
                        Welcome to {{ config('app.name') }}. By accessing or using our services, you agree to be bound by these Terms of Service ("Terms"). Please read these Terms carefully before using our platform. If you do not agree with any part of these terms, you may not use our services.
                    </p>
                </section>

                <!-- Account Registration -->
                <section class="pt-8">
                    <h2 class="heading-4 mb-4 text-on-surface-strong dark:text-on-surface-dark">Account Registration</h2>
                    <p class="text-sm text-on-surface-muted dark:text-on-surface-dark-muted leading-relaxed">
                        To access certain features of our platform, you must create an account. You agree to provide accurate, current, and complete information during registration and to update such information to keep it accurate, current, and complete. You are responsible for safeguarding your account credentials and for any activities or actions under your account.
                    </p>
                </section>

                <!-- Acceptable Use -->
                <section class="pt-8">
                    <h2 class="heading-4 mb-4 text-on-surface-strong dark:text-on-surface-dark">Acceptable Use</h2>
                    <p class="text-sm text-on-surface-muted dark:text-on-surface-dark-muted leading-relaxed">
                        When using our services, you agree not to: (a) violate any applicable laws or regulations; (b) infringe upon the rights of others; (c) attempt to gain unauthorized access to our systems or other users' accounts; (d) transmit any malicious code or harmful content; (e) interfere with the proper functioning of our platform; or (f) engage in any activity that could damage, disable, or impair our services.
                    </p>
                </section>

                <!-- Intellectual Property -->
                <section class="pt-8">
                    <h2 class="heading-4 mb-4 text-on-surface-strong dark:text-on-surface-dark">Intellectual Property</h2>
                    <p class="text-sm text-on-surface-muted dark:text-on-surface-dark-muted leading-relaxed">
                        All content, features, and functionality of our platform, including but not limited to text, graphics, logos, button icons, images, and software, are the exclusive property of {{ config('app.name') }} or its licensors and are protected by intellectual property laws. You may not copy, modify, distribute, sell, or lease any part of our services without our explicit permission.
                    </p>
                </section>

                <!-- Payment Terms -->
                <section class="pt-8">
                    <h2 class="heading-4 mb-4 text-on-surface-strong dark:text-on-surface-dark">Subscriptions and Payments</h2>
                    <p class="text-sm text-on-surface-muted dark:text-on-surface-dark-muted leading-relaxed">
                        If you subscribe to any paid plans or purchase products through our platform, you agree to pay all fees in accordance with the pricing and payment terms presented to you. Refund policies, if any, are described at the time of purchase. We reserve the right to modify our pricing with reasonable notice. Continued use of our services after a price change constitutes acceptance of the new pricing.
                    </p>
                </section>

                <!-- Limitation of Liability -->
                <section class="pt-8">
                    <h2 class="heading-4 mb-4 text-on-surface-strong dark:text-on-surface-dark">Limitation of Liability</h2>
                    <p class="text-sm text-on-surface-muted dark:text-on-surface-dark-muted leading-relaxed">
                        To the maximum extent permitted by law, {{ config('app.name') }} shall not be liable for any indirect, incidental, special, consequential, or punitive damages, or any loss of profits or revenues, whether incurred directly or indirectly, or any loss of data, use, goodwill, or other intangible losses resulting from your use or inability to use our services.
                    </p>
                </section>

                <!-- Termination -->
                <section class="pt-8">
                    <h2 class="heading-4 mb-4 text-on-surface-strong dark:text-on-surface-dark">Termination</h2>
                    <p class="text-sm text-on-surface-muted dark:text-on-surface-dark-muted leading-relaxed">
                        We reserve the right to suspend or terminate your access to our services, with or without notice, for any violation of these Terms, or for any other reason we deem appropriate. Upon termination, your right to use our services will immediately cease, and you must cease all use of our platform.
                    </p>
                </section>

                <!-- Changes to Terms -->
                <section class="pt-8">
                    <h2 class="heading-4 mb-4 text-on-surface-strong dark:text-on-surface-dark">Changes to Terms</h2>
                    <p class="text-sm text-on-surface-muted dark:text-on-surface-dark-muted leading-relaxed">
                        We may modify these Terms at any time by posting the revised version on our website. Your continued use of our services after the effective date of any modifications constitutes your acceptance of the modified Terms. We will make reasonable efforts to notify you of any material changes.
                    </p>
                </section>

                <!-- Contact Us -->
                <section class="pt-8">
                    <h2 class="heading-4 mb-4 text-on-surface-strong dark:text-on-surface-dark">Contact Us</h2>
                    <p class="text-sm text-on-surface-muted dark:text-on-surface-dark-muted leading-relaxed">
                        If you have any questions about these Terms of Service, please contact us at <a href="mailto:legal@laratic.com" class="link">legal@laratic.com</a>. We are committed to addressing any concerns you may have about our terms and conditions.
                    </p>
                </section>
            </div>
        </div>
    </div>
</x-layouts.guest>
