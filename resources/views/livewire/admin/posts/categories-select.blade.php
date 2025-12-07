<div class="panel">
    <x-combobox-multiselect
        id="categories"
        name="categories"
        wire:model="categories"
        :options="$this->options"
        :label="__('Categories')"
        :placeholder="__('Select categories')"
        emptyStateMessage="{{ __('No categories available') }}"
        displayKey="label"
        valueKey="value"
    />

    <x-input-error :messages="$errors->get('categories')" class="mt-2" />

    {{-- Added the modal outside of livewire component to avoid potential issues. --}}
    <x-modal-trigger target="manage-categories">
        <x-button size="xs" type="button" variant="outline" class="mt-3">
            <span>{{ __('Manage Categories') }}</span>
        </x-button>
    </x-modal-trigger>
</div>
