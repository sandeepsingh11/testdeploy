<?php

namespace App\View\Components\Gear;

use Illuminate\View\Component;

class Base extends Component
{
    /**
     * The gear object.
     *
     * @var Gear
     */
    public $gear;

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
     * @param  Gear  $gear
     * @param  array  $skills
     * @param  User  $user
     * @return void
     */
    public function __construct($gear, $skills, $user)
    {
        $this->gear = $gear;
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
        return view('components.gear.base');
    }
}
