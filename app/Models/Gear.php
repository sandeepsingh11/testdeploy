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
        'main_skill_id',
        'sub_1_skill_id',
        'sub_2_skill_id',
        'sub_3_skill_id',
    ];

    public function skills()
    {
        return $this->hasMany(Skill::class);
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
