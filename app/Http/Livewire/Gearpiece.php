<?php

namespace App\Http\Livewire;

use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use PDO;

class Gearpiece extends Component
{

    public Collection $gearpieces;
    public array $skills;
    public string $gearpieceType;
    public string $modelName = 'Hed_CAP000';
    public string $skillMain = 'unknown';
    public string $skillSub1 = 'unknown';
    public string $skillSub2 = 'unknown';
    public string $skillSub3 = 'unknown';
    public int $oldGearpiece = -1;

    public function mount(Collection $gearpieces, string $gearpieceType, array $skills, int $oldGearpiece = -1)
    {
        $this->gearpieces = $gearpieces;
        $this->gearpieceType = $gearpieceType;
        $this->skills = $skills;

        if ($oldGearpiece != -1) {
            $this->updateGearpiece($oldGearpiece);
        }
    }

    public function render()
    {
        return view('livewire.gearpiece');
    }

    public function updateGearpiece($gpId)
    {
        // if no pre-existing gp is selected, use default
        if ($gpId == -1) {
            $this->fill([
                'modelName' => 'Hed_CAP000',
                'skillMain' => 'unknown',
                'skillSub1' => 'unknown',
                'skillSub2' => 'unknown',
                'skillSub3' => 'unknown',
            ]);

            return;
        }

        // find the gp which matches what the user selected in the select html element
        foreach ($this->gearpieces as $gearpiece) {
            if ($gearpiece->id == $gpId) {
                $this->fill([
                    'modelName' => $gearpiece->gear_piece_id,
                    'skillMain' => $this->skills[$gearpiece->gear_piece_main]['skill'],
                    'skillSub1' => $this->skills[$gearpiece->gear_piece_sub_1]['skill'],
                    'skillSub2' => $this->skills[$gearpiece->gear_piece_sub_2]['skill'],
                    'skillSub3' => $this->skills[$gearpiece->gear_piece_sub_3]['skill'],
                ]);

                return;
            }
        }
    }
}
