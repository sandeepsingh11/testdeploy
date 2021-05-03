<?php

namespace Database\Factories;

use App\Http\Controllers\GearAbstractController;
use App\Models\Gear;
use App\Models\GearPiece;
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
        $weaponsData = GearAbstractController::getSplatdata('Weapons');
        $wLen = sizeof($weaponsData) - 1;

        return [
            'gear_name' => $this->faker->words(5, true),
            'gear_desc' => $this->faker->sentence(10),
            'gear_mode_rm' => $this->faker->boolean(),
            'gear_mode_cb' => $this->faker->boolean(),
            'gear_mode_sz' => $this->faker->boolean(),
            'gear_mode_tc' => $this->faker->boolean(),
            'gear_weapon_id' => $weaponsData[$this->faker->numberBetween(0, $wLen)]['Id'],
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
