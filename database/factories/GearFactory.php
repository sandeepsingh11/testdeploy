<?php

namespace Database\Factories;

use App\Models\Gear;
use App\Models\Skill;
use Illuminate\Database\Eloquent\Factories\Factory;

class GearFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Gear::class;

    /**
     * Skill model.
     * 
     * @var Skill
     */
    protected $skill;

    /**
     * Holds all of the skills.
     * 
     * @var Collection
     */
    protected $skills;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $this->skill = new Skill();

        return [
            'gear_title' => $this->faker->words(5, true),
            'gear_desc' => $this->faker->sentence(10),
            'main_skill_id' => $this->skill->all()->except(27)->random(),
            'sub_1_skill_id' => $this->getSubSkill(),
            'sub_2_skill_id' => $this->getSubSkill(),
            'sub_3_skill_id' => $this->getSubSkill(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Get a skill that is not of type 'Main'
     * 
     * @return int
     */
    private function getSubSkill()
    {
        return $this->skill->all()->where('is_main', false)->except(27)->random();
    }
}
