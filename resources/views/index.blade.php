@extends('layouts.app')

@section('content')

    {{-- slots --}}
    <div class="flex justify-evenly mt-4">
        <div class="grid grid-cols-3 grid-rows-2 gap-1 w-1/3 h-40 mx-2">
            <div id="skill-main-1" class="drag-into col-span-3 border-solid border border-gray-900" data-source="slot"></div>
            <div id="skill-sub-1-1" class="drag-into border-solid border border-gray-900" data-source="slot"></div>
            <div id="skill-sub-2-1" class="drag-into border-solid border border-gray-900" data-source="slot"></div>
            <div id="skill-sub-3-1" class="drag-into border-solid border border-gray-900" data-source="slot"></div>
        </div>
        <div class="grid grid-cols-3 grid-rows-2 gap-1 w-1/3 h-40 mx-2">
            <div id="skill-main-2" class="drag-into col-span-3 border-solid border border-gray-900" data-source="slot"></div>
            <div id="skill-sub-1-2" class="drag-into border-solid border border-gray-900" data-source="slot"></div>
            <div id="skill-sub-2-2" class="drag-into border-solid border border-gray-900" data-source="slot"></div>
            <div id="skill-sub-3-2" class="drag-into border-solid border border-gray-900" data-source="slot"></div>
        </div>
        <div class="grid grid-cols-3 grid-rows-2 gap-1 w-1/3 h-40 mx-2">
            <div id="skill-main-3" class="drag-into col-span-3 border-solid border border-gray-900" data-source="slot"></div>
            <div id="skill-sub-1-3" class="drag-into border-solid border border-gray-900" data-source="slot"></div>
            <div id="skill-sub-2-3" class="drag-into border-solid border border-gray-900" data-source="slot"></div>
            <div id="skill-sub-3-3" class="drag-into border-solid border border-gray-900" data-source="slot"></div>
        </div>
    </div>
    
    {{-- bank --}}
    <div class="flex flex-wrap">
        @for ($i = 0; $i < sizeof($skills); $i++)
            {{-- <img src="{{ asset('storage/gear/' . $headgear[$i]['ModelName'] . '.png') }}" alt=""> --}}
            <div data-source="bank">
                <img 
                    id="{{ $skills[$i]['skill'] }}" 
                    src="{{ asset('storage/skills/' . $skills[$i]['skill'] . '.png') }}" 
                    alt=""
                    class="draggable"
                    data-skill-id="{{ $skills[$i]['id'] }}"
                    draggable="true"
                >
            </div>
        @endfor
    </div>

@endsection