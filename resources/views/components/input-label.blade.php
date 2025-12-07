@props(['value', 'error' => false])

<label {{ $attributes->merge(['class' => 'text-sm font-medium text-on-surface dark:text-on-surface-dark flex items-center gap-1']) }}>
    @if ($error)
        <x-icons.x-mark size="sm" strokeWidth="2" class="text-danger" />
    @endif
    {{ $value ?? $slot }}
</label>
