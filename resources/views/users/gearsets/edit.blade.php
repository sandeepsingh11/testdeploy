@extends('layouts.app')

@section('scripts-head')
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
@endsection

@section('styles')
    @livewireStyles
@endsection

@section('content')
    <div class="w-1/2 mx-auto">
        <form action="{{ route('gearsets.update', [$user, $gearset]) }}" method="post">
            @method('PUT')
            @csrf

            {{-- gearset name --}}
            <div>
                <label for="gearset-name" class="block">Gearset name:</label>
                <input type="text" name="gearset-name" id="gearset-name" value="{{ $gearset->gearset_name }}">
            </div>

            {{-- gearset desc --}}
            <div>
                <label for="gearset-desc" class="block">Gearset description:</label>
                <textarea name="gearset-desc" id="gearset-desc">{{ $gearset->gearset_desc }}</textarea>
            </div>

            {{-- gearset mode --}}
            <div>
                <label for="mode" class="block">Game mode:</label>

                <input type="checkbox" name="gearset-mode-rm" value="1" @if($gearset->gearset_mode_rm) checked @endif>
                <label for="gearset-mode-rm">Rainmaker</label>

                <input type="checkbox" name="gearset-mode-cb" value="1" @if($gearset->gearset_mode_cb) checked @endif>
                <label for="gearset-mode-cb">Clam Blitz</label>

                <input type="checkbox" name="gearset-mode-sz" value="1" @if($gearset->gearset_mode_sz) checked @endif>
                <label for="gearset-mode-sz">Splat Zones</label>

                <input type="checkbox" name="gearset-mode-tc" value="1" @if($gearset->gearset_mode_tc) checked @endif>
                <label for="gearset-mode-tc">Tower Control</label>
            </div>

            <div class="grid grid-cols-2 grid-rows-2 gap-4 min-w-min w-full max-w-max">
                {{-- weapons --}}
                <livewire:weapon :weapons="$splatdata[4]" :oldWeapon="$gearset->gearset_weapon_id" />
        
                {{-- gear (head) --}}
                <livewire:gear :gears="$gears" gearType="head" :skills="$splatdata[3]" :oldGears="$currentGears" />
        
                {{-- gear (clothes) --}}
                <livewire:gear :gears="$gears" gearType="clothes" :skills="$splatdata[3]" :oldGears="$currentGears" />
                
                {{-- gear (shoes) --}}
                <livewire:gear :gears="$gears" gearType="shoes" :skills="$splatdata[3]" :oldGears="$currentGears" />
            </div>



            <input type="submit" value="Update" class="p-2 border-black rounded-md bg-indigo-200 border hover:bg-indigo-400 mt-4">
        </form>
    </div>
@endsection

@section('scripts')
    @livewireScripts
@endsection