<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gear extends Model
{
    use HasFactory;

    public $defaultBaseGearIds = ['H' => 1, 'C' => 162, 'S' => 418];
    public $defaultBaseGearNames = ['H' => 'Hed_FST000', 'C' => 'Clt_FST001', 'S' => 'Shs_FST000'];

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

    public function baseGears()
    {
        return $this->belongsTo(BaseGear::class, 'base_gear_id');
    }

    public function gearsets()
    {
        return $this->belongsToMany(Gearset::class, 'gear_gearset');
    }

    /**
     * Get the specified skill id.
     * 
     * @param string $skillType id of the skill type ('Main', 'Sub1', 'Sub2', 'Sub3')
     * 
     * @return int id of the skill. If no skill of the specified type exists, return id 27 ('unknown')
     */
    public function getSkillId($skillType)
    {
        $currentGear = $this;

        foreach ($currentGear->skills as $skill) {
            if ($skill->pivot->skill_type === $skillType) return $skill->id;
        }

        // if no skill found, return 'unknown'
        return 27;
    }
    
    /**
     * Get the specified skill name.
     * 
     * @param string $skillType Name of the skill type ('Main', 'Sub1', 'Sub2', 'Sub3')
     * 
     * @return string Name of the skill. If no skill of the specified type exists, return the 'unknown' skill
     */
    public function getSkillName($skillType)
    {
        $currentGear = $this;

        foreach ($currentGear->skills as $skill) {
            if ($skill->created_at) {
                if ($skill->pivot->skill_type === $skillType) return $skill->skill_name;
            }
        }

        // if no skill found, return 'unknown'
        return 'unknown';
    }

    /**
     * Make a default gear model of the specified type.
     * 
     * @param string $gearType The type of gear to make ('H', 'C', 'S')
     * 
     * @return Gear A Gear instance of the created gear
     */
    public function makeDefaultGear($gearType)
    {
        $newGear = new Gear([
            'gear_title' => '',
            'gear_desc' => '',
            'base_gear_id' => $this->defaultBaseGearIds[$gearType],
        ]);
        $newGear->baseGears->base_gear_name = $this->defaultBaseGearNames[$gearType];


        $newSkill = new Skill();
        $newSkill = $newSkill->makeDefaultSkill();
        $newGear->skills = collect([$newSkill, $newSkill, $newSkill, $newSkill]);

        return $newGear;
    }
}
