<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class University extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'country_id'            => 'integer',
        'state_id'              => 'integer',
        'city_id'               => 'integer',

        'established_year'      => 'integer',

        'world_ranking'         => 'integer',
        'acceptance_rate'       => 'decimal:2',

        'tuition_min'           => 'integer',
        'tuition_max'           => 'integer',
        'living_cost_min'       => 'integer',
        'living_cost_max'       => 'integer',

        'application_fee'       => 'integer',
        'scholarship_available' => 'boolean',

        'is_featured'           => 'boolean',
        'is_active'             => 'boolean',
        'sort_order'            => 'integer',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function media()
    {
        return $this->hasMany(UniversityMedia::class);
    }

    public function programs()
    {
        return $this->hasMany(UniversityProgram::class);
    }
}
