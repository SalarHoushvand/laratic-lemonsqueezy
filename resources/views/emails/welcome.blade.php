<x-mail::message>
# {{ __('Welcome to :app!', ['app' => config('app.name')]) }}

{{ __('Hi :name,', ['name' => $user->name]) }}

{{ __('Thank you for joining us! We\'re excited to have you on board.') }}

{{ __('Your account has been successfully created and you can now start using all the features we have to offer.') }}

<x-mail::button :url="route('dashboard', absolute: true)" color="primary">
{{ __('Go to Dashboard') }}
</x-mail::button>

{{ __('If you have any questions or need assistance, feel free to reach out to our support team.') }}

{{ __('Best regards') }},<br>
{{ config('app.name') }} {{ __('Team') }}
</x-mail::message>

