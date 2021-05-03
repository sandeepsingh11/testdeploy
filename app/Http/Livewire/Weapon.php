<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Weapon extends Component
{
    public array $weapons;
    public string $weaponName = 'Shooter_Short_00';
    public string $specialName = 'SuperLanding';
    public string $subName = 'Bomb_Curling';
    public int $oldWeapon = -1;

    public function mount(int $oldWeapon = -1)
    {
        if ($oldWeapon != -1) {
            $this->updateWeapon($oldWeapon);
        }
    }

    public function render()
    {
        return view('livewire.weapon');
    }

    public function updateWeapon($weaponId)
    {
        // find the weapon which matches what the user selected in the select html element
        foreach ($this->weapons as $weapon) {
            if ($weapon['Id'] == $weaponId) {
                // update weapon name
                $this->weaponName = $weapon['Name'];
                // update weapon special
                $this->specialName = $weapon['Special'];
                // update weapon sub
                $this->subName = $weapon['Sub'];

                return;
            }
        }
    }
}
