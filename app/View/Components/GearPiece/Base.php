<?php

namespace App\View\Components\GearPiece;

use Illuminate\View\Component;

class Base extends Component
{
    /**
     * The gearpiece object.
     *
     * @var GearPiece
     */
    public $gearpiece;

    /**
     * An array of the 4 skill names.
     *
     * @var array
     */
    public $skills;

    /**
     * The user object.
     *
     * @var User
     */
    public $user;

    /**
     * Create a new component instance.
     *
     * @param  GearPiece  $gearpiece
     * @param  array  $skills
     * @param  User  $user
     * @return void
     */
    public function __construct($gearpiece, $skills, $user)
    {
        $this->gearpiece = $gearpiece;
        $this->skills = $skills;
        $this->user = $user;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.gear-piece.base');
    }
}
