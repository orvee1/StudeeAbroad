<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UniversityMedia extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'university_id' => 'integer',
        'file_size'     => 'integer',
        'is_active'     => 'boolean',
        'sort_order'    => 'integer',
    ];

    public function university()
    {
        return $this->belongsTo(University::class);
    }
}
