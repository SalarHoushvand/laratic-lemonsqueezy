@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'text-xs text-danger space-y-1']) }}>
        @foreach ((array) $messages as $message)
            <li>{{ __('Error') }}: {{ $message }}</li>
        @endforeach
    </ul>
@endif
