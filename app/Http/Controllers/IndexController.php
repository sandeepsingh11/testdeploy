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
            'headgearss' => $headgears,
            'skills' => $skills,
        ]);
    }

    public function store(Request $request)
    {
        dd($request);
    }
}
