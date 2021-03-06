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
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'gear_title' => $this->faker->words(5, true),
            'gear_desc' => $this->faker->sentence(10),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
