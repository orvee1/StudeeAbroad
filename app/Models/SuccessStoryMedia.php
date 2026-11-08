<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuccessStoryMedia extends Model
{
    use HasFactory;

    protected $fillable = [
        'success_story_id',
        'type',
        'caption',
        'file_path',
        'mime_type',
        'file_size',
        'sort_order',
        'is_public',
    ];

    protected $casts = [
        'success_story_id' => 'integer',
        'file_size' => 'integer',
        'sort_order' => 'integer',
        'is_public' => 'boolean',
    ];

    public function successStory()
    {
        return $this->belongsTo(SuccessStory::class);
    }

    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'passport' => 'Passport',
            'visa' => 'Visa',
            'admission' => 'University admission',
            default => 'Student document',
        };
    }
}
