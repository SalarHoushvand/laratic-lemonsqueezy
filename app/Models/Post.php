<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;
use Spatie\Tags\HasTags;

/**
 * Model representing a blog post.
 *
 * Posts can be created in multiple languages and are automatically assigned
 * unique reference numbers and slugs upon creation.
 */
class Post extends Model
{
    /** @use HasTags<\Spatie\Tags\Tag> */
    use HasTags;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<string>|bool
     */
    protected $guarded = [];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_promoted' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Generate a unique reference number for the post.
     *
     * Format: REF-XXXXXX where XXXXXX is a zero-padded 6-digit number.
     */
    public static function createUniqueReferenceNumber(): string
    {
        $count = static::count();
        $referenceNumber = 'REF-'.str_pad((string) ($count + 1), 6, '0', STR_PAD_LEFT);

        while (static::where('reference_number', $referenceNumber)->exists()) {
            $count++;
            $referenceNumber = 'REF-'.str_pad((string) ($count + 1), 6, '0', STR_PAD_LEFT);
        }

        return $referenceNumber;
    }

    /**
     * Generate a unique slug from the given title.
     *
     * If the title generates an empty slug and a reference number is provided,
     * attempts to use the slug from the English version of the post.
     *
     * @param  string  $title  The post title to generate slug from
     * @param  string|null  $referenceNumber  The reference number to find related posts (optional)
     */
    public static function createUniqueSlug(string $title, ?string $referenceNumber = null): string
    {
        $slug = Str::slug($title);

        if (empty($slug) && $referenceNumber !== null) {
            $englishPost = static::where('reference_number', $referenceNumber)
                ->where('language', 'en')
                ->first();

            if ($englishPost && ! empty($englishPost->slug)) {
                $slug = $englishPost->slug;
            }
        }

        $originalSlug = $slug;
        $count = 1;

        while (static::where('slug', $slug)->exists()) {
            $slug = $originalSlug.'-'.$count;
            $count++;
        }

        return $slug;
    }

    /**
     * Boot the model and register event listeners.
     *
     * Automatically generates reference numbers and slugs when creating or updating posts.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($post) {
            if (empty($post->reference_number)) {
                $post->reference_number = static::createUniqueReferenceNumber();
            }

            if (empty($post->slug)) {
                $post->slug = static::createUniqueSlug(
                    $post->title,
                    $post->reference_number
                );
            }
        });

        static::updating(function ($post) {
            if ($post->isDirty('title') && empty($post->slug)) {
                $post->slug = static::createUniqueSlug(
                    $post->title,
                    $post->reference_number
                );
            }
        });
    }

    /**
     * Get the AI usage records associated with this post.
     *
     * @return BelongsToMany<\App\Models\AiUsage>
     */
    public function aiUsages(): BelongsToMany
    {
        return $this->belongsToMany(AiUsage::class, 'ai_usage_post');
    }

    /**
     * Scope a query to only include active posts.
     *
     * @param  Builder<Post>  $query
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include posts for a specific locale.
     *
     * @param  Builder<Post>  $query
     */
    public function scopeForLocale(Builder $query, string $locale): Builder
    {
        return $query->where('language', $locale);
    }

    /**
     * Scope a query to only include promoted posts.
     *
     * @param  Builder<Post>  $query
     */
    public function scopePromoted(Builder $query): Builder
    {
        return $query->where('is_promoted', true);
    }

    /**
     * Scope a query to filter posts by category slug.
     *
     * @param  Builder<Post>  $query
     */
    public function scopeInCategory(Builder $query, string $categorySlug, string $locale): Builder
    {
        return $query->whereHas('tags', function ($q) use ($categorySlug, $locale) {
            $q->where("slug->{$locale}", $categorySlug);
        });
    }
}
