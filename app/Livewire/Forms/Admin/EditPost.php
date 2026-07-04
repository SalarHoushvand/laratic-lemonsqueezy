<?php

namespace App\Livewire\Forms\Admin;

use App\Jobs\TranslatePostWithAi;
use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Throwable;

/**
 * Livewire component for editing existing blog posts with translation capabilities.
 */
class EditPost extends Component
{
    use WithFileUploads;

    /**
     * The post being edited.
     */
    public Post $post;

    /**
     * The post title.
     */
    #[Validate('required|string|max:255')]
    public string $title = '';

    /**
     * The post description or excerpt.
     */
    #[Validate('nullable|string|max:1000')]
    public string $description = '';

    /**
     * URL of the post's featured image.
     */
    #[Validate('nullable')]
    public string $image_url = '';

    /**
     * Temporary file upload for cover image.
     */
    #[Validate('nullable|image|max:5120')]
    public $uploadedImage = null;

    /**
     * The author name for the post.
     */
    #[Validate('nullable|string|max:255')]
    public string $author = '';

    /**
     * The main content of the post.
     */
    #[Validate('nullable|string')]
    public string $content = '';

    /**
     * The unique slug identifier for the post.
     */
    #[Validate('nullable|string|max:1000')]
    public string $slug = '';

    /**
     * Whether the post is active/published.
     */
    #[Validate('boolean')]
    public bool $is_active = false;

    /**
     * Whether the post is promoted/featured.
     */
    #[Validate('boolean')]
    public bool $is_promoted = false;

    /**
     * The selected language code for creating a new translation.
     */
    public string $selectedTranslationLanguage = '';

    /**
     * Indicates if a translation job is currently in progress.
     */
    public bool $isTranslating = false;

    /**
     * Cached available languages for new translations.
     *
     * @var array<int, array{code: string, name: string, local_name: string, flag: string}>
     */
    public array $availableLanguages = [];

    /**
     * Unique identifier for tracking the translation request.
     */
    public string $translationRequestId = '';

    /**
     * Initialize the component with the post data.
     */
    public function mount(Post $post): void
    {
        $this->post = $post;

        $this->fill([
            'title' => $this->post->title ?? '',
            'description' => $this->post->description ?? '',
            'image_url' => $this->post->image_url ?? '',
            'author' => $this->post->author ?? '',
            'content' => $this->post->content ?? '',
            'slug' => $this->post->slug ?? '',
            'is_active' => $this->post->is_active,
            'is_promoted' => $this->post->is_promoted,
        ]);

        $this->availableLanguages = $this->calculateAvailableLanguages();
    }

    /**
     * Save the updated post data.
     *
     * Validates the form, normalizes and checks slug uniqueness, then updates the post.
     */
    public function save(): void
    {
        try {
            $validated = $this->validate();
            $normalizedSlug = Str::slug($validated['slug'] ?: $validated['title']);

            if ($normalizedSlug !== $this->post->slug) {
                $this->slug = $normalizedSlug;
                $this->validate(['slug' => [Rule::unique('posts', 'slug')->ignore($this->post->id)]], ['slug.unique' => 'This slug is already in use. Please choose a different one.']);
            }

            $validated['slug'] = $normalizedSlug;
            $this->post->update($validated);

            $this->dispatch('notify', variant: 'success', title: __('Post Saved'), message: __('Your changes have been saved.'));
        } catch (ValidationException $e) {
            $this->dispatch('notify', variant: 'danger', title: __('Post Update Failed'), message: __('Please check the form for errors and try again.'));
            throw $e;
        } catch (Throwable $e) {
            Log::error('Post update failed: '.$e->getMessage());

            $this->dispatch('notify', variant: 'danger', title: __('Post Update Failed'), message: __('Unable to save your changes. Please try again.'));
        }
    }

    /**
     * Handle cover image file upload: store to S3 and auto-save to the post.
     */
    public function updatedUploadedImage(): void
    {
        $this->validateOnly('uploadedImage');

        $path = $this->uploadedImage->store('posts', 's3');
        $this->image_url = Storage::disk('s3')->url($path);
        $this->uploadedImage = null;

        $this->post->update(['image_url' => $this->image_url]);
        $this->dispatch('notify', variant: 'success', title: __('Image saved'), message: __('The cover image has been updated.'));
    }

    /**
     * Auto-save the image URL when it changes.
     *
     * Triggered by wire:model.blur on the image_url field.
     */
    public function updatedImageUrl(): void
    {
        $this->validateOnly('image_url');

        try {
            $this->post->update(['image_url' => $this->image_url]);

            $this->dispatch('notify', variant: 'success', title: __('Image saved'), message: __('The image has been updated.'));
        } catch (Throwable $e) {
            Log::error('Image update failed: '.$e->getMessage());
            $this->dispatch('notify', variant: 'danger', title: __('Image Update Failed'), message: __('Unable to update the image. Please try again.'));
        }
    }

    /**
     * Dispatch an async job to create a translation using AI.
     *
     * Sets up cache flags for polling and handles job dispatch.
     */
    public function createTranslationWithAi(): void
    {
        if (! $this->post->reference_number || $this->selectedTranslationLanguage === '') {
            return;
        }

        if ($this->isTranslating) {
            return;
        }

        try {
            $this->translationRequestId = (string) Str::ulid();
            $this->isTranslating = true;

            $baseKey = 'translate_post_ai:'.$this->translationRequestId;
            Cache::put("{$baseKey}:done", false, now()->addMinutes(20));

            TranslatePostWithAi::dispatch($this->translationRequestId, $this->post, $this->selectedTranslationLanguage, Auth::id());

            $this->dispatch('notify', variant: 'info', title: __('Translation Started'), message: __('Your translation is being generated. This may take a moment...'));
        } catch (Throwable $e) {
            Log::error('Translation job dispatch failed: '.$e->getMessage());
            $this->isTranslating = false;
            $this->dispatch('notify', variant: 'danger', title: __('Translation Failed'), message: __('Unable to start translation. Please try again.'));
        }
    }

