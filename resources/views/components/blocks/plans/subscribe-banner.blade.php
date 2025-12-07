<x-banner variant="primary" :isDismissible="true" button="Subscribe" href="{{ route('plans.start') }}" >
    {{ __('Subscribe to get full access to all :app features', ['app' => config('app.name')]) }}
</x-banner>
