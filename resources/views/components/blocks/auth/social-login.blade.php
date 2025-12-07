@props([
    'provider' => 'google',
])

@if ($provider === 'google')
    <x-button type="button" variant="alternative" href="{{ route('auth.google.redirect') }}"
        class="w-full"><x-icons.google-logo />{{ __('Continue with Google') }}</x-button>
@endif

@if ($provider === 'github')
    <x-button type="button" variant="alternative" href="{{ route('auth.github.redirect') }}"
        class="w-full"><x-icons.github />{{ __('Continue with GitHub') }}</x-button>
@endif

@if ($provider === 'facebook')
    <x-button type="button" variant="alternative" href="#" class="w-full"><x-icons.facebook
            class="text-blue-600 dark:text-blue-400" />{{ __('Continue with Facebook') }}</x-button>
@endif

@if ($provider === 'twitter')
    <x-button type="button" variant="alternative" href="#" class="w-full"><x-icons.twitter
            class="text-black dark:text-white" />{{ __('Continue with Twitter(X)') }}</x-button>
@endif


@if ($provider === 'linkedin')
    <x-button type="button" variant="alternative" href="#" class="w-full"><x-icons.linkedin
            class="text-blue-600 dark:text-blue-400" />{{ __('Continue with LinkedIn') }}</x-button>
@endif


@if ($provider === 'slack')
    <x-button type="button" variant="alternative" href="#" class="w-full"><x-icons.slack
            class="text-black dark:text-white" />{{ __('Continue with Slack') }}</x-button>
@endif
