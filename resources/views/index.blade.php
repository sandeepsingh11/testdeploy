@extends('layouts.app')

@section('content')

    @foreach ($errors->all() as $message)
        <h1>{{ $message }}</h1>
    @endforeach

    {{-- form --}}
    <form action="/" method="post">
        @csrf

        {{-- gear name --}}
        <div>
            <label for="gear-name" class="block">Gear name:</label>
            <input type="text" name="gear-name" id="gear-name">
        </div>

        {{-- gear desc --}}
        <div>
            <label for="gear-desc" class="block">Gear description:</label>
            <input type="text" name="gear-desc" id="gear-desc">
        </div>

        {{-- gear piece --}}
        <div>
            <label for="gear-id" class="block">Gear piece</label>
            <select name="gear-id" id="gear-id">
                @foreach ($headgears as $headgear)
                    <option value="{{ $headgear['ModelName'] }}">{{ $headgear['ModelName'] }}</option>
                @endforeach
            </select>
        </div>

        {{-- game modes --}}

        {{-- slots --}}
        <div class="w-1/2 mt-4">
            <div class="grid grid-cols-3 grid-rows-2 gap-1 h-40 mx-auto">
                <div id="gear-main" class="drag-into border-solid border border-gray-900 col-span-3" data-source="slot"></div>
                <div id="gear-sub-1" class="drag-into border-solid border border-gray-900" data-source="slot"></div>
                <div id="gear-sub-2" class="drag-into border-solid border border-gray-900" data-source="slot"></div>
                <div id="gear-sub-3" class="drag-into border-solid border border-gray-900" data-source="slot"></div>

                <input type="hidden" name="gear-main" id="hidden-gear-main" value="">
                <input type="hidden" name="gear-sub-1" id="hidden-gear-sub-1" value="">
                <input type="hidden" name="gear-sub-2" id="hidden-gear-sub-2" value="">
                <input type="hidden" name="gear-sub-3" id="hidden-gear-sub-3" value="">
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

        <input type="submit" class="p-4 bg-purple-500 text-white rounded-lg hover:bg-purple-600 hover:cursor-pointer" value="Create">
    </form>

@endsection