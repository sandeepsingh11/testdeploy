<?php

namespace Database\Factories;

use App\Models\BaseGear;
use Illuminate\Database\Eloquent\Factories\Factory;

class BaseGearFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BaseGear::class;
    
    /**
     * This Base Gear's Id'.
     *
     * @var int
     */
    protected $id;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => fn (array $attributes) => $this->getBaseGearId($attributes),
        ];
    }

    /**
     * Get a Base Gear's Id for a given gear type.
     * 
     * @param array $attributes Passed from the seeder
     * 
     * @return int Base Gear's Id
     */
    public function getBaseGearId($attributes) {
        $gearType = $attributes['base_gear_type'];
        $baseGear = new BaseGear();
        $baseGear = $baseGear->all()->where('base_gear_type', $gearType)->random();
        
        return $baseGear->id;
    }
}
