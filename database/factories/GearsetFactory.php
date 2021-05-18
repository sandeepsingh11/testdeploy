<?php

namespace Database\Factories;

use App\Http\Controllers\GearAbstractController;
use App\Models\Gearset;
use Illuminate\Database\Eloquent\Factories\Factory;

class GearsetFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Gearset::class;

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
            'gearset_name' => $this->faker->words(5, true),
            'gearset_desc' => $this->faker->sentence(10),
            'gearset_mode_rm' => $this->faker->boolean(),
            'gearset_mode_cb' => $this->faker->boolean(),
            'gearset_mode_sz' => $this->faker->boolean(),
            'gearset_mode_tc' => $this->faker->boolean(),
            'gearset_weapon_id' => $weaponsData[$this->faker->numberBetween(0, $wLen)]['Id'],
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
