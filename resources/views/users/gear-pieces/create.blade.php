@extends('layouts.app')

@section('scripts-head')
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
@endsection

@section('styles')
    @livewireStyles
@endsection

@section('content')
    @foreach ($errors->all() as $message)
        <h1>{{ $message }}</h1>
    @endforeach

    {{-- form --}}
    <form action="/" method="post">
        @csrf

        {{-- gear name --}}
        <div>
            <label for="gear-piece-name" class="block">Gear name:</label>
            <input type="text" name="gear-piece-name" id="gear-piece-name">
        </div>

        {{-- gear desc --}}
        <div>
            <label for="gear-piece-desc" class="block">Gear description:</label>
            <input type="text" name="gear-piece-desc" id="gear-piece-desc">
        </div>

        {{-- gearpiece type --}}
        {{-- gearpiece --}}
        @livewire('gearpiece-list')

        {{-- skill slots --}}
        <div class="w-1/3 mt-4">
            <div class="grid grid-cols-3 grid-rows-2 gap-1 h-40 mx-auto">
                <div id="gear-piece-main" class="drag-into border-solid border border-gray-900 col-span-3 rounded-full" style="width: 64px; height: 64px" data-source="slot">
                    <img 
                        src="{{ asset('storage/skills/unknown.png') }}" 
                        alt="unknown"
                        class="draggable"
                        data-skill-id="26"
                        data-skill-id="unknown"
                        data-skill-type="Main"
                        draggable="true"
                    >
                </div>
                <div id="gear-piece-sub-1" class="drag-into border-solid border border-gray-900 rounded-full" style="width: 32px; height: 32px" data-source="slot">
                    <img 
                        src="{{ asset('storage/skills/unknown.png') }}" 
                        alt="unknown"
                        class="draggable"
                        data-skill-id="26"
                        data-skill-id="unknown"
                        data-skill-type="All"
                        draggable="true"
                    >
                </div>
                <div id="gear-piece-sub-2" class="drag-into border-solid border border-gray-900 rounded-full" style="width: 32px; height: 32px" data-source="slot">
                    <img 
                        src="{{ asset('storage/skills/unknown.png') }}" 
                        alt="unknown"
                        class="draggable"
                        data-skill-id="26"
                        data-skill-id="unknown"
                        data-skill-type="All"
                        draggable="true"
                    >
                </div>
                <div id="gear-piece-sub-3" class="drag-into border-solid border border-gray-900 rounded-full" style="width: 32px; height: 32px" data-source="slot">
                    <img 
                        src="{{ asset('storage/skills/unknown.png') }}" 
                        alt="unknown"
                        class="draggable"
                        data-skill-id="26"
                        data-skill-id="unknown"
                        data-skill-type="All"
                        draggable="true"
                    >
                </div>

                <input type="hidden" name="gear-piece-main" id="hidden-gear-piece-main" value="">
                <input type="hidden" name="gear-piece-sub-1" id="hidden-gear-piece-sub-1" value="">
                <input type="hidden" name="gear-piece-sub-2" id="hidden-gear-piece-sub-2" value="">
                <input type="hidden" name="gear-piece-sub-3" id="hidden-gear-piece-sub-3" value="">
            </div>
        </div>

        {{-- skills bank --}}
        <div class="flex flex-wrap">
            @for ($i = 0; $i < sizeof($skillsData); $i++)
                @if ($skillsData[$i]['allowed'] === 'Main')
                    <div data-source="bank">
                        <img 
                            src="{{ asset('storage/skills/' . $skillsData[$i]['skill'] . '.png') }}" 
                            alt=""
                            class="draggable"
                            data-skill-id="{{ $skillsData[$i]['id'] }}"
                            data-skill-name="{{ $skillsData[$i]['skill'] }}"
                            data-skill-type="{{ $skillsData[$i]['allowed'] }}"
                            draggable="true"
                        >
                    </div>
                @endif
            @endfor
        </div>
        <div class="flex flex-wrap">
            @for ($i = 0; $i < sizeof($skillsData); $i++)
                @if ($skillsData[$i]['allowed'] === 'All')
                    <div data-source="bank">
                        <img 
                            src="{{ asset('storage/skills/' . $skillsData[$i]['skill'] . '.png') }}" 
                            alt=""
                            class="draggable"
                            data-skill-id="{{ $skillsData[$i]['id'] }}"
                            data-skill-name="{{ $skillsData[$i]['skill'] }}"
                            data-skill-type="{{ $skillsData[$i]['allowed'] }}"
                            draggable="true"
                        >
                    </div>
                @endif
            @endfor
        </div>

        <input type="submit" class="p-2 bg-purple-500 text-white rounded-lg hover:bg-purple-600 hover:cursor-pointer" value="Create">
    </form>
@endsection

@section('scripts')
    @livewireScripts
@endsection