<?php

namespace App\Livewire\Admin\Posts;

use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Livewire component for displaying and managing posts in the admin panel.
 */
class PostsTable extends Component
{
    use WithPagination;

    /**
     * The search query for filtering posts by title.
     */
    public string $search = '';

    /**
     * Filter by active status.
     */
    public ?bool $filterActive = null;

    /**
     * Filter by promoted status.
     */
    public ?bool $filterPromoted = null;

    /**
     * Sort direction for updated date: 'asc', 'desc', or null.
     */
    public ?string $sortUpdated = null;

    /**
     * Reset pagination when the search query is updated.
     */
    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    /**
     * Toggle active filter - prioritize active posts when clicked.
     */
    public function toggleActive(): void
    {
        $this->filterActive = $this->filterActive === true ? null : true;
        $this->resetPage();
    }

    /**
     * Toggle promoted filter - bring promoted posts to top when clicked.
     */
    public function togglePromoted(): void
    {
        $this->filterPromoted = $this->filterPromoted === true ? null : true;
        $this->resetPage();
    }

    /**
     * Toggle updated sort - cycles through desc, asc, null.
     */
    public function toggleUpdated(): void
    {
        if ($this->sortUpdated === null) {
            $this->sortUpdated = 'desc';
        } elseif ($this->sortUpdated === 'desc') {
            $this->sortUpdated = 'asc';
        } else {
            $this->sortUpdated = null;
        }
        $this->resetPage();
    }

    /**
     * Delete a post by its ID.
     *
     * @param  int  $postId  The ID of the post to delete
     */
    public function delete(int $postId): void
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if (! $user || ! $user->hasRole('admin')) {
            $this->dispatch(
                'notify',
                variant: 'danger',
                title: __('Unauthorized'),
                message: __('You do not have permission to delete this post.')
            );

            return;
        }

        try {
            $post = Post::findOrFail($postId);

            $post->delete();

            Log::info('Post deleted by admin', [
                'post_id' => $post->id,
                'post_title' => $post->title,
                'deleted_by' => $user->id,
            ]);

            $this->dispatch('close-modal');
            $this->dispatch(
                'notify',
                variant: 'success',
                title: __('Post deleted'),
                message: __('The post has been deleted successfully.'),
                displayDuration: 2000
            );
        } catch (ModelNotFoundException $e) {
            $this->dispatch(
                'notify',
                variant: 'danger',
                title: __('Error'),
                message: __('Post not found.')
            );
        } catch (\Throwable $e) {
            Log::error('Failed to delete post', [
                'post_id' => $postId,
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);

            $this->dispatch(
                'notify',
                variant: 'danger',
                title: __('Error'),
                message: __('Failed to delete post.')
            );
        }
    }

    /**
     * Render the component view.
     */
    public function render(): View
    {
        $posts = Post::query()
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%'.$this->search.'%');
            })
            ->when($this->filterPromoted === true, function ($query) {
                $query->orderBy('is_promoted', 'desc');
            })
            ->when($this->filterActive === true, function ($query) {
                $query->orderBy('is_active', 'desc');
            })
            ->when($this->sortUpdated === 'desc', function ($query) {
                $query->latest('updated_at');
            })
            ->when($this->sortUpdated === 'asc', function ($query) {
                $query->oldest('updated_at');
            })
            ->when(
                $this->sortUpdated === null && $this->filterActive === null && $this->filterPromoted === null,
                function ($query) {
                    $query->latest('created_at');
                }
            )
            ->paginate(8);

        return view('livewire.admin.posts.posts-table', compact('posts'));
    }
}
