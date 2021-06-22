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
        $baseGears = new BaseGear();
        $skills = new Skill();

        // $gears = $user->gears()->with(['user'])->paginate(20);

        return view('users.gears.index', [
            'user' => $user,
            'gears' => $gears,
            'baseGears' => $baseGears->all(),
            'skills' => $skills->all()
        ]);
    }

    public function show(User $user, Gear $gear)
    {
        // get specified gear passed from uri
        $gear = $user->gears->where('id', $gear->id)->first();

        // get base gear
        $baseGear = new BaseGear();
        $baseGear = $baseGear->where('id', $gear->base_gear_id)->first();

        // get skills
        $skills = new Skill();
        
        return view('users.gears.show', [
            'user' => $user,
            'gear' => $gear,
            'baseGear' => $baseGear,
            'skills' => $skills->all()
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


        // prepare sub id's (if null, set skill id to 27 ('unknown'))
        $mainSkillId = ($request->get('skill-main') === null) ? 27 : $request->get('skill-main');
        $subSkill1Id = ($request->get('skill-sub-1') === null) ? 27 : $request->get('skill-sub-1');
        $subSkill2Id = ($request->get('skill-sub-2') === null) ? 27 : $request->get('skill-sub-2');
        $subSkill3Id = ($request->get('skill-sub-3') === null) ? 27 : $request->get('skill-sub-3');


        // create a gear piece THROUGH a user
        $request->user()->gears()->create([
            'gear_title' => $request->get('gear-title'),
            'gear_desc' => $request->get('gear-desc'),
            'base_gear_id' => $request->get('gear-id'),
            'main_skill_id' => $mainSkillId,
            'sub_1_skill_id' => $subSkill1Id,
            'sub_2_skill_id' => $subSkill2Id,
            'sub_3_skill_id' => $subSkill3Id,
        ]);

        return Redirect::route('gears', [$user]);
    }

    public function edit(User $user, Gear $gear)
    {
        // get according splatdata
        $baseGears = new BaseGear();
        $skills = new Skill();

        // get base gear name
        $baseGearName = $baseGears->where('id', $gear->base_gear_id)->first()->base_gear_name;


        // get this gear's skills
        $gearSkillNames = [];
        $gearSkillNames[] = $skills->where('id', $gear->main_skill_id)->first()->skill_name;
        $gearSkillNames[] = $skills->where('id', $gear->sub_1_skill_id)->first()->skill_name;
        $gearSkillNames[] = $skills->where('id', $gear->sub_2_skill_id)->first()->skill_name;
        $gearSkillNames[] = $skills->where('id', $gear->sub_3_skill_id)->first()->skill_name;



        return view('users.gears.edit', [
            'user' => $user,
            'gear' => $gear,
            'baseGears' => $baseGears->all(),
            'baseGearName' => $baseGearName,
            'gearSkillNames' => $gearSkillNames,
            'skillsData' => $skills->all(),
        ]);
    }

    public function update(Request $request, User $user, Gear $gear)
    {
        // validate vals
        $this->validate($request, [
            'gear-title' => 'max:255',
            'gear-desc' => 'max:512',
            'gear-id' => 'numeric|required',
            'skill-main' => 'numeric|nullable',
            'skill-sub-1' => 'numeric|nullable',
            'skill-sub-2' => 'numeric|nullable',
            'skill-sub-3' => 'numeric|nullable',
        ]);


        // prepare sub id's (if null, set skill id to 27 ('unknown'))
        $mainSkillId = ($request->get('skill-main') === null) ? 27 : $request->get('skill-main');
        $subSkill1Id = ($request->get('skill-sub-1') === null) ? 27 : $request->get('skill-sub-1');
        $subSkill2Id = ($request->get('skill-sub-2') === null) ? 27 : $request->get('skill-sub-2');
        $subSkill3Id = ($request->get('skill-sub-3') === null) ? 27 : $request->get('skill-sub-3');


        // update local gear var
        $gear->gear_title = $request->get('gear-title');
        $gear->gear_desc = $request->get('gear-desc');
        $gear->base_gear_id = $request->get('gear-id');
        $gear->main_skill_id = $mainSkillId;
        $gear->sub_1_skill_id = $subSkill1Id;
        $gear->sub_2_skill_id = $subSkill2Id;
        $gear->sub_3_skill_id = $subSkill3Id;
        
        
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