    /**
     * Poll the cache for translation job completion status.
     *
     * Checks for errors or successful completion, then redirects to edit page
     * if a translated post was created. Called periodically by the frontend via wire:poll.
     */
    public function pollTranslationGeneration(): void
    {
        if (! $this->isTranslating || $this->translationRequestId === '') {
            return;
        }

        try {
            $baseKey = 'translate_post_ai:'.$this->translationRequestId;
            $done = (bool) Cache::get("{$baseKey}:done", false);

            if (! $done) {
                return;
            }

            $error = (string) (Cache::get("{$baseKey}:error", '') ?? '');
            if ($error !== '') {
                $this->isTranslating = false;
                $this->dispatch('notify', variant: 'danger', title: __('Translation failed'), message: __($error));

                return;
            }

            $result = Cache::get("{$baseKey}:result");
            if (is_array($result) && isset($result['post_id'])) {
                $translatedPostId = (int) $result['post_id'];

                $this->isTranslating = false;
                $this->selectedTranslationLanguage = '';

                session()->flash('notification', ['variant' => 'success', 'title' => __('Translation Complete'), 'message' => __('The translated post has been created successfully.')]);

                $this->redirect(route('admin.posts.edit', $translatedPostId));
            }

            $this->isTranslating = false;
        } catch (Throwable $e) {
            Log::error('Translation polling failed: '.$e->getMessage());
            $this->isTranslating = false;
        }
    }

    /**
     * Create a new translation post with empty content for manual editing.
     *
     * Creates a new post with the same reference_number and cover image,
     * but with empty content fields that the user can fill manually.
     */
    public function createManualTranslation(): void
    {
        if (! $this->post->reference_number || $this->selectedTranslationLanguage === '') {
            return;
        }

        try {
            $languageConfig = config('languages', []);
            $langName = $languageConfig[$this->selectedTranslationLanguage]['name'] ?? strtoupper($this->selectedTranslationLanguage);

            $newPost = Post::create([
                'reference_number' => $this->post->reference_number,
                'language' => $this->selectedTranslationLanguage,
                'title' => __('Untitled Translation').' ('.$langName.')',
                'description' => '',
                'content' => '',
                'image_url' => $this->post->image_url,
                'author' => $this->post->author ?? Auth::user()?->name ?? '',
                'is_active' => false,
                'is_promoted' => false,
            ]);

            $this->selectedTranslationLanguage = '';

            session()->flash('notification', ['variant' => 'success', 'title' => __('Translation Created'), 'message' => __('A new translation post has been created. You can now edit it manually.')]);

            $this->redirect(route('admin.posts.edit', $newPost->id));
        } catch (Throwable $e) {
            Log::error('Manual translation creation failed: '.$e->getMessage());
            $this->dispatch('notify', variant: 'danger', title: __('Translation Failed'), message: __('Unable to create translation. Please try again.'));
        }
    }

    /**
     * Get AI usage history for this post.
     *
     * @return Collection<int, \App\Models\AiUsage>
     */
    #[Computed]
    public function aiUsages(): Collection
    {
        return $this->post->aiUsages()->latest()->get();
    }

    /**
     * Build the list of available languages, excluding those that already exist as translations.
     *
     * @return array<int, array{code: string, name: string, local_name: string, flag: string}>
     */
    private function calculateAvailableLanguages(): array
    {
        $allLanguages = collect(config('languages', []))->map(fn ($lang) => ['code' => $lang['code'], 'name' => __($lang['name']), 'local_name' => $lang['local_name'] ?? $lang['name'], 'flag' => $lang['flag']])->toArray();

        if (! $this->post->reference_number) {
            return $allLanguages;
        }

        $existingLanguages = Post::whereReferenceNumber($this->post->reference_number)->pluck('language')->all();

        return collect($allLanguages)->reject(fn (array $lang) => in_array($lang['code'], $existingLanguages, true))->values()->all();
    }

    /**
     * Delete the current post.
     *
     * Validates admin permissions, deletes the post, logs the action,
     * and redirects to the posts index page.
     */
    public function delete(): void
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if (! $user || ! $user->hasRole('admin')) {
            $this->dispatch('notify', variant: 'danger', title: __('Unauthorized'), message: __('You do not have permission to delete this post.'));

            return;
        }

        try {
            $this->post->delete();

            Log::info('Post deleted by admin', ['post_id' => $this->post->id, 'post_title' => $this->post->title, 'deleted_by' => $user->id]);

            $this->dispatch('close-modal');
            session()->flash('notification', ['variant' => 'success', 'title' => __('Post deleted'), 'message' => __('The post has been deleted successfully.')]);
            $this->redirect(route('admin.posts.index'));
        } catch (Throwable $e) {
            Log::error('Failed to delete post', ['post_id' => $this->post->id, 'user_id' => $user->id, 'error' => $e->getMessage()]);

            $this->dispatch('notify', variant: 'danger', title: __('Error'), message: __('Failed to delete post.'));
        }
    }

    /**
     * Get all translations of this post.
     *
     * @return array<int, array<string, mixed>>
     */
    #[Computed]
    public function translations(): array
    {
        if (! $this->post->reference_number) {
            return [];
        }

        return Post::whereReferenceNumber($this->post->reference_number)->orderBy('language')->get()->toArray();
    }

    /**
     * Render the component view.
     */
    public function render(): View
    {
        return view('livewire.forms.admin.edit-post');
    }
}
