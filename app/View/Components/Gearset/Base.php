<?php

namespace App\View\Components\Gearset;

use Illuminate\View\Component;

class Base extends Component
{
    /**
     * The gearset object.
     *
     * @var Gearset
     */
    public $gearset;

    /**
     * The gears array.
     *
     * @var array
     */
    public $gears;

    /**
     * The user object.
     *
     * @var User
     */
    public $user;

    /**
     * The weapons array.
     *
     * @var array
     */
    public $weapons;

    /**
     * Create a new component instance.
     *
     * @param  Gearset  $gearset
     * @param  array  $gears
     * @param  User  $user
     * @param  array  $weapons
     * @return void
     */
    public function __construct($gearset, $gears, $user, $weapons)
    {
        $this->gearset = $gearset;
        $this->gears = $gears;
        $this->user = $user;
        $this->weapons = $weapons;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.gearset.base');
    }
}
