<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContentItem extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     * These fields can be set when creating or updating a model.
     */
    protected $fillable = [
        'user_id',
        'content_type',
        'content',
        'status',
    ];
    /**
     * Get the moderation result associated with this content item.
     * This establishes a one-to-one relationship with ModerationResult.
     */
    public function moderationResult(): HasOne
    {
        return $this->hasOne(ModerationResult::class);
    }
    /**
     * Get the user who created this content item.
     * This establishes a many-to-one relationship with User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}