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

    public function mainSkill()
    {
        return $this->belongsTo(Skill::class, 'main_skill_id');
    }

    public function subSkill1()
    {
        return $this->belongsTo(Skill::class, 'sub_1_skill_id');
    }

    public function subSkill2()
    {
        return $this->belongsTo(Skill::class, 'sub_2_skill_id');
    }

    public function subSkill3()
    {
        return $this->belongsTo(Skill::class, 'sub_3_skill_id');
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
