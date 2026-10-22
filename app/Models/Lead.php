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
