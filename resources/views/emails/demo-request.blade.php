<x-mail::message>
# {{ __('New Demo Request Received') }}

{{ __('You have received a new demo request. Please review the details below and follow up promptly.') }}

<x-mail::panel>
## {{ __('Contact Information') }}

**{{ __('Name') }}**  
{{ $data['name'] }}

**{{ __('Email Address') }}**  
{{ $data['email'] }}

**{{ __('Company Size') }}**  
{{ $data['company_size'] }}

**{{ __('Country') }}**  
{{ $data['country'] }}
</x-mail::panel>

@if(!empty($data['message']))
<x-mail::panel>
## {{ __('Additional Message') }}

{{ $data['message'] }}
</x-mail::panel>
@endif

<x-mail::button :url="'mailto:' . $data['email']" color="primary">
{{ __('Reply to Request') }}
</x-mail::button>

{{ __('This demo request was submitted on') }} {{ now()->format('F j, Y \a\t g:i A') }}.

{{ __('Best regards') }},  
{{ config('app.name') }} {{ __('Team') }}
</x-mail::message>
