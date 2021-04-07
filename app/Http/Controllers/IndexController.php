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
            'gear-name' => 'max:255',
            'gear-desc' => 'max:512',
            'gear-id' => 'required|max:64',
            'gear-main' => 'numeric|nullable',
            'gear-sub-1' => 'numeric|nullable',
            'gear-sub-2' => 'numeric|nullable',
            'gear-sub-3' => 'numeric|nullable',
        ]);

        // create a gear piece THROUGH a user
        $request->user()->gears()->create([
            'gear_name' => $request->get('gear-name'),
            'gear_desc' => $request->get('gear-desc'),
            'gear_id' => $request->get('gear-id'),
            'gear_main' => $request->get('gear-main'),
            'gear_sub_1' => $request->get('gear-sub-1'),
            'gear_sub_2' => $request->get('gear-sub-2'),
            'gear_sub_3' => $request->get('gear-sub-3'),
        ]);

        return back();
    }
}
