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
    <form action="{{ route('gears.update', [$user, $gear]) }}" method="post">
        @method('PUT')
        @csrf

        {{-- gear name --}}
        <div>
            <label for="gear-name" class="block">Gear name:</label>
            <input type="text" name="gear-name" id="gear-name" value="{{ $gear->gear_name }}">
        </div>

        {{-- gear desc --}}
        <div>
            <label for="gear-desc" class="block">Gear description:</label>
            <textarea name="gear-desc" id="gear-desc" cols="30" rows="3">{{ $gear->gear_desc }}</textarea>
        </div>

        {{-- gear and skills selector --}}
        <div class="w-1/3 mx-auto bg-indigo-500">
            <x-gear.gear-skills-builder 
                :gears="$gears" 
                :skills="$skillsData" 
                :gearSkills="$gearSkills" 
                :gearName="$gear->gear_id" 
                :mainSkillId="$gear->gear_main"
                :subSkill1Id="$gear->gear_sub_1"
                :subSkill2Id="$gear->gear_sub_2"
                :subSkill3Id="$gear->gear_sub_3"
            />
        </div>

        {{-- submit --}}
        <input type="submit" class="p-2 bg-purple-500 text-white rounded-lg hover:bg-purple-600 hover:cursor-pointer" value="Update">
    </form>
@endsection

@section('scripts')
    @livewireScripts
@endsection