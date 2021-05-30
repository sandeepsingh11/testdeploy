<?php

namespace App\Http\Livewire;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Livewire\Component;
use PDO;

class Gear extends Component
{

    public array $defaultGearIds = ['h' => 'Hed_FST000', 'c' => 'Clt_FST001', 's' => 'Shs_FST000'];
    public Collection $gears;
    public array $skills;
    public string $gearType;
    public string $modelName = '';
    public string $skillMain = 'unknown';
    public string $skillSub1 = 'unknown';
    public string $skillSub2 = 'unknown';
    public string $skillSub3 = 'unknown';
    public int $oldGear = -1;

    public function mount(Collection $gears, string $gearType, array $skills, Collection $oldGears = null)
    {
        $this->gears = $gears;
        $this->gearType = $gearType;
        $this->skills = $skills;
        $this->modelName = $this->defaultGearIds[$gearType[0]];


        // get old gear if passed
        if ($oldGears !== null) {
            if (Arr::has($oldGears, $gearType[0])) {
                $this->oldGear = $oldGears[$gearType[0]]->id;

                $this->updateGear($this->oldGear);
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
                'modelName' => 'Hed_CAP000',
                'skillMain' => 'unknown',
                'skillSub1' => 'unknown',
                'skillSub2' => 'unknown',
                'skillSub3' => 'unknown',
            ]);

            return;
        }

        // find the gear which matches what the user selected in the select html element
        foreach ($this->gears as $gear) {
            if ($gear->id == $gearId) {
                $this->fill([
                    'modelName' => $gear->gear_id,
                    'skillMain' => $this->skills[$gear->gear_main]['skill'],
                    'skillSub1' => $this->skills[$gear->gear_sub_1]['skill'],
                    'skillSub2' => $this->skills[$gear->gear_sub_2]['skill'],
                    'skillSub3' => $this->skills[$gear->gear_sub_3]['skill'],
                ]);

                return;
            }
        }
    }
}