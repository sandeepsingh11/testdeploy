<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

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

    /**
     * Add new gears and remove old gears from the gear_gearset pivot table.
     * 
     * @param int $headId Id of the submitted head gear
     * @param int $clothesId Id of the submitted clothes gear
     * @param int $shoesId Id of the submitted shoes gear
     * 
     * @return void
     */
    public function updatePivot($headId, $clothesId, $shoesId)
    {
        $gearset = $this;

        // get existing / old gears
        $oldGears = $gearset->gears;
        $oldGearIds = Arr::pluck($oldGears, 'id');

        // get submitted / "new" gears
        $submittedGearIds = [$headId, $clothesId, $shoesId];


        // compare submitted gears to the existing gears to add
        foreach ($submittedGearIds as $newGearId) {
            if ($newGearId !== null) {
                if (in_array($newGearId, $oldGearIds)) {
                    // gear submitted is the same as the old gear; do nothing
                }
                else {
                    // gear submitted is new; add to the gearset
                    $gearset->gears()->attach($newGearId);
                }
            }
        }


        // compare old gears to the new gears to remove
        foreach ($oldGearIds as $oldGearId) {
            if (in_array($oldGearId, $submittedGearIds)) {
                // old gear is a submitted gear; do nothing
            }
            else {
                // old gear was not submitted; remove from the gearset
                $gearset->gears()->detach($oldGearId);
            }
        }
    }
}
