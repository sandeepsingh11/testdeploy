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
        'base_gear_id',
    ];

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'gear_skill')->withPivot('skill_type');
    }

    public function baseGear()
    {
        return $this->belongsTo(BaseGear::class, 'base_gear_id');
    }

    public function gearsets()
    {
        return $this->belongsToMany(Gearset::class, 'gear_gearset');
    }
}
