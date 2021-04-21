<?php

namespace App\Http\Livewire;

use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use PDO;

class Gearpiece extends Component
{

    public Collection $gearpieces;
    public string $gearpieceType;
    public string $modelName = 'Hed_CAP000';

    public function mount(Collection $gearpieces, string $gearpieceType)
    {
        $this->gearpieces = $gearpieces;
        $this->gearpieceType = $gearpieceType;
    }

    public function render()
    {
        return view('livewire.gearpiece');
    }

    public function updateGearpieceImage($gpId)
    {
        $gp = null;

        // find the gp which matches what the user selected in the select html element
        foreach ($this->gearpieces as $gearpiece) {
            if ($gearpiece->id == $gpId) {
                $gp = $gearpiece;
                break;
            }
        }

        $this->modelName = $gp->gear_piece_id;
    }
}
