<?php

namespace App\Http\Livewire;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Livewire\Component;
use PDO;

class Gear extends Component
{

    public array $defaultGearIds = ['h' => 'Hed_FST000', 'c' => 'Clt_FST001', 's' => 'Shs_FST000'];
    public Collection $gears;
    public Collection $skills;
    public string $gearType;
    public string $gearName = '';
    public string $skillMain = 'unknown';
    public string $skillSub1 = 'unknown';
    public string $skillSub2 = 'unknown';
    public string $skillSub3 = 'unknown';
    public int $oldGearId = -1;

    public function mount(Collection $gears, string $gearType, Collection $skills, Collection $oldGears = null)
    {
        $this->gears = $gears;
        $this->gearType = $gearType;
        $this->skills = $skills;
        $this->gearName = $this->defaultGearIds[$gearType[0]];


        // get old gear if passed
        if ($oldGears !== null) {

            // if old gear of type passed exists, update gear id and change on front end
            if (Arr::has($oldGears, Str::upper($gearType[0]))) {
                $this->oldGearId = $oldGears[Str::upper($gearType[0])]->id;

                $this->updateGear($this->oldGearId);
            }   
        }
    }

    public function render()
    {
        return view('livewire.gear');
    }

    public function updateGear($gearId)
    {
        // if no pre-existing gear is selected, use default
        if ($gearId == -1) {
            $this->fill([
                'gearName' => 'Hed_FST000',
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
            'gearName' => $selectedGear->baseGear->base_gear_name,
            'skillMain' => $this->skills->where('id', $selectedGear->main_skill_id)->first()->skill_name,
            'skillSub1' => $this->skills->where('id', $selectedGear->sub_1_skill_id)->first()->skill_name,
            'skillSub2' => $this->skills->where('id', $selectedGear->sub_2_skill_id)->first()->skill_name,
            'skillSub3' => $this->skills->where('id', $selectedGear->sub_3_skill_id)->first()->skill_name,
        ]);
    }
}
