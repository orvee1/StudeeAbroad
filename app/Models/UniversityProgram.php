<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UniversityProgram extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'university_id'        => 'integer',
        'duration_months'      => 'integer',
        'tuition_per_year_min' => 'integer',
        'tuition_per_year_max' => 'integer',
        'intake_months'        => 'array',
        'is_active'            => 'boolean',
        'sort_order'           => 'integer',
    ];

    public function university()
    {
        return $this->belongsTo(University::class);
    }
}
