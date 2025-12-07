@push('head')
    <title>Changelog - {{ config('app.name') }}</title>
    <meta name="description" content="View the complete changelog and version history for {{ config('app.name') }}.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'Changelog', 'url' => '#']]">

    <h1>Changelog</h1>
    <p class="text-on-surface-muted dark:text-on-surface-dark-muted">
        Track all notable changes, improvements, and updates to {{ config('app.name') }}.
    </p>

    <div class="mt-6 space-y-12">
        {{-- Version 1.2.0 --}}
        <x-blocks.docs.changelog-section 
        :title="now()->subDays(7)->format('F j, Y')" version="1.2.0" github="#">
            <x-slot:new>
                <ul class="space-y-1.5 text-sm">
                    <li>Enhanced admin dashboard with new revenue analytics widget</li>
                    <li>Real-time notification system with toast alerts</li>
                    <li>Advanced filtering options for blog posts and products</li>
                </ul>
                <img src="{{ asset('images/admin-dashboard-dark.webp') }}" alt="Enhanced Admin Dashboard" class="w-full border-0!" />
                <div
                    class="p-3 bg-surface-container-low dark:bg-surface-container-low-dark text-sm text-on-surface-weak dark:text-on-surface-dark-weak">
                    New admin dashboard with improved analytics and user insights
                </div>
            </x-slot:new>
            <x-slot:changed>
                <ul class="space-y-1.5 text-sm">
                    <li>Resolved issue with dark mode toggle persistence</li>
                    <li>Fixed pagination on mobile devices</li>
                </ul>
            </x-slot:changed>
            <x-slot:fixed>
                <ul class="space-y-1.5 text-sm">
                    <li>Resolved issue with dark mode toggle persistence</li>
                    <li>Fixed pagination on mobile devices</li>
                </ul>
            </x-slot:fixed>
        </x-blocks.docs.changelog-section>

        {{-- Version 1.1.0 --}}
        <x-blocks.docs.changelog-section :title="now()->addDays(7)->format('F j, Y')" version="1.1.0" github="#">
            <x-slot:new>
                    <ul class="space-y-1.5 text-sm">
                        <li>New reusable notification component for Livewire</li>
                        <li>Enhanced form validation with real-time feedback</li>
                        <li>API rate limiting for AI endpoints</li>
                    </ul>

                    <div class="mt-4">
                        <p class="text-sm mb-2">Example of the new notification component:</p>
                        <pre class="bg-surface-container-low dark:bg-surface-container-low-dark p-4 rounded-lg overflow-x-auto text-sm"><code class="language-php">// In your Livewire component
use Livewire\Component;

class UserProfile extends Component
{
    public function updateProfile()
    {
        // Validation logic...
        
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Profile updated successfully!'
        ]);
    }
}</code></pre>
                    </div>
            </x-slot:new>
            <x-slot:changed>
                    <ul class="space-y-1.5 text-sm">
                        <li>Refactored authentication middleware for better performance</li>
                        <li>Updated AI token usage tracking algorithm</li>
                    </ul>
            </x-slot:changed>
            <x-slot:fixed>
                    <ul class="space-y-1.5 text-sm">
                        <li>Fixed memory leak in AI streaming responses</li>
                        <li>Corrected timezone handling in user settings</li>
                    </ul>
            </x-slot:fixed>
        </x-blocks.docs.changelog-section>

        {{-- Version 1.0.0 --}}
        <x-blocks.docs.changelog-section :title="now()->format('F j, Y')" version="1.0.0" github="#">
            <x-slot:new>
                    <ul class="space-y-1.5 text-sm">
                        <li>Initial release of {{ config('app.name') }}</li>
                        <li>Complete user authentication and authorization system with role-based access control</li>
                        <li>Blog management platform with AI-powered content generation capabilities</li>
                        <li>Comprehensive admin dashboard with real-time analytics and reporting</li>
                        <li>Cookie consent banner with integrated Google Analytics support</li>
                        <li>Newsletter subscription and management system</li>
                        <li>Social authentication via Google and GitHub providers</li>
                        <li>Multi-language support with seamless translation system</li>
                        <li>Full-featured product catalog and order management</li>
                        <li>Interactive AI chat with streaming response capabilities</li>
                    </ul>
            </x-slot:new>
            <x-slot:changed>
                    <ul class="space-y-1.5 text-sm">
                        <li>First stable release - no previous versions</li>
                    </ul>
            </x-slot:changed>
            <x-slot:fixed>
                    <ul class="space-y-1.5 text-sm">
                        <li>Initial release - no bug fixes yet</li>
                    </ul>
            </x-slot:fixed>
        </x-blocks.docs.changelog-section>
    </div>

</x-layouts.docs>
