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
            <input type="text" name="gear-desc" id="gear-desc">
        </div>

        {{-- gear weapon --}}
        <div>
            <label for="gear-weapon" class="block">Weapon:</label>
            <input type="text" name="gear-weapon" id="gear-weapon">
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
        <div>
            <label for="gear-weapon" class="block">Weapon</label>
            <select name="gear-weapon" id="gear-weapon">
                @foreach ($splatdata[4] as $weapon)
                    <option value="{{ $weapon['Id'] }}">{{ $weapon['Name'] }}
                        <img src="{{ asset('storage/weapons/Wst_' . $weapon['Name'] . '.png') }}" alt="{{ $weapon['Name'] }}">
                    </option>
                @endforeach
            </select>
        </div>

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