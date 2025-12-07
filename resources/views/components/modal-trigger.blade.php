@props(['target'])

<div class="cursor-pointer" data-target-modal="{{ $target }}"
    x-on:click="$dispatch('open-modal', { name: '{{ $target }}' })" {{ $attributes }}>
    {{ $slot }}
</div>
