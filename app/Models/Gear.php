<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gear extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'gear_title',
        'gear_desc',
    ];

    public function skills()
    {
        return $this->hasMany(Skill::class);
    }

    public function gearsets()
    {
        return $this->belongsToMany(Gearset::class, 'gear_gearset');
    }
}
