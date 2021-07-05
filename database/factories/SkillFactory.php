<?php

namespace Database\Factories;

use App\Models\Skill;
use Illuminate\Database\Eloquent\Factories\Factory;

class SkillFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Skill::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => fn(array $attributes) => $this->getSkillId($attributes)
        ];
    }

    /**
     * Get a skill's id.
     * 
     * @param array $attributes passed from the seeder
     * 
     * @return int the skill's id
     */
    public function getSkillId($attributes)
    {
        $skills = new Skill();
        $isMain = false;

        if ($attributes['skill_type'] === 'Main') $isMain = true;

        return $skills->all()->except(27)->where('is_main', $isMain)->random()->id;
    }
}
