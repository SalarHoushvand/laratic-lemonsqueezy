@props([
    'label' => null,
    'error' => false,
    'errorMessage' => null,
    'target' => null, // Livewire property name to update
    'componentId' => null, // Livewire component ID
   
])

@php
    $name = $attributes->get('name');
    $fieldErrors = $name ? $errors->get($name) ?? [] : [];
    $hasError = $error || !empty($errorMessage) || !empty($fieldErrors);
    $errorMessages = !empty($errorMessage) ? (is_array($errorMessage) ? $errorMessage : [$errorMessage]) : $fieldErrors;
@endphp

<div class="relative flex w-full flex-col gap-1 text-on-surface dark:text-on-surface-dark">

    @if ($slot->isEmpty())
        <div>
            <x-cloudinary::widget
                class="bg-surface-alt text-on-surface dark:text-on-surface-dark dark:bg-surface-dark-alt border border-outline dark:border-outline-dark p-2 text-sm">
                <div class="flex items-center gap-2">
                    <x-icons.cloud-arrow-up variant="solid" size="md" />
                    {{ $label ?? __('Upload File') }}
                </div>
            </x-cloudinary::widget>
        </div>
    @else
        <div>
            <x-cloudinary::widget>
                {{ $slot }}
            </x-cloudinary::widget>
        </div>
    @endif

    @if ($target && $componentId)
        @script
            <script>
                (() => {
                    const componentId = @js($componentId);
                    const targetProperty = @js($target);
                    let intercepted = false;

                    function intercept() {
                        if (intercepted || typeof cloudinary === 'undefined' || !cloudinary.createUploadWidget) {
                            return;
                        }

                        intercepted = true;
                        const original = cloudinary.createUploadWidget.bind(cloudinary);

                        cloudinary.createUploadWidget = function(config, callback) {
                            return original(config, (error, result) => {
                                if (callback) callback(error, result);

                                if (!error && result?.event === 'success' && result.info?.secure_url) {
                                    const component = Livewire.find(componentId);
                                    component?.set(targetProperty, result.info.secure_url);
                                }
                            });
                        };
                    }

                    if (typeof cloudinary !== 'undefined') intercept();
                    window.addEventListener('load', intercept);
                })();
            </script>
        @endscript
    @endif

    @if ($hasError && !empty($errorMessages))
        @foreach ($errorMessages as $message)
            <small class="pl-0.5 text-danger">Error: {{ $message }}</small>
        @endforeach
    @endif
</div>
