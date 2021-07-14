<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gearset extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'gearset_title',
        'gearset_desc',
        'gearset_mode_rm',
        'gearset_mode_cb',
        'gearset_mode_sz',
        'gearset_mode_tc',
        'weapon_id',
    ];

    public function gears()
    {
        return $this->belongsToMany(Gear::class, 'gear_gearset');
    }

    public function weapon()
    {
        return $this->belongsTo(Weapon::class);
    }

    /**
     * If a gearset has a missing gear(s), fill it in with a temporary gear to display on the front-end.
     * 
     * @return GearSet A prepared gearset with all 3 gear types.
     */
    public function prepareGearset()
    {
        $gearTypes = ['H', 'C', 'S'];
        $gearset = $this;

        if (sizeof($gearset->gears) < 3) {
            $gearTypesPresent = [];

            foreach($gearset->gears as $gear) {
                $gearTypesPresent[] = $gear->baseGears->base_gear_type;
            }

            $missingGearTypes = array_diff($gearTypes, $gearTypesPresent);
            foreach($missingGearTypes as $missingGearType) {
                $Gear = new Gear();
                $newGear = $Gear->makeDefaultGear($missingGearType);

                $gearset->gears->push($newGear);
            }
        }

        return $gearset;
    }

    /**
     * Order gears in head-clothing-shoes order.
     * 
     * @return GearSet A gearset with the gears in correct order.
     */
    public function orderGears()
    {
        $gearTypes = ['H', 'C', 'S'];
        $gearset = $this;
        $orderedGears = collect([]);

        foreach ($gearTypes as $gearType) {
            foreach ($gearset->gears as $gear) {
                if ($gear->baseGears->base_gear_type === $gearType) {
                    $orderedGears->push($gear);

                    break;
                }
            }
        }

        $gearset->gears = $orderedGears;

        
        return $gearset;
    }
}
