@props([
    'id' => 'counterInput-' . uniqid(),
    'name' => null,
    'label' => null,
    'value' => 1,
    'min' => 0,
    'max' => 10,
    'step' => 1,
])

<div class="flex flex-col gap-1">

    @if ($label)
        <label for="{{ $id }}" class="pl-1 text-sm text-on-surface dark:text-on-surface-dark">{{ $label }}</label>
    @endif

    <div x-data="{ 
        minVal: {{ $min }}, 
        maxVal: {{ $max }}, 
        incrementAmount: {{ $step }},
        getValue() {
            return parseFloat($refs.input.value) || {{ $value }};
        },
        decrement() {
            const current = this.getValue();
            const newVal = Math.max(this.minVal, current - this.incrementAmount);
            $refs.input.value = newVal;
            $refs.input.dispatchEvent(new Event('input', { bubbles: true }));
        },
        increment() {
            const current = this.getValue();
            const newVal = Math.min(this.maxVal, current + this.incrementAmount);
            $refs.input.value = newVal;
            $refs.input.dispatchEvent(new Event('input', { bubbles: true }));
        }
    }" x-on:dblclick.prevent class="flex items-center">

        <button type="button" x-on:click="decrement()" 
            class="flex h-10 items-center justify-center rounded-l-radius border border-outline bg-surface-alt px-4 py-2 text-on-surface hover:opacity-75 focus-visible:z-10 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary active:opacity-100 active:outline-offset-0 dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark dark:focus-visible:outline-primary-dark" 
            aria-label="subtract">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor" fill="none" stroke-width="2" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15"/>
            </svg>
        </button>

        <input 
            x-ref="input"
            {{ $attributes->merge([
                'id' => $id,
                'type' => 'text',
                'value' => $value,
                'class' => 'border-x-none h-10 w-20 rounded-none border-y border-outline bg-surface-alt/50 text-center text-on-surface-strong focus-visible:z-10 focus-visible:outline-2 focus-visible:outline-primary dark:border-outline-dark dark:bg-surface-dark-alt/50 dark:text-on-surface-dark-strong dark:focus-visible:outline-primary-dark',
                'readonly' => true,
            ]) }}
            @if ($name) name="{{ $name }}" @endif />

        <button type="button" x-on:click="increment()" 
            class="flex h-10 items-center justify-center rounded-r-radius border border-outline bg-surface-alt px-4 py-2 text-on-surface hover:opacity-75 focus-visible:z-10 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary active:opacity-100 active:outline-offset-0 dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark dark:focus-visible:outline-primary-dark" 
            aria-label="add">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor" fill="none" stroke-width="2" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
        </button>

    </div>

</div>

