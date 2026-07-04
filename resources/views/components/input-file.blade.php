@props(['label' => null, 'error' => false, 'errorMessage' => null])

@php
    $name = $attributes->get('name');
    $fieldErrors = $name ? $errors->get($name) ?? [] : [];
    $hasError = $error || ! empty($errorMessage) || ! empty($fieldErrors);
    $errorMessages = ! empty($errorMessage) ? (is_array($errorMessage) ? $errorMessage : [$errorMessage]) : $fieldErrors;
    $inputId = 'file-input-'.uniqid();
@endphp

<div
    x-data="{ uploading: false }"
    x-on:livewire-upload-start="uploading = true"
    x-on:livewire-upload-finish="uploading = false"
    x-on:livewire-upload-error="uploading = false"
    class="relative flex w-full flex-col gap-1 text-on-surface dark:text-on-surface-dark"
>
    <label for="{{ $inputId }}" class="cursor-pointer">
        @if ($slot->isEmpty())
            <div @class([
                'inline-flex items-center gap-2 rounded-radius border p-2 text-sm bg-surface-alt text-on-surface dark:bg-surface-dark-alt dark:text-on-surface-dark',
                'border-danger' => $hasError,
                'border-outline dark:border-outline-dark' => ! $hasError,
            ])>
                <span x-show="!uploading" class="flex items-center gap-2">
                    <x-icons.cloud-arrow-up variant="solid" size="md" />
                    {{ $label ?? __('Upload File') }}
                </span>
                <span x-cloak x-show="uploading" class="flex items-center gap-2">
                    <x-icons.spinner class="size-4 animate-spin" />
                    {{ __('Uploading...') }}
                </span>
            </div>
        @else
            {{ $slot }}
        @endif
    </label>

    <input
        id="{{ $inputId }}"
        type="file"
        {{ $attributes->whereStartsWith('wire:') }}
        class="sr-only"
    />

    @if ($hasError && ! empty($errorMessages))
        @foreach ($errorMessages as $message)
            <small class="pl-0.5 text-danger">{{ $message }}</small>
        @endforeach
    @endif
</div>
