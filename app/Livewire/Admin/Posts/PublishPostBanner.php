<?php

namespace App\Livewire\Admin\Posts;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;

/**
 * Livewire component for publishing posts from a banner interface.
 *
 * This component provides functionality for administrators to publish
 * inactive posts, with proper authorization checks and user feedback.
 */
class PublishPostBanner extends Component
{
    /**
     * The post instance to be published.
     */
    public Post $post;

    /**
     * Initialize the component with the post instance.
     */
    public function mount(Post $post): void
    {
        $this->post = $post;
    }

    /**
     * Publish the post by setting its active status to true.
     *
     * This method performs authorization checks to ensure only admin
     * users can publish posts, then updates the post status and redirects
     * to the post's public view.
     */
    public function publish(): void
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if (! $user || ! $user->hasRole('admin')) {
            $this->dispatch(
                'notify',
                variant: 'danger',
                title: __('Unauthorized'),
                message: __('You do not have permission to publish this post.')
            );

            return;
        }

        $this->post->update(['is_active' => true]);
        $this->post->refresh();

        session()->flash('notification', [
            'variant' => 'success',
            'title' => __('Post Published'),
            'message' => __('The post has been published successfully.'),
        ]);

        $this->redirect(route('posts.show', $this->post->slug), navigate: false);
    }

    /**
     * Render the component view.
     */
    public function render(): View
    {
        return view('livewire.admin.posts.publish-post-banner');
    }
}
