@push('head')
    <title>Privacy Policy - Laratic</title>
    <meta name="description"
        content="Learn how Laratic protects your personal data. Our privacy policy outlines the collection, use, and security of your information to ensure your data privacy and protection.">
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
                <x-typography.guest-page-header size="h1" title="{{ __('Privacy Policy') }}"
                    description="{{ __('Learn how we protect your personal data and ensure your privacy when using our platform.') }}" />
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
                        At {{ config('app.name') }}, we deeply value your privacy and are fully committed to ensuring
                        the protection of your
                        personal data. This privacy policy outlines in detail how we collect, use, and safeguard the
                        information
                        you provide when utilizing our services. By using {{ config('app.name') }}, you agree to the
                        terms outlined here, and we
                        encourage you to review this policy regularly to stay informed about how we are protecting your
                        data.
                    </p>
                </section>

                <!-- Information We Collect -->
                <section class="border-outline dark:border-outline-dark pt-8">
                    <h2 class="heading-4 mb-4 text-on-surface-strong dark:text-on-surface-dark">Information We Collect
                    </h2>
                    <p class="text-sm text-on-surface-muted dark:text-on-surface-dark-muted">
                        We may collect personal information that you voluntarily provide, such as your name, email
                        address,
                        payment details, and other information required for account creation and service usage.
                        Additionally, we
                        collect usage data and technical information, such as IP addresses and browser type, to help
                        improve
                        your experience on our platform. This data collection enables us to better understand how our
                        services
                        are used and how we can optimize them to meet your needs.
                    </p>
                </section>

                <!-- How We Use Your Information -->
                <section class="border-outline dark:border-outline-dark pt-8">
                    <h2 class="heading-4 mb-4 text-on-surface-strong dark:text-on-surface-dark">How We Use Your
                        Information</h2>
                    <p class="text-sm text-on-surface-muted dark:text-on-surface-dark-muted">
                        The information we collect is used primarily to provide, maintain, and improve our services.
                        Your
                        personal data helps us process transactions, communicate important updates, and ensure the
                        security of
                        your account. We may also use this information for customer support purposes, to respond to
                        inquiries,
                        and to personalize your experience by tailoring our offerings to your preferences. Rest assured,
                        we are
                        committed to using your data responsibly and transparently.
                    </p>
                </section>

                <!-- Data Protection -->
                <section class="border-outline dark:border-outline-dark pt-8">
                    <h2 class="heading-4 mb-4 text-on-surface-strong dark:text-on-surface-dark">Data Protection</h2>
                    <p class="text-sm text-on-surface-muted dark:text-on-surface-dark-muted">
                        At {{ config('app.name') }}, we take the protection of your personal data seriously. We employ
                        industry-standard security
                        measures, including encryption and secure storage systems, to safeguard your information from
                        unauthorized access, disclosure, alteration, or misuse. We regularly review and update our
                        security
                        protocols to ensure that your data remains safe as technology evolves. Your trust is important
                        to us,
                        and we strive to maintain a secure environment for all your interactions with our platform.
                    </p>
                </section>

                <!-- Third-Party Sharing -->
                <section class="border-outline dark:border-outline-dark pt-8">
                    <h2 class="heading-4 mb-4 text-on-surface-strong dark:text-on-surface-dark">Third-Party Sharing</h2>
                    <p class="text-sm text-on-surface-muted dark:text-on-surface-dark-muted">
                        We do not sell or share your personal information with third parties for marketing purposes.
                        However, we
                        may share data with trusted service providers that assist us in operating our platform, such as
                        payment
                        processors, hosting providers, and analytics tools. These third parties are bound by strict
                        confidentiality agreements and are required to adhere to the same data protection standards that
                        we
                        uphold. We only share the necessary information to fulfill specific functions and ensure that
                        your data
                        remains protected at all times.
                    </p>
                </section>

                <!-- Your Rights -->
                <section class="border-outline dark:border-outline-dark pt-8">
                    <h2 class="heading-4 mb-4 text-on-surface-strong dark:text-on-surface-dark">Your Rights</h2>
                    <p class="text-sm text-on-surface-muted dark:text-on-surface-dark-muted">
                        As a user of {{ config('app.name') }}, you have the right to access, update, or request the
                        deletion of your personal
                        data at any time. If you wish to make changes to your account information or have concerns about
                        how
                        your data is being handled, please reach out to us at <a href="mailto:privacy@laratic.com"
                            class="link">privacy@laratic.com</a>. We are committed to
                        responding promptly to your requests and ensuring that you have full control over your personal
                        information. Additionally, we comply with all relevant data protection regulations to guarantee
                        your
                        rights are respected.
                    </p>
                </section>

                <!-- Changes to This Policy -->
                <section class="border-outline dark:border-outline-dark pt-8">
                    <h2 class="heading-4 mb-4 text-on-surface-strong dark:text-on-surface-dark">Changes to This Policy
                    </h2>
                    <p class="text-sm text-on-surface-muted dark:text-on-surface-dark-muted">
                        We may update this privacy policy from time to time to reflect changes in our practices,
                        technology, or
                        legal requirements. Any significant changes will be communicated through our website or directly
                        via
                        email. We encourage you to review this policy periodically to stay informed about how we are
                        protecting
                        your data and ensuring transparency in our privacy practices.
                    </p>
                </section>

                <!-- Contact Us -->
                <section class="border-outline dark:border-outline-dark pt-8">
                    <h2 class="heading-4 mb-4 text-on-surface-strong dark:text-on-surface-dark">Contact Us</h2>
                    <p class="text-sm text-on-surface-muted dark:text-on-surface-dark-muted">
                        If you have any questions or concerns regarding this privacy policy or the handling of your
                        personal
                        information, please do not hesitate to contact us at <a href="mailto:privacy@laratic.com"
                            class="link">privacy@laratic.com</a>. We are here to assist you and
                        address any issues you may have regarding your privacy or data protection.
                    </p>
                </section>
            </div>
        </div>
    </div>
</x-layouts.guest>
