<div class="p-6">
    <div class="flex flex-col justify-center items-center gap-4 max-w-sm">
        <x-button wire:click="tryRequest" variant="primary" size="sm">
            <span wire:loading.remove wire:target="tryRequest">{{ __('Try Request') }}</span>
            <x-icons.spinner wire:loading wire:target="tryRequest" variant="solid" size="sm" class="animate-spin" />
            <span wire:loading wire:target="tryRequest">{{ __('Trying...') }}</span>
        </x-button>

        <p class="text-sm opacity-70 text-center leading-relaxed">
            {!! __('This page demonstrates a basic request to the AI API. <br>Nothing fancy.') !!}
            {{ __('You can reuse the backend logic to build different AI features.') }}
            {{ __('The result will be dumped to the console.') }}
        </p>
    </div>
</div>
