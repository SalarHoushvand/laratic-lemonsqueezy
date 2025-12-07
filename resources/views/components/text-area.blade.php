@props(['disabled' => false, 'error' => false])

<textarea {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' =>
        'w-full rounded-radius border bg-surface-alt autofill:bg-surface-alt px-2 py-2 text-sm text-on-surface focus:border-outline focus:ring-0 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary disabled:cursor-not-allowed disabled:opacity-75 dark:text-on-surface-dark dark:bg-surface-dark-alt dark:autofill:bg-surface-dark-alt dark:focus-visible:outline-primary-dark' . ($error ? ' border-danger ' : ' border-outline dark:border-outline-dark '),
]) !!}>{{ $slot }}</textarea>
