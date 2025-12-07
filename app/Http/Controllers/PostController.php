<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Spatie\Tags\Tag;

class PostController extends Controller
{
    /**
     * Display a listing of blog posts.
     *
     * Shows active posts for the current locale. Features a promoted post
     * separately and excludes it from the main paginated list. Posts are
     * ordered by promotion status first, then by creation date.
     */
    public function index(Request $request): View
    {
        $locale = app()->getLocale();
        $category = $request->query('category');

        $postsQuery = Post::active()
            ->forLocale($locale)
            ->when($category, fn (Builder $query) => $query->inCategory($category, $locale));

        $featuredPost = Post::active()
            ->forLocale($locale)
            ->when($category, fn (Builder $query) => $query->inCategory($category, $locale))
            ->promoted()
            ->latest('created_at')
            ->first();

        $posts = $postsQuery
            ->when($featuredPost, fn (Builder $query) => $query->whereKeyNot($featuredPost))
            ->orderByDesc('is_promoted')
            ->latest('created_at')
            ->paginate(12)
            ->withQueryString();

        $categories = Tag::orderBy("name->{$locale}")
            ->get();

        return view('pages.blog.index', compact('posts', 'featuredPost', 'categories', 'category'));
    }

    /**
     * Display the specified post.
     *
     * Shows a single post by slug. Admins can view inactive posts,
     * while regular users only see active posts. Includes related
     * posts from the same language and a flag indicating if the
     * post is unpublished (visible only to admins).
     *
     * @param  string  $slug  The post's slug identifier
     */
    public function show(string $slug): View
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        $isAdmin = $user && $user->hasRole('admin');

        $post = Post::whereSlug($slug)
            ->when(! $isAdmin, fn (Builder $query) => $query->active())
            ->firstOrFail();

        $relatedPosts = Post::active()
            ->whereLanguage($post->language)
            ->whereKeyNot($post)
            ->latest('created_at')
            ->limit(2)
            ->get();

        $isUnpublished = $isAdmin && ! $post->is_active;

        return view('pages.blog.show', compact('post', 'relatedPosts', 'isUnpublished', 'isAdmin'));
    }
}
