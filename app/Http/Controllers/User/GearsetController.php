<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GearAbstractController;
use App\Models\Gear;
use App\Models\Gearset;
use App\Models\Skill;
use App\Models\Special;
use App\Models\Sub;
use App\Models\User;
use App\Models\Weapon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
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
        $gearsets = $user->gearsets->load(['gears.baseGears', 'gears.skills', 'weapon']);
        

        // prep gearsets to display them properly
        foreach($gearsets as $gearset) {
            // fill in a gearset with temp gears if it does not have all 3 gears
            $gearset = $gearset->prepareGearset();

            // order the gears from h->c->s
            $gearset = $gearset->orderGears();
        }
        
        

        // get view
        return view('users.gearsets.index', [
            'user' => $user,
            'gearsets' => $gearsets,
        ]);
    }

    public function show(User $user, Gearset $gearset)
    {
        // get user's gearsets
        $gearset = $gearset->load(['gears.baseGears', 'gears.skills', 'weapon']);


        return view('users.gearsets.show', [
            'user' => $user,
            'gearset' => $gearset,
        ]);
    }

    public function create(User $user)
    {
        // get user's gearsets
        $userGears = $user->gears;

        // get splatdata
        $weapons = new Weapon();
        $specials = new Special();
        $subs = new Sub();
        $skills = new Skill();


        return view('users.gearsets.create', [
            'user' => $user,
            'gears' => $userGears,
            'weapons' => $weapons->all(),
            'specials' => $specials->all(),
            'subs' => $subs->all(),
            'skills' => $skills->all(),
        ]);
    }

    public function store(Request $request, User $user)
    {
        // validate vals
        $this->validate($request, [
            'gearset-title' => 'max:256|string|nullable',
            'gearset-desc' => 'max:512|string|nullable',
            'gearset-mode-rm' => 'boolean',
            'gearset-mode-cb' => 'boolean',
            'gearset-mode-sz' => 'boolean',
            'gearset-mode-tc' => 'boolean',
            'gearset-weapon-id' => 'numeric',
            'gear-head-id' => 'numeric|nullable',
            'gear-clothes-id' => 'numeric|nullable',
            'gear-shoes-id' => 'numeric|nullable',
        ]);

        

        // prepare selected gears (if pre-existing gear was not selected, set to default gear)
        $headId = ($request->get('gear-head-id') == -1) ? null : $request->get('gear-head-id');
        $clothesId = ($request->get('gear-clothes-id') == -1) ? null : $request->get('gear-clothes-id');
        $shoesId = ($request->get('gear-shoes-id') == -1) ? null : $request->get('gear-shoes-id');



        // create gearset record
        $newGearset = $request->user()->gearsets()->create([
            'gearset_title' => $request->input('gearset-title'),
            'gearset_desc' => $request->input('gearset-desc'),
            'gearset_mode_rm' => $request->boolean('gearset-mode-rm'),
            'gearset_mode_cb' => $request->boolean('gearset-mode-cb'),
            'gearset_mode_sz' => $request->boolean('gearset-mode-sz'),
            'gearset_mode_tc' => $request->boolean('gearset-mode-tc'),
            'weapon_id' => $request->input('gearset-weapon-id'),
        ]);


        // associate the head, clothing, and shoes gear to the new gearset in the pivot table (if not null)
        if ($headId !== null) $newGearset->gears()->attach($headId);
        if ($clothesId !== null) $newGearset->gears()->attach($clothesId);
        if ($shoesId !== null) $newGearset->gears()->attach($shoesId);
        

        
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
            $currentGears[$gear->baseGear->base_gear_type] = $gear;
        }

        // get splatdata
        $weapons = new Weapon();
        $specials = new Special();
        $subs = new Sub();
        $skills = new Skill();


        return view('users.gearsets.edit', [
            'user' => $user,
            'gearset' => $gearset,
            'gears' => $userGears,
            'currentGears' => $currentGears,
            'weapons' => $weapons->all(),
            'specials' => $specials->all(),
            'subs' => $subs->all(),
            'skills' => $skills->all(),
        ]);
    }

    public function update(Request $request, User $user, Gearset $gearset)
    {
        // validate vals
        $this->validate($request, [
            'gearset-title' => 'max:256|string|nullable',
            'gearset-desc' => 'max:512|string|nullable',
            'gearset-mode-rm' => 'boolean',
            'gearset-mode-cb' => 'boolean',
            'gearset-mode-sz' => 'boolean',
            'gearset-mode-tc' => 'boolean',
            'gearset-weapon-id' => 'numeric',
            'gear-head-id' => 'numeric|nullable',
            'gear-clothes-id' => 'numeric|nullable',
            'gear-shoes-id' => 'numeric|nullable',
        ]);
        

        // prepare selected gears (if pre-existing gear was not selected, set to default gear)
        $headId = ($request->get('gear-head-id') == -1) ? null : $request->get('gear-head-id');
        $clothesId = ($request->get('gear-clothes-id') == -1) ? null : $request->get('gear-clothes-id');
        $shoesId = ($request->get('gear-shoes-id') == -1) ? null : $request->get('gear-shoes-id');



        // update gearset record
        $gearset->gearset_title = $request->input('gearset-title');
        $gearset->gearset_desc = $request->input('gearset-desc');
        $gearset->gearset_mode_rm = $request->boolean('gearset-mode-rm');
        $gearset->gearset_mode_cb = $request->boolean('gearset-mode-cb');
        $gearset->gearset_mode_sz = $request->boolean('gearset-mode-sz');
        $gearset->gearset_mode_tc = $request->boolean('gearset-mode-tc');
        $gearset->weapon_id = $request->input('gearset-weapon-id');

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
