@extends('layouts.app')

@section('scripts-head')
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
@endsection

@section('styles')
    @livewireStyles
@endsection

@section('content')
    <div class="w-1/2 mx-auto">
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
                <textarea name="gear-desc" id="gear-desc">{{ $gear->gear_desc }}</textarea>
            </div>

            {{-- gear mode --}}
            <div>
                <label for="mode" class="block">Game mode:</label>

                <input type="checkbox" name="gear-mode-rm" value="1" @if($gear->gear_mode_rm) checked @endif>
                <label for="gear-mode-rm">Rainmaker</label>

                <input type="checkbox" name="gear-mode-cb" value="1" @if($gear->gear_mode_cb) checked @endif>
                <label for="gear-mode-cb">Clam Blitz</label>

                <input type="checkbox" name="gear-mode-sz" value="1" @if($gear->gear_mode_sz) checked @endif>
                <label for="gear-mode-sz">Splat Zones</label>

                <input type="checkbox" name="gear-mode-tc" value="1" @if($gear->gear_mode_tc) checked @endif>
                <label for="gear-mode-tc">Tower Control</label>
            </div>

            <div class="grid grid-cols-2 grid-rows-2 gap-4 min-w-min w-full max-w-max">
                {{-- weapons --}}
                <livewire:weapon :weapons="$splatdata[4]" :oldWeapon="$gear->gear_weapon_id" />
        
                {{-- gear piece (head) --}}
                <livewire:gearpiece :gearpieces="$gearpieces" gearpieceType="head" :skills="$splatdata[3]" :oldGearpiece="$currentGearpieces['h']->id" />
        
                {{-- gear piece (clothes) --}}
                <livewire:gearpiece :gearpieces="$gearpieces" gearpieceType="clothes" :skills="$splatdata[3]" :oldGearpiece="$currentGearpieces['c']->id" />
                
                {{-- gear piece (shoes) --}}
                <livewire:gearpiece :gearpieces="$gearpieces" gearpieceType="shoes" :skills="$splatdata[3]" :oldGearpiece="$currentGearpieces['s']->id" />
            </div>



            <input type="submit" value="Create" class="p-2 border-black rounded-md bg-indigo-200 border hover:bg-indigo-400 mt-4">
        </form>
    </div>
@endsection

@section('scripts')
    @livewireScripts
@endsection