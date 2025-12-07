<?php

namespace App\Livewire\Forms\Admin;

use App\Jobs\GeneratePostWithAi;
use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Throwable;

/**
 * Livewire component for creating new blog posts with optional AI generation.
 */
class CreatePost extends Component
{
    /**
     * User-provided prompt for AI content generation.
     */
    public string $aiPrompt = '';

    /**
     * Controls visibility of the AI prompt input field.
     */
    public bool $showAiPrompt = false;

    /**
     * Indicates if an AI generation job is currently in progress.
     */
    public bool $isGenerating = false;

    /**
     * Unique identifier for tracking the AI generation request.
     */
    public string $generationRequestId = '';

    /**
     * The post title.
     */
    #[Validate('required|string|max:255')]
    public string $title = '';

    /**
     * The post slug.
     */
    #[Validate('nullable|string|max:255')]
    public string $slug = '';

    /**
     * The post description or excerpt.
     */
    #[Validate('nullable|string|max:1000')]
    public string $description = '';

    /**
     * URL of the post's featured image.
     */
    #[Validate('nullable|url')]
    public string $image_url = '';

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
     * Initialize the component and set default author name.
     * Sets locale to English if it's not already, and notifies the user.
     */
    public function mount(): void
    {
        $this->author = Auth::user()?->name ?? '';
    }

    /**
     * Save the post and redirect to the edit page.
     */
    public function save(): void
    {
        try {
            $validated = $this->validate();
            $validated['language'] = 'en';

            if (! empty($validated['slug'])) {
                $validated['slug'] = str_replace(' ', '-', $validated['slug']);
            }

            $post = Post::create($validated);

            session()->flash('notification', ['variant' => 'success', 'title' => __('Post Created'), 'message' => __('The post has been created successfully.')]);
            $this->redirect(route('admin.posts.edit', $post->id));
        } catch (Throwable $e) {
            Log::error('Post creation failed: '.$e->getMessage());
            $this->dispatch('notify', variant: 'danger', title: __('Error'), message: __('Failed to create post. Please try again.'));
        }
    }

    /**
     * Dispatch an async job to generate post content using AI.
     *
     * Sets up cache flags for polling and handles job dispatch errors.
     */
    public function generateWithAi(): void
    {
        try {
            $this->generationRequestId = (string) Str::ulid();
            $this->isGenerating = true;

            $baseKey = 'post_ai:'.$this->generationRequestId;
            Cache::put($baseKey.':done', false, now()->addMinutes(20));

            GeneratePostWithAi::dispatch(
                $this->generationRequestId,
                $this->aiPrompt,
                $this->title,
                $this->description,
                Auth::id()
            );
        } catch (Throwable $e) {
            $this->isGenerating = false;
            Log::error('GeneratePostWithAi failed: '.$e->getMessage());
            $this->dispatch('notify', variant: 'danger', title: __('Failed to Start Generation'), message: __('Unable to queue the generation job. Please try again.'));
        }
    }

    /**
     * Poll the cache for AI generation completion status.
     *
     * Checks for errors or successful completion, then redirects to edit page
     * if a post was created. Called periodically by the frontend via wire:poll.
     */
    public function pollAiGeneration(): void
    {
        if (! $this->isGenerating || $this->generationRequestId === '') {
            return;
        }

        $baseKey = 'post_ai:'.$this->generationRequestId;
        $done = (bool) Cache::get($baseKey.':done', false);

        if (! $done) {
            return;
        }

        $error = (string) (Cache::get($baseKey.':error', '') ?? '');
        if ($error !== '') {
            $this->isGenerating = false;
            $this->dispatch('notify', variant: 'danger', title: __('AI generation failed'), message: __($error));

            return;
        }

        $result = Cache::get($baseKey.':result');

        if (is_array($result) && isset($result['post_id'])) {
            try {
                $postId = (int) $result['post_id'];

                session()->flash('notification', ['variant' => 'success', 'title' => __('AI draft saved'), 'message' => __('An unpublished draft was created from AI content. Review, edit, and publish when ready.')]);
                $this->redirect(route('admin.posts.edit', $postId));
            } catch (Throwable $e) {
                Log::error('AI generation redirect failed: '.$e->getMessage());
                $this->isGenerating = false;
                $this->showAiPrompt = false;
                $this->dispatch('notify', variant: 'danger', title: __('Error'), message: __('Failed to redirect to post. Please try again.'));
            }
        }

        $this->isGenerating = false;
        $this->showAiPrompt = false;
        $this->aiPrompt = '';
    }

    /**
     * Toggle the visibility of the AI prompt input field.
     */
    public function toggleAiPrompt(): void
    {
        $this->showAiPrompt = ! $this->showAiPrompt;
    }

    /**
     * Render the component view.
     */
    public function render(): View
    {
        return view('livewire.forms.admin.create-post');
    }
}
