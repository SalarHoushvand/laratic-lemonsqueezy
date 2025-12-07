<?php

namespace App\Livewire\Admin\Posts;

use App\Models\Post;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Spatie\Tags\Tag;

/**
 * Livewire component for selecting categories for a post.
 */
class CategoriesSelect extends Component
{
    /**
     * The post ID this selector is managing tags for.
     */
    public int $postId;

    /**
     * The post instance.
     */
    public Post $post;

    /**
     * Selected category values.
     */
    #[Validate('array')]
    public array $categories = [];

    /**
     * Remember the last state that was synced to the database to prevent redundant syncs.
     *
     * @var array<int, int>
     */
    protected array $lastSynced = [];

    /**
     * The post language for filtering and ordering tags.
     */
    public string $language = 'en';

    /**
     * Search query for filtering options.
     */
    public string $search = '';

    /**
     * Initialize with post context.
     */
    public function mount(Post $post): void
    {
        $this->post = $post;

        $this->language = $this->post->language ?? 'en';
        $this->categories = $this->post->tags->pluck('id')->all();

        $this->lastSynced = collect($this->categories)->sort()->values()->all();
    }

    /**
     * Get the available category options.
     */
    #[Computed]
    public function options(): array
    {
        $language = $this->language;

        return Tag::orderBy('name->'.$language)
            ->get()
            ->map(fn (Tag $tag) => [
                'value' => $tag->id,
                'label' => $tag->getTranslation('name', $language) ?? $tag->getTranslation('name', 'en') ?? '',
            ])
            ->values()
            ->toArray();
    }

    /**
     * Sync selected categories to the post when the categories are updated.
     */
    public function updatedCategories(): void
    {
        $current = collect($this->categories)->sort()->values()->all();

        // Skip the sync if the categories are the same as the last synced.
        if ($current === $this->lastSynced) {
            return;
        }

        $this->syncTags();
        $this->lastSynced = $current;
    }

    /**
     * Sync tags to the post.
     */
    protected function syncTags(): void
    {
        $tags = Tag::whereKey($this->categories)->get();
        $this->post->syncTags($tags);
    }

    /**
     * Refresh selections and options when categories are changed elsewhere.
     * This updates the selected categories and triggers a re-render which
     * recalculates the options() computed property, refreshing the combobox.
     */
    #[On('tags-updated')]
    public function refreshFromDb(): void
    {
        $this->categories = $this->post->tags->pluck('id')->all();
    }

    /**
     * Render the component view.
     */
    public function render(): View
    {
        return view('livewire.admin.posts.categories-select');
    }
}
