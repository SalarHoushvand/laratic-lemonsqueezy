<x-mail::message>
# {{ __('New Contact Request') }}

{{ __('You have received a new contact request from :name.', ['name' => $data['name']]) }}

**{{ __('Details') }}:**
- {{ __('Name') }}: {{ $data['name'] }}
- {{ __('Email') }}: {{ $data['email'] }}
@if(!empty($data['phone']))
- {{ __('Phone') }}: {{ $data['phone'] }}
@endif
- {{ __('Country') }}: {{ $data['country'] }}

@if(!empty($data['message']))
**{{ __('Message') }}:**
{{ $data['message'] }}
@endif

**{{ __('Consent Information') }}:**
- {{ __('Data Processing') }}: {{ __('Yes') }}
@if(!empty($data['phone_consent']))
- {{ __('Phone Contact') }}: {{ __('Yes') }}
@endif
@if(!empty($data['marketing_consent']))
- {{ __('Marketing') }}: {{ __('Yes') }}
@endif

<x-mail::button :url="config('app.url')">
{{ __('View in Dashboard') }}
</x-mail::button>

{{ __('Thanks') }},<br>
{{ config('app.name') }}
</x-mail::message> 