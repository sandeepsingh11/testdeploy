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
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // prep gear piece values
        $gearType = $this->faker->randomElement(['Head', 'Clothes', 'Shoes']);
        $gear_piece_type = strtolower($gearType[0]);

        $gearData = GearAbstractController::getSplatdata($gearType);
        $gearModelName = $gearData[$this->faker->numberBetween(0, (sizeof($gearData) - 1))]['ModelName'];


        return [
            'gear_piece_name' => $this->faker->words(5, true),
            'gear_piece_desc' => $this->faker->sentence(10),
            'gear_piece_id' => $gearModelName,
            'gear_piece_main' => $this->faker->numberBetween(0, 26),
            'gear_piece_sub_1' => $this->faker->numberBetween(0, 26),
            'gear_piece_sub_2' => $this->faker->numberBetween(0, 26),
            'gear_piece_sub_3' => $this->faker->numberBetween(0, 26),
            'created_at' => now(),
            'updated_at' => now(),
            'gear_piece_type' => $gear_piece_type,
        ];
    }
}
