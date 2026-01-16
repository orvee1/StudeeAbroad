<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'state_id'   => 'integer',
        'latitude'   => 'decimal:7',
        'longitude'  => 'decimal:7',
        'is_active'  => 'boolean',
        'sort_order' => 'integer',
    ];

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function universities()
    {
        return $this->hasMany(University::class);
    }
}
