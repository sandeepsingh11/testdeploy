<?php

namespace Database\Factories;

use App\Http\Controllers\GearAbstractController;
use App\Models\GearPiece;
use Illuminate\Database\Eloquent\Factories\Factory;

class GearPieceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GearPiece::class;

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
            'gear_piece_name' => $this->faker->words(5, true),
            'gear_piece_desc' => $this->faker->sentence(10),
            'gear_piece_id' => fn (array $attributes) => $this->getGearpiece($attributes) ,
            'gear_piece_main' => $this->faker->numberBetween(0, 25), // not 26 to exclude 'unknown' skill
            'gear_piece_sub_1' => $this->getSubSkill(),
            'gear_piece_sub_2' => $this->getSubSkill(),
            'gear_piece_sub_3' => $this->getSubSkill(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Get a random gearpiece.
     * 
     * @param array $attributes Passed from the seeder
     * 
     * @return string The gearpiece name.
     */
    private function getGearpiece($attributes)
    {
        // get gearpiece type
        $gpType = $attributes['gear_piece_type'];

        if ($attributes['gear_piece_type'] === 'h')
            $gpType = 'Head';
        else if ($attributes['gear_piece_type'] === 'c')
            $gpType = 'Clothes';
        else if ($attributes['gear_piece_type'] === 's')
            $gpType = 'Shoes';

        
        // get according gearpiece
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
