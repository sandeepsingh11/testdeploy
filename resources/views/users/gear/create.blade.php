@extends('layouts.app')

@section('scripts-head')
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
@endsection

@section('styles')
    @livewireStyles
@endsection

@section('content')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif








    <div class="w-1/2 mx-auto">
        <form action="{{ route('gears.create', $user) }}" method="post">
            @csrf
    
            {{-- gear name --}}
            <div>
                <label for="gear-name" class="block">Gear name:</label>
                <input type="text" name="gear-name" id="gear-name">
            </div>
    
            {{-- gear desc --}}
            <div>
                <label for="gear-desc" class="block">Gear description:</label>
                <textarea name="gear-desc" id="gear-desc"></textarea>
            </div>
    
            {{-- gear mode --}}
            <div>
                <label for="mode" class="block">Game mode:</label>
    
                <input type="checkbox" name="gear-mode-rm" value="1">
                <label for="gear-mode-rm">Rainmaker</label>
    
                <input type="checkbox" name="gear-mode-cb" value="1">
                <label for="gear-mode-cb">Clamblitz</label>
    
                <input type="checkbox" name="gear-mode-sz" value="1">
                <label for="gear-mode-sz">Splatzones</label>
    
                <input type="checkbox" name="gear-mode-tc" value="1">
                <label for="gear-mode-tc">Towercontrol</label>
            </div>
    
            <div class="grid grid-cols-2 grid-rows-2 gap-4 min-w-min w-full max-w-max">
                {{-- weapons --}}
                <livewire:weapon :weapons="$splatdata[4]" />
        
                {{-- gear piece (head) --}}
                <livewire:gearpiece :gearpieces="$gearpieces" gearpieceType="head" :skills="$splatdata[3]" />
        
                {{-- gear piece (clothes) --}}
                <livewire:gearpiece :gearpieces="$gearpieces" gearpieceType="clothes" :skills="$splatdata[3]" />
                
                {{-- gear piece (shoes) --}}
                <livewire:gearpiece :gearpieces="$gearpieces" gearpieceType="shoes" :skills="$splatdata[3]" />
            </div>
    
    
    
            <input type="submit" value="Create" class="p-2 border-black rounded-md bg-indigo-200 border hover:bg-indigo-400 mt-4">
        </form>
    </div>
@endsection

@section('scripts')
    @livewireScripts
@endsection