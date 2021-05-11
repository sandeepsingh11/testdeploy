<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GearAbstractController;
use App\Models\GearPiece;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class GearPieceController extends GearAbstractController
{
    public function __construct()
    {
        // user must be a guest to view, otherwise redirect
        $this->middleware(['auth'])
            ->except(['index', 'show']);
    }

    public function index(User $user)
    {
        // get user's gear pieces
        $gearpieces = $user->gearpieces;

        // $gearpieces = $user->gearpieces()->with(['user'])->paginate(20);


        return view('users.gear-pieces.index', [
            'user' => $user,
            'gearpieces' => $gearpieces,
        ]);
    }

    public function show(User $user, GearPiece $gearpiece)
    {
        // get specified gearpiece passed from uri
        $gearpiece = $user->gearpieces->where('id', $gearpiece->id)->first();
        
        return view('users.gear-pieces.show', [
            'user' => $user,
            'gearpiece' => $gearpiece
        ]);
    }

    public function create(User $user)
    {
        // get according splatdata
        $headData = GearAbstractController::getSplatdata('Head');
        $clothesData = GearAbstractController::getSplatdata('Clothes');
        $shoesData = GearAbstractController::getSplatdata('Shoes');
        $skillsData = GearAbstractController::getSplatdata('Skills');

        // combine gearpieces into 1 array
        $gearpieces = [
            $headData, 
            $clothesData, 
            $shoesData
        ];


        return view('users.gear-pieces.create', [
            'user' => $user,
            'gearpieces' => $gearpieces,
            'skillsData' => $skillsData,
        ]);
    }

    public function store(Request $request, User $user)
    {
        // validate input
        $this->validate($request, [
            'gear-piece-name' => 'max:255',
            'gear-piece-desc' => 'max:512',
            'gear-piece-id' => 'required|max:64',
            'gear-piece-main' => 'numeric|nullable',
            'gear-piece-sub-1' => 'numeric|nullable',
            'gear-piece-sub-2' => 'numeric|nullable',
            'gear-piece-sub-3' => 'numeric|nullable',
        ]);

        // get gear type
        $baseId = explode('_', $request->get('gear-piece-id'))[0];
        $gearpieceType = '';
        if ($baseId == 'Hed') {
            // head gearpiece
            $gearpieceType = 'h';
        }
        else if ($baseId == 'Clt') {
            // clothing gearpiece
            $gearpieceType = 'c';
        }
        else {
            // shoes gearpiece
            $gearpieceType = 's';
        }

        // create a gear piece THROUGH a user
        $request->user()->gearpieces()->create([
            'gear_piece_name' => $request->get('gear-piece-name'),
            'gear_piece_desc' => $request->get('gear-piece-desc'),
            'gear_piece_id' => $request->get('gear-piece-id'),
            'gear_piece_type' => $gearpieceType,
            'gear_piece_main' => $request->get('gear-piece-main'),
            'gear_piece_sub_1' => $request->get('gear-piece-sub-1'),
            'gear_piece_sub_2' => $request->get('gear-piece-sub-2'),
            'gear_piece_sub_3' => $request->get('gear-piece-sub-3'),
        ]);

        return back();
    }

    public function edit(User $user, GearPiece $gearpiece)
    {
        // get according splatdata
        $headData = GearAbstractController::getSplatdata('Head');
        $clothesData = GearAbstractController::getSplatdata('Clothes');
        $shoesData = GearAbstractController::getSplatdata('Shoes');
        $skillsData = GearAbstractController::getSplatdata('Skills');

        // combine gearpieces into 1 array
        $gearpieces = [
            $headData, 
            $clothesData, 
            $shoesData
        ];


        // get this gearpiece's skill names
        $gearpieceSkills = $this->getGearPieceSkills($gearpiece);



        return view('users.gear-pieces.edit', [
            'user' => $user,
            'gearpiece' => $gearpiece,
            'gearpieces' => $gearpieces,
            'gearpieceSkills' => $gearpieceSkills,
            'skillsData' => $skillsData,
        ]);
    }

    public function update(Request $request, User $user, GearPiece $gearpiece)
    {
        // validate vals
        $this->validate($request, [
            'gear-piece-name' => 'max:255',
            'gear-piece-desc' => 'max:512',
            'gear-piece-id' => 'required|max:64',
            'gear-piece-main' => 'numeric|nullable',
            'gear-piece-sub-1' => 'numeric|nullable',
            'gear-piece-sub-2' => 'numeric|nullable',
            'gear-piece-sub-3' => 'numeric|nullable',
        ]);

        // get gear type
        $baseId = explode('_', $request->get('gear-piece-id'))[0];
        $gearpieceType = '';
        if ($baseId == 'Hed') {
            // head gearpiece
            $gearpieceType = 'h';
        }
        else if ($baseId == 'Clt') {
            // clothing gearpiece
            $gearpieceType = 'c';
        }
        else {
            // shoes gearpiece
            $gearpieceType = 's';
        }



        // update local gearpiece var
        $gearpiece->gear_piece_name = $request->get('gear-piece-name');
        $gearpiece->gear_piece_desc = $request->get('gear-piece-desc');
        $gearpiece->gear_piece_id = $request->get('gear-piece-id');
        $gearpiece->gear_piece_type = $gearpieceType;
        $gearpiece->gear_piece_main = $request->get('gear-piece-main');
        $gearpiece->gear_piece_sub_1 = $request->get('gear-piece-sub-1');
        $gearpiece->gear_piece_sub_2 = $request->get('gear-piece-sub-2');
        $gearpiece->gear_piece_sub_3 = $request->get('gear-piece-sub-3');
        
        
        // update model in db if it has new values (is dirty)
        if ($gearpiece->isDirty()) {
            $gearpiece->save();
        }


        
        return redirect(route('gearpieces', [$user]));
    }

    public function destroy(User $user, GearPiece $gearpiece)
    {
        // check if the current user can delete the specified gear piece
        $this->authorize('delete', $gearpiece);

        // delete this model instance
        $gearpiece->delete();

        return back();
    }
}
