<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ModerationResult extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'content_item_id',
        'flagged',
        'categories',
        'category_scores',
        'confidence',
    ];
    /**
     * The attributes that should be cast.
     * This tells Laravel how to handle special data types.
     */
    protected $casts = [
        'flagged' => 'boolean',       // Convert to PHP boolean
        'categories' => 'array',      // Convert JSON to PHP array
        'category_scores' => 'array', // Convert JSON to PHP array
        'confidence' => 'float',      // Convert to PHP float
    ];
    /**
     * Get the content item associated with this moderation result.
     */
    public function contentItem(): BelongsTo
    {
        return $this->belongsTo(ContentItem::class);
    }
}