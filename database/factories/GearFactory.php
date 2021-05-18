<?php

namespace Database\Factories;

use App\Http\Controllers\GearAbstractController;
use App\Models\Gear;
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
     * Holds all of the skills.
     * 
     * @var array
     */
    protected $skills;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // populate skills
        $this->skills = GearAbstractController::getSplatdata('Skills');

        return [
            'gear_name' => $this->faker->words(5, true),
            'gear_desc' => $this->faker->sentence(10),
            'gear_id' => fn (array $attributes) => $this->getGear($attributes) ,
            'gear_main' => $this->faker->numberBetween(0, 25), // not 26 to exclude 'unknown' skill
            'gear_sub_1' => $this->getSubSkill(),
            'gear_sub_2' => $this->getSubSkill(),
            'gear_sub_3' => $this->getSubSkill(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Get a random gear.
     * 
     * @param array $attributes Passed from the seeder
     * 
     * @return string The gear name.
     */
    private function getGear($attributes)
    {
        // get gear type
        $gpType = $attributes['gear_type'];

        if ($attributes['gear_type'] === 'h')
            $gpType = 'Head';
        else if ($attributes['gear_type'] === 'c')
            $gpType = 'Clothes';
        else if ($attributes['gear_type'] === 's')
            $gpType = 'Shoes';

        
        // get according gear
        $gearData = GearAbstractController::getSplatdata($gpType);
        $gearModelName = $gearData[$this->faker->numberBetween(0, (sizeof($gearData) - 1))]['ModelName'];
        
        return $gearModelName;
    }

    /**
     * Get a skill that is not of type 'Main'
     * 
     * @return int
     */
    private function getSubSkill()
    {
        do {
            // index
            $i = $this->faker->numberBetween(0, 26);

            // generate rand num again if the skill is of type 'Main'
        } while ($this->skills[$i]['allowed'] === 'Main');

        return $i;
    }
}
