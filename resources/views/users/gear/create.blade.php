@extends('layouts.app')

@section('scripts-head')
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
@endsection

@section('styles')
    @livewireStyles
@endsection

@section('content')
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

            <input type="checkbox" name="gear-mode-rm">
            <label for="gear-mode-rm">Rainmaker</label>

            <input type="checkbox" name="gear-mode-cb">
            <label for="gear-mode-cb">Clamblitz</label>

            <input type="checkbox" name="gear-mode-sz">
            <label for="gear-mode-sz">Splatzones</label>

            <input type="checkbox" name="gear-mode-tc">
            <label for="gear-mode-tc">Towercontrol</label>
        </div>

        {{-- weapons --}}
        <livewire:weapon :weapons="$splatdata[4]" />

        {{-- gear piece (head) --}}
        <livewire:gearpiece :gearpieces="$gearpieces" gearpieceType="head" />

        {{-- gear piece (clothes) --}}
        <livewire:gearpiece :gearpieces="$gearpieces" gearpieceType="clothes" />
        
        {{-- gear piece (shoes) --}}
        <livewire:gearpiece :gearpieces="$gearpieces" gearpieceType="shoes" />



        <input type="submit" value="Create">

        {{ $gearpieces[0] }}
    </form>
@endsection

@section('scripts')
    @livewireScripts
@endsection