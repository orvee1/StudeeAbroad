<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'phone', 'desired_country_id', 'desired_university_id',
        'desired_level', 'preferred_intake', 'source', 'status', 'message',
        'gender', 'date_of_birth', 'district', 'highest_education',
        'highest_education_passing_year', 'english_proficiency',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'highest_education_passing_year' => 'integer',
    ];

    public function desiredCountry()
    {
        return $this->belongsTo(Country::class, 'desired_country_id');
    }

    public function desiredUniversity()
    {
        return $this->belongsTo(University::class, 'desired_university_id');
    }
}
