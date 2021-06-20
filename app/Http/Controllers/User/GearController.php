<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GearAbstractController;
use App\Models\BaseGear;
use App\Models\Gear;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class GearController extends GearAbstractController
{
    public function __construct()
    {
        // user must be a guest to view, otherwise redirect
        $this->middleware(['auth'])
            ->except(['index', 'show']);
    }

    public function index(User $user)
    {
        // get user's gear
        $gears = $user->gears;

        // $gears = $user->gears()->with(['user'])->paginate(20);


        return view('users.gears.index', [
            'user' => $user,
            'gears' => $gears,
        ]);
    }

    public function show(User $user, Gear $gear)
    {
        // get specified gear passed from uri
        $gear = $user->gears->where('id', $gear->id)->first();
        
        return view('users.gears.show', [
            'user' => $user,
            'gear' => $gear
        ]);
    }

    public function create(User $user)
    {
        // get according splatdata
        $skills = new Skill();
        $baseGears = new BaseGear();



        return view('users.gears.create', [
            'user' => $user,
            'gears' => $baseGears->all(),
            'skills' => $skills->all(),
        ]);
    }

    public function store(Request $request, User $user)
    {
        // validate input
        $this->validate($request, [
            'gear-title' => 'max:255',
            'gear-desc' => 'max:512',
            'gear-id' => 'numeric|required',
            'skill-main' => 'numeric|nullable',
            'skill-sub-1' => 'numeric|nullable',
            'skill-sub-2' => 'numeric|nullable',
            'skill-sub-3' => 'numeric|nullable',
        ]);


        // create a gear piece THROUGH a user
        $request->user()->gears()->create([
            'gear_title' => $request->get('gear-title'),
            'gear_desc' => $request->get('gear-desc'),
            'base_gear_id' => $request->get('gear-id'),
            'main_skill_id' => $request->get('skill-main'),
            'sub_1_skill_id' => $request->get('skill-sub-1'),
            'sub_2_skill_id' => $request->get('skill-sub-2'),
            'sub_3_skill_id' => $request->get('skill-sub-3'),
        ]);

        return Redirect::route('gears', [$user]);
    }

    public function edit(User $user, Gear $gear)
    {
        // get according splatdata
        $headData = GearAbstractController::getSplatdata('Head');
        $clothesData = GearAbstractController::getSplatdata('Clothes');
        $shoesData = GearAbstractController::getSplatdata('Shoes');
        $skillsData = GearAbstractController::getSplatdata('Skills');

        // combine gears into 1 array
        $gears = [
            $headData, 
            $clothesData, 
            $shoesData
        ];


        // get this gear's skill names
        $gearSkills = $this->getGearSkills($gear);



        return view('users.gears.edit', [
            'user' => $user,
            'gear' => $gear,
            'gears' => $gears,
            'gearSkills' => $gearSkills,
            'skillsData' => $skillsData,
        ]);
    }

    public function update(Request $request, User $user, Gear $gear)
    {
        // validate vals
        $this->validate($request, [
            'gear-name' => 'max:255',
            'gear-desc' => 'max:512',
            'gear-id' => 'required|max:64',
            'gear-main' => 'numeric|nullable',
            'gear-sub-1' => 'numeric|nullable',
            'gear-sub-2' => 'numeric|nullable',
            'gear-sub-3' => 'numeric|nullable',
        ]);

        // get gear type
        $baseId = explode('_', $request->get('gear-id'))[0];
        $gearType = '';
        if ($baseId == 'Hed') {
            // head gear
            $gearType = 'h';
        }
        else if ($baseId == 'Clt') {
            // clothing gear
            $gearType = 'c';
        }
        else {
            // shoes gear
            $gearType = 's';
        }



        // update local gear var
        $gear->gear_name = $request->get('gear-name');
        $gear->gear_desc = $request->get('gear-desc');
        $gear->gear_id = $request->get('gear-id');
        $gear->gear_type = $gearType;
        $gear->gear_main = $request->get('gear-main');
        $gear->gear_sub_1 = $request->get('gear-sub-1');
        $gear->gear_sub_2 = $request->get('gear-sub-2');
        $gear->gear_sub_3 = $request->get('gear-sub-3');
        
        
        // update model in db if it has new values (is dirty)
        if ($gear->isDirty()) {
            $gear->save();
        }


        
        return redirect(route('gears', [$user]));
    }

    public function destroy(User $user, Gear $gear)
    {
        // check if the current user can delete the specified gear piece
        $this->authorize('delete', $gear);

        // delete this model instance
        $gear->delete();

        return back();
    }
}
