<?php

namespace App\Http\Livewire;

use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Weapon extends Component
{
    public Collection $weapons;
    public string $weaponName = 'Shooter_Short_00';
    public string $specialName = 'SuperLanding';
    public string $subName = 'Bomb_Curling';
    public int $oldWeaponId = -1;

    public function mount(Collection $weapons, int $oldWeaponId = -1)
    {
        $this->weapons = $weapons;


        if ($oldWeaponId != -1) {
            $this->updateWeapon($oldWeaponId);
        }
    }

    public function render()
    {
        return view('livewire.weapon');
    }

    public function updateWeapon($weaponId)
    {
        // get the weapon that the user selected in the select element
        $weapon = $this->weapons->where('id', $weaponId)->first();
        $this->weaponName = $weapon->weapon_name;
        
        // update weapon special
        $this->specialName = $weapon->special->special_name;
        
        // update weapon sub
        $this->subName = $weapon->sub->sub_name;
    }
}
