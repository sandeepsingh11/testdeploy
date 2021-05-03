<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GearAbstractController;
use App\Models\Gear;
use App\Models\User;
use Illuminate\Http\Request;

class GearController extends Controller
{
    public function __construct()
    {
        // user must be logged in to view, otherwise redirect
        $this->middleware(['auth'])
            ->except(['index', 'show']);
    }

    public function index(User $user)
    {
        // get user's gears
        $userGears = $user->gears;

        // get gears' gearpieces
        $userGearpieces = [];
        foreach ($userGears as $gear) {
            $userGearpieces[$gear->id] = $gear->gearpieces;
        }

        // get splatdata
        $splatdata = GearAbstractController::getSplatdata();


        // get view
        return view('users.gear.index', [
            'user' => $user,
            'gears' => $userGears,
            'gearpieces' => $userGearpieces,
            'splatdata' => $splatdata,
        ]);
    }

    public function show(User $user, Gear $gear)
    {
        // get gears' gearpieces
        $gearpieces[$gear->id] = $gear->gearpieces;
        
        // get splatdata
        $weapons = GearAbstractController::getSplatdata('Weapons');


        return view('users.gear.show', [
            'user' => $user,
            'gear' => $gear,
            'gearpieces' => $gearpieces,
            'weapons' => $weapons,
        ]);
    }

    public function create(User $user)
    {
        // get user's gear pieces
        $userGearPieces = $user->gearpieces;

        // get splatdata
        $splatdata = GearAbstractController::getSplatdata();


        return view('users.gear.create', [
            'user' => $user,
            'gearpieces' => $userGearPieces,
            'splatdata' => $splatdata,
        ]);
    }

    public function store(Request $request, User $user)
    {
        // validate vals
        $this->validate($request, [
            'gear-name' => 'max:256|string|nullable',
            'gear-desc' => 'max:512|string|nullable',
            'gear-mode-rm' => 'boolean',
            'gear-mode-cb' => 'boolean',
            'gear-mode-sz' => 'boolean',
            'gear-mode-tc' => 'boolean',
            'gear-weapon-id' => 'numeric|nullable',
            'gear-piece-h-id' => 'numeric|nullable',
            'gear-piece-c-id' => 'numeric|nullable',
            'gear-piece-s-id' => 'numeric|nullable',
        ]);

        // if pre-existing gp was not selected, set to null
        ($request->input('gear-head-id') == -1) 
            ? $headId = NULL 
            : $headId = $request->input('gear-head-id');

        ($request->input('gear-clothes-id') == -1) 
            ? $clothesId = NULL 
            : $clothesId = $request->input('gear-clothes-id');

        ($request->input('gear-shoes-id') == -1) 
            ? $shoesId = NULL 
            : $shoesId = $request->input('gear-shoes-id');



        // create gear record
        $newGear = $request->user->gears()->create([
            'gear_name' => $request->input('gear-name'),
            'gear_desc' => $request->input('gear-desc'),
            'gear_mode_rm' => $request->boolean('gear-mode-rm'),
            'gear_mode_cb' => $request->boolean('gear-mode-cb'),
            'gear_mode_sz' => $request->boolean('gear-mode-sz'),
            'gear_mode_tc' => $request->boolean('gear-mode-tc'),
            'gear_weapon_id' => $request->input('gear-weapon-id'),
        ]);

        // associate the head, clothing, and shoes gearpiece to the new gear in the pivot table
        $newGear->gearpieces()->attach($headId);
        $newGear->gearpieces()->attach($clothesId);
        $newGear->gearpieces()->attach($shoesId);
        

        
        return back();
    }

    public function edit(User $user, Gear $gear)
    {
        // get all of user's gearpieces
        $userGearPieces = $user->gearpieces;

        // get current gear's gearpieces
        $currentGearpieces = $gear->gearpieces;
        
        // create index to each type of gearpiece
        foreach ($currentGearpieces as $gp) {
            $currentGearpieces[$gp->gear_piece_type] = $gp;
        }

        // get splatdata
        $splatdata = GearAbstractController::getSplatdata();


        return view('users.gear.edit', [
            'user' => $user,
            'gear' => $gear,
            'gearpieces' => $userGearPieces,
            'currentGearpieces' => $currentGearpieces,
            'splatdata' => $splatdata,
        ]);
    }

    public function update(Request $request, User $user, Gear $gear)
    {
        // validate vals
        $this->validate($request, [
            'gear-name' => 'max:256|string|nullable',
            'gear-desc' => 'max:512|string|nullable',
            'gear-mode-rm' => 'boolean',
            'gear-mode-cb' => 'boolean',
            'gear-mode-sz' => 'boolean',
            'gear-mode-tc' => 'boolean',
            'gear-weapon-id' => 'numeric|nullable',
            'gear-piece-h-id' => 'numeric|nullable',
            'gear-piece-c-id' => 'numeric|nullable',
            'gear-piece-s-id' => 'numeric|nullable',
        ]);

        // if pre-existing gp was not selected, set to null
        ($request->input('gear-head-id') == -1) 
            ? $headId = NULL 
            : $headId = $request->input('gear-head-id');

        ($request->input('gear-clothes-id') == -1) 
            ? $clothesId = NULL 
            : $clothesId = $request->input('gear-clothes-id');

        ($request->input('gear-shoes-id') == -1) 
            ? $shoesId = NULL 
            : $shoesId = $request->input('gear-shoes-id');



        // update gear record
        $gear->gear_name = $request->input('gear-name');
        $gear->gear_desc = $request->input('gear-desc');
        $gear->gear_mode_rm = $request->boolean('gear-mode-rm');
        $gear->gear_mode_cb = $request->boolean('gear-mode-cb');
        $gear->gear_mode_sz = $request->boolean('gear-mode-sz');
        $gear->gear_mode_tc = $request->boolean('gear-mode-tc');
        $gear->gear_weapon_id = $request->input('gear-weapon-id');

        // update if the model has new values
        if ($gear->isDirty()) {
            $gear->save();
        }



        // get old gearpieces
        $oldGps = $gear->gearpieces;

        // create index to each type of gearpiece
        foreach ($oldGps as $gp) {
            $oldGps[$gp->gear_piece_type] = $gp;
        }

        // update pivot table
        $gear->gearpieces()->updateExistingPivot($oldGps['h'], ['gear_piece_id' => $headId]);
        $gear->gearpieces()->updateExistingPivot($oldGps['c'], ['gear_piece_id' => $clothesId]);
        $gear->gearpieces()->updateExistingPivot($oldGps['s'], ['gear_piece_id' => $shoesId]);

        
        return back();
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
