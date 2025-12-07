<div>
    <x-select 
        wire:model.live="status" 
        class="capitalize bg-surface! dark:bg-surface-dark!" 
        width="min-w-xs"
    >
        @foreach($this->statuses as $statusOption)
            <option 
                wire:key="status-{{ $statusOption }}"
                value="{{ $statusOption }}" 
                @selected($statusOption === $order->status)
            >
                {{ __(ucfirst($statusOption)) }}
            </option>
        @endforeach
    </x-select>

    @error('status')
        <p class="mt-1 text-danger text-sm">{{ $message }}</p>
    @enderror
</div>
