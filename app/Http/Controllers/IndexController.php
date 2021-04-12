<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IndexController extends Controller
{
    public function index()
    {
        // get local json files
        $headgears = Storage::disk('local')->get('splatdata/GearInfo_Head.json');
        $headgears = json_decode($headgears, true);
        
        $skills = Storage::disk('local')->get('splatdata/Skills.json');
        $skills = json_decode($skills, true);
        
        

        return view('index', [
            'headgears' => $headgears,
            'skills' => $skills,
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'gear-piece-name' => 'max:255',
            'gear-piece-desc' => 'max:512',
            'gear-piece-id' => 'required|max:64',
            'gear-piece-main' => 'numeric|nullable',
            'gear-piece-sub-1' => 'numeric|nullable',
            'gear-piece-sub-2' => 'numeric|nullable',
            'gear-piece-sub-3' => 'numeric|nullable',
        ]);

        // create a gear piece THROUGH a user
        $request->user()->gearPieces()->create([
            'gear_piece_name' => $request->get('gear-piece-name'),
            'gear_piece_desc' => $request->get('gear-piece-desc'),
            'gear_piece_id' => $request->get('gear-piece-id'),
            'gear_piece_main' => $request->get('gear-piece-main'),
            'gear_piece_sub_1' => $request->get('gear-piece-sub-1'),
            'gear_piece_sub_2' => $request->get('gear-piece-sub-2'),
            'gear_piece_sub_3' => $request->get('gear-piece-sub-3'),
        ]);

        return back();
    }
}
