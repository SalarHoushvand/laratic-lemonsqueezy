<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Model representing AI usage tracking for user operations.
 *
 * Tracks token usage, costs, and metadata for AI-powered features.
 */
class AiUsage extends Model
{
    /** @use HasFactory<\Database\Factories\AiUsageFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'model',
        'prompt_tokens',
        'output_tokens',
        'total_tokens',
        'total_cost',
        'currency',
        'meta',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'prompt_tokens' => 'integer',
            'output_tokens' => 'integer',
            'total_tokens' => 'integer',
            'total_cost' => 'decimal:4',
            'meta' => 'array',
        ];
    }

    /**
     * Get the user that owns this AI usage record.
     *
     * @return BelongsTo<\App\Models\User, self>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the posts associated with this AI usage record.
     *
     * @return BelongsToMany<\App\Models\Post>
     */
    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'ai_usage_post');
    }
}
