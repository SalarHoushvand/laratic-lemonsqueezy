<?php

namespace App\Livewire\Admin\Posts;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Spatie\Tags\Tag;
use Throwable;

/**
 * Manage translated categories within the admin modal.
 */
class ManageCategories extends Component
{
    /**
     * Currently editing category id (null for create).
     */
    public ?int $editingId = null;

    /**
     * Translated names keyed by locale code.
     *
     * @var array<string,string>
     */
    #[Validate('array')]
    public array $translations = [];

    /**
     * Search query for filtering categories.
     */
    public string $search = '';

    /**
     * The post's language for determining the default language tab.
     */
    public string $postLanguage;

    /**
     * Initialize the component.
     */
    public function mount(string $postLanguage): void
    {
        $this->postLanguage = $postLanguage;
        // Initialize inputs for configured languages, if not set, set to empty string
        $langs = array_keys((array) config('languages', []));
        foreach ($langs as $langCode) {
            if (! isset($this->translations[$langCode])) {
                $this->translations[$langCode] = '';
            }
        }
    }

    /**
     * Create or update the category with translations.
     */
    public function save(): void
    {
        $inputs = collect($this->translations)
            ->mapWithKeys(fn ($name, $locale) => [$locale => trim((string) $name)])
            ->filter(fn ($name) => $name !== '')
            ->toArray();

        // English name is required
        if (empty($inputs['en'])) {
            $this->dispatch('notify', variant: 'danger', title: __('Validation error'), message: __('The English name is required'));

            return;
        }

        // No empty inputs
        if ($inputs === []) {
            $this->dispatch('notify', variant: 'danger', title: __('Validation error'), message: __('Provide at least one translation'));

            return;
        }

        try {
            if ($this->editingId) {
                $tag = Tag::findOrFail($this->editingId);
                $tag->setTranslations('name', $inputs);
                $tag->save();
            } else {
                // Check if a tag with any of these translations already exists
                $existingTag = null;
                foreach ($inputs as $locale => $value) {
                    $existingTag = Tag::where("name->{$locale}", $value)
                        ->first();

                    if ($existingTag) {
                        break;
                    }
                }

                // Use existing tag or create a new one
                $tag = $existingTag ?? new Tag;
                $tag->setTranslations('name', $inputs);
                $tag->save();
            }

            $this->dispatch('tags-updated');
            $this->dispatch('notify', variant: 'success', title: __('Saved'), message: __('Category saved successfully'), displayDuration: 2000);

            // Reset editing state after save
            $this->editingId = null;
            $this->resetTranslations();
        } catch (Throwable $e) {
            Log::error('Category save failed: '.$e->getMessage());
            $this->dispatch('notify', variant: 'danger', title: __('Error'), message: __('Failed to save category. Please try again.'));
        }
    }

    /**
     * Load a category into the form for editing.
     */
    public function edit(int $id): void
    {
        try {
            $tag = Tag::findOrFail($id);
            $this->editingId = $tag->id;

            $this->translations = [];
            $langs = array_keys($this->langs);
            // Check if the tag has a translation for the language and if not, set it to null for input
            foreach ($langs as $langCode) {
                $this->translations[$langCode] = $tag->hasTranslation('name', $langCode)
                    ? (string) $tag->getTranslation('name', $langCode)
                    : null;
            }
        } catch (Throwable $e) {
            Log::error('Category edit failed: '.$e->getMessage());
            $this->dispatch('notify', variant: 'danger', title: __('Error'), message: __('Category not found.'));
        }
    }

    /**
     * Reset form to create mode.
     */
    public function cancelEdit(): void
    {
        $this->editingId = null;
        $this->search = '';
        $this->resetTranslations();
    }

    /**
     * Delete a category.
     */
    public function delete(int $id): void
    {
        try {
            $tag = Tag::findOrFail($id);
            $tag->delete();

            $this->dispatch('tags-updated');
            $this->dispatch('notify', variant: 'success', title: __('Deleted'), message: __('Category deleted'), displayDuration: 2000);
        } catch (Throwable $e) {
            Log::error('Category delete failed: '.$e->getMessage());
            $this->dispatch('notify', variant: 'danger', title: __('Error'), message: __('Failed to delete category. Please try again.'));
        }
    }

    /**
     * Get all configured languages.
     *
     * @return array<string, array{code: string, name: string, local_name: string, flag: string}>
     */
    #[Computed]
    public function langs(): array
    {
        return (array) config('languages', []);
    }

    /**
     * Get other languages (excluding English).
     *
     * @return \Illuminate\Support\Collection<string, array{code: string, name: string, local_name: string, flag: string}>
     */
    #[Computed]
    public function otherLangs(): \Illuminate\Support\Collection
    {
        return collect($this->langs)->except('en');
    }

    /**
     * Get the default active language tab.
     */
    #[Computed]
    public function defaultLang(): string
    {
        if ($this->postLanguage === 'en') {
            $otherLangs = $this->otherLangs;

            return $otherLangs->isNotEmpty() ? $otherLangs->keys()->first() : 'en';
        }

        return $this->postLanguage;
    }

    /**
     * List of categories.
     *
     * @return array<int, array{ id:int, label:string }>
     */
    #[Computed]
    public function categories(): array
    {
        $language = $this->postLanguage;

        return Tag::orderBy('name->'.$language)
            ->get()
            ->map(fn (Tag $tag) => [
                'id' => $tag->id,
                'label' => $tag->getTranslation('name', $language) ?? (string) ($tag->name[$language] ?? $tag->name[array_key_first((array) $tag->name)] ?? ''),
            ])
            ->filter(fn (array $category) => empty($this->search) || stripos($category['label'], $this->search) !== false)
            ->values()
            ->toArray();
    }

    /**
     * Reset all translation inputs to empty strings.
     */
    private function resetTranslations(): void
    {
        foreach (array_keys((array) config('languages', [])) as $langCode) {
            $this->translations[$langCode] = '';
        }
    }

    /**
     * Render the component.
     */
    public function render(): View
    {
        return view('livewire.admin.posts.manage-categories');
    }
}
