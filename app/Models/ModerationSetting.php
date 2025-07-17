<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModerationSetting extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'content_type',
        'flagged_categories',
        'confidence_threshold',
        'auto_approve',
    ];
    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'flagged_categories' => 'array',    // Convert JSON to PHP array
        'confidence_threshold' => 'float',  // Convert to PHP float
        'auto_approve' => 'boolean',        // Convert to PHP boolean
    ];
}