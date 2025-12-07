<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * Display a listing of all posts for admin.
     *
     * Shows the admin interface for managing posts, including both
     * active and inactive posts regardless of locale or status.
     */
    public function index(): View
    {
        return view('pages.admin.posts.index');
    }

    /**
     * Show the form for creating a new post.
     *
     * Displays the form view where administrators can create
     * a new blog post.
     */
    public function create(): View
    {
        return view('pages.admin.posts.create');
    }

    /**
     * Show the form for editing an existing post.
     *
     * Displays the edit form for the specified post, loaded
     * via route model binding.
     *
     * @param  \App\Models\Post  $post  The post model instance
     */
    public function edit(Post $post): View
    {
        return view('pages.admin.posts.edit', compact('post'));
    }
}
