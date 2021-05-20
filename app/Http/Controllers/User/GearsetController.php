<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GearAbstractController;
use App\Models\Gearset;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redirect;
use Prophecy\Argument\Token\InArrayToken;

class GearsetController extends Controller
{
    public function __construct()
    {
        // user must be logged in to view, otherwise redirect
        $this->middleware(['auth'])
            ->except(['index', 'show']);
    }

    public function index(User $user)
    {
        // get user's gearsets
        $userGearsets = $user->gearsets;

        // get gearsets' gears
        $userGears = [];
        foreach ($userGearsets as $gearset) {
            $userGears[$gearset->id] = $gearset->gears;
        }


        // get splatdata
        $splatdata = GearAbstractController::getSplatdata();


        // get view
        return view('users.gearsets.index', [
            'user' => $user,
            'gearsets' => $userGearsets,
            'gears' => $userGears,
            'splatdata' => $splatdata,
        ]);
    }

    public function show(User $user, Gearset $gearset)
    {
        // get gearset's gears
        $gears[$gearset->id] = $gearset->gears;
        
        // get splatdata
        $weapons = GearAbstractController::getSplatdata('Weapons');


        return view('users.gearsets.show', [
            'user' => $user,
            'gearset' => $gearset,
            'gears' => $gears,
            'weapons' => $weapons,
        ]);
    }

    public function create(User $user)
    {
        // get user's gearsets
        $userGears = $user->gears;

        // get splatdata
        $splatdata = GearAbstractController::getSplatdata();


        return view('users.gearsets.create', [
            'user' => $user,
            'gears' => $userGears,
            'splatdata' => $splatdata,
        ]);
    }

    public function store(Request $request, User $user)
    {
        // validate vals
        $this->validate($request, [
            'gearset-name' => 'max:256|string|nullable',
            'gearset-desc' => 'max:512|string|nullable',
            'gearset-mode-rm' => 'boolean',
            'gearset-mode-cb' => 'boolean',
            'gearset-mode-sz' => 'boolean',
            'gearset-mode-tc' => 'boolean',
            'gearset-weapon-id' => 'numeric|nullable',
            'gear-head-id' => 'numeric|nullable',
            'gear-clothes-id' => 'numeric|nullable',
            'gear-shoes-id' => 'numeric|nullable',
        ]);

        // if pre-existing gear was not selected, set to null
        ($request->input('gear-head-id') == -1) 
            ? $headId = NULL 
            : $headId = $request->input('gear-head-id');

        ($request->input('gear-clothes-id') == -1) 
            ? $clothesId = NULL 
            : $clothesId = $request->input('gear-clothes-id');

        ($request->input('gear-shoes-id') == -1) 
            ? $shoesId = NULL 
            : $shoesId = $request->input('gear-shoes-id');



        // create gearset record
        $newGearset = $request->user()->gearsets()->create([
            'gearset_name' => $request->input('gearset-name'),
            'gearset_desc' => $request->input('gearset-desc'),
            'gearset_mode_rm' => $request->boolean('gearset-mode-rm'),
            'gearset_mode_cb' => $request->boolean('gearset-mode-cb'),
            'gearset_mode_sz' => $request->boolean('gearset-mode-sz'),
            'gearset_mode_tc' => $request->boolean('gearset-mode-tc'),
            'gearset_weapon_id' => $request->input('gearset-weapon-id'),
        ]);

        // associate the head, clothing, and shoes gear to the new gearset in the pivot table
        $newGearset->gears()->attach($headId);
        $newGearset->gears()->attach($clothesId);
        $newGearset->gears()->attach($shoesId);
        

        
        return Redirect::route('gearsets', [$user]);
    }

    public function edit(User $user, Gearset $gearset)
    {
        // get all of user's gears
        $userGears = $user->gears;

        // get current gearset's gears
        $currentGears = $gearset->gears;
        
        // create index to each type of gear
        foreach ($currentGears as $gear) {
            $currentGears[$gear->gear_type] = $gear;
        }

        // get splatdata
        $splatdata = GearAbstractController::getSplatdata();


        return view('users.gearsets.edit', [
            'user' => $user,
            'gearset' => $gearset,
            'gears' => $userGears,
            'currentGears' => $currentGears,
            'splatdata' => $splatdata,
        ]);
    }

    public function update(Request $request, User $user, Gearset $gearset)
    {
        // validate vals
        $this->validate($request, [
            'gearset-name' => 'max:256|string|nullable',
            'gearset-desc' => 'max:512|string|nullable',
            'gearset-mode-rm' => 'boolean',
            'gearset-mode-cb' => 'boolean',
            'gearset-mode-sz' => 'boolean',
            'gearset-mode-tc' => 'boolean',
            'gearset-weapon-id' => 'numeric|nullable',
            'gear-head-id' => 'numeric|nullable',
            'gear-clothes-id' => 'numeric|nullable',
            'gear-shoes-id' => 'numeric|nullable',
        ]);

        // if pre-existing gear was not selected, set to null
        ($request->input('gear-head-id') == -1) 
            ? $headId = NULL 
            : $headId = $request->input('gear-head-id');

        ($request->input('gear-clothes-id') == -1) 
            ? $clothesId = NULL 
            : $clothesId = $request->input('gear-clothes-id');

        ($request->input('gear-shoes-id') == -1) 
            ? $shoesId = NULL 
            : $shoesId = $request->input('gear-shoes-id');



        // update gearset record
        $gearset->gearset_name = $request->input('gearset-name');
        $gearset->gearset_desc = $request->input('gearset-desc');
        $gearset->gearset_mode_rm = $request->boolean('gearset-mode-rm');
        $gearset->gearset_mode_cb = $request->boolean('gearset-mode-cb');
        $gearset->gearset_mode_sz = $request->boolean('gearset-mode-sz');
        $gearset->gearset_mode_tc = $request->boolean('gearset-mode-tc');
        $gearset->gearset_weapon_id = $request->input('gearset-weapon-id');

        // update if the model has new values
        if ($gearset->isDirty()) {
            $gearset->save();
        }





        // UPDATE PIVOT TABLE
        
        // get existing / old gears
        $oldGears = $gearset->gears;
        $oldGearIds = Arr::pluck($oldGears, 'id');

        // get submitted / "new" gears
        $submittedGearIds = [$headId, $clothesId, $shoesId];

        // compare submitted gears to the existing gears to add
        foreach ($submittedGearIds as $newGearId) {
            if ($newGearId !== null) {
                if (in_array($newGearId, $oldGearIds)) {
                    // gear submitted is the same as the old gear; do nothing
                }
                else {
                    // gear submitted is new; add to the gearset
                    $gearset->gears()->attach($newGearId);
                }
            }
        }

        // compare old gears to the new gears to remove
        foreach ($oldGearIds as $oldGearId) {
            if (in_array($oldGearId, $submittedGearIds)) {
                // old gear is a submitted gear; do nothing
            }
            else {
                // old gear was not submitted; remove from the gearset
                $gearset->gears()->detach($oldGearId);
            }
        }

        
        return Redirect::route('gearsets', [$user]);
    }

    public function destroy(User $user, Gearset $gearset)
    {
        // check if the current user can delete the specified gear
        $this->authorize('delete', $gearset);

        // delete this model instance
        $gearset->delete();

        return back();
    }
}
