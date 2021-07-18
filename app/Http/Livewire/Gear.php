<?php

namespace App\Http\Livewire;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Livewire\Component;
use PDO;

class Gear extends Component
{

    public array $defaultGearNames = ['H' => 'Hed_FST000', 'C' => 'Clt_FST001', 'S' => 'Shs_FST000'];
    public Collection $gears;
    public string $gearType;
    public string $gearName = '';
    public string $skillMain = 'unknown';
    public string $skillSub1 = 'unknown';
    public string $skillSub2 = 'unknown';
    public string $skillSub3 = 'unknown';
    public int $oldGearId = -1;

    public function mount(Collection $gears, string $gearType, Collection $oldGears = null)
    {
        $this->gearType = $gearType;
        $this->gearName = $this->defaultGearNames[$gearType[0]];

        // filter gears by type
        $this->gears = $this->filterUserGearsByType($gears);
        


        // get old gear if passed
        if ($oldGears !== null) {

            // if old gear of type passed exists, update gear id and change on front end
            if (Arr::has($oldGears, $gearType[0])) {
                $this->oldGearId = $oldGears[$gearType[0]]->id;

                $this->updateGear($this->oldGearId);
            }   
        }
    }

    public function render()
    {
        return view('livewire.gear');
    }

    /**
     * Filter the user's gears of the specified gear type (passed from the Livewire params).
     * 
     * @param Collection $gears The collection of gears from a user
     * 
     * @return Collection A filtered collection of the specified gear type.
     */
    public function filterUserGearsByType($gears)
    {
        $filteredGears = $gears->filter(function($gear, $key) {
            return ($gear->baseGears->base_gear_type == $this->gearType[0]);
        });

        return $filteredGears;
    }

    public function updateGear($gearId)
    {
        // if no pre-existing gear is selected, use default
        if ($gearId == -1) {
            $this->fill([
                'gearName' => $this->defaultGearNames[$this->gearType[0]],
                'skillMain' => 'unknown',
                'skillSub1' => 'unknown',
                'skillSub2' => 'unknown',
                'skillSub3' => 'unknown',
            ]);

            return;
        }

        // find the gear which matches what the user selected in the select html element
        $selectedGear = $this->gears->where('id', $gearId)->first();
        $this->fill([
            'gearName' => $selectedGear->baseGears->base_gear_name,
            'skillMain' => $selectedGear->getSkillName('Main'),
            'skillSub1' => $selectedGear->getSkillName('Sub1'),
            'skillSub2' => $selectedGear->getSkillName('Sub2'),
            'skillSub3' => $selectedGear->getSkillName('Sub3'),
        ]);
    }
}
