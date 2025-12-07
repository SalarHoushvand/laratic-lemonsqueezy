@props([
    'id' => 'rangeSlider-' . uniqid(),
    'name' => null,
    'label' => null,
    'value' => 50,
    'min' => 0,
    'max' => 100,
    'step' => 1,
])

@php
    $baseInputClasses =
        'h-2 w-full appearance-none rounded-full bg-on-surface/15 focus:outline-primary dark:bg-on-surface-dark/15 dark:focus:outline-primary-dark [&::-moz-range-thumb]:size-4 [&::-moz-range-thumb]:appearance-none [&::-moz-range-thumb]:rounded-full [&::-moz-range-thumb]:border-none [&::-moz-range-thumb]:bg-primary active:[&::-moz-range-thumb]:scale-110 dark:[&::-moz-range-thumb]:bg-primary-dark [&::-webkit-slider-thumb]:size-4 [&::-webkit-slider-thumb]:appearance-none [&::-webkit-slider-thumb]:rounded-full [&::-webkit-slider-thumb]:border-none [&::-webkit-slider-thumb]:bg-primary active:[&::-webkit-slider-thumb]:scale-110 dark:[&::-webkit-slider-thumb]:bg-primary-dark';
@endphp

<div class="flex w-full flex-col gap-4 text-on-surface dark:text-on-surface-dark">

    @if ($label)
        <label for="{{ $id }}" class="w-fit pl-0.5 text-sm">{{ $label }}</label>
    @endif

    <input 
        {{ $attributes->merge([
            'id' => $id,
            'type' => 'range',
            'class' => $baseInputClasses,
            'value' => $value,
            'min' => $min,
            'max' => $max,
            'step' => $step,
        ]) }}
        @if ($name) name="{{ $name }}" @endif />

</div>

