<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GearPieceController extends Controller
{
    public function index(User $user)
    {
        // get user's gear pieces
        $gearpieces = $user->gearPieces;
        // $gearpieces = $user->gearpieces()->with(['user'])->paginate(20);



        // get json files
        $headgears = Storage::disk('local')->get('splatdata/GearInfo_Head.json');
        $headgears = json_decode($headgears, true);

        $clothes = Storage::disk('local')->get('splatdata/GearInfo_Clothes.json');
        $clothes = json_decode($clothes, true);

        $shoes = Storage::disk('local')->get('splatdata/GearInfo_Shoes.json');
        $shoes = json_decode($shoes, true);

        $skills = Storage::disk('local')->get('splatdata/Skills.json');
        $skills = json_decode($skills, true);



        return view('users.gear-pieces.index', [
            'user' => $user,
            'gearpieces' => $gearpieces,
            'headgears' => $headgears,
            'clothes' => $clothes,
            'shoes' => $shoes,
            'skills' => $skills,
        ]);
    }

    public function show(User $user) // GearPiece $gearpiece
    {
        // get json file (determine which file to get based on ModelName's first 3 chars (explode by '_'?))

        return view('users.gear-piece.show', [
            'user' => $user,
            'gearpiece' => $user // $gearpiece
        ]);
    }
}
