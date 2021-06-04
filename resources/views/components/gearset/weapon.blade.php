@props(['gearset', 'weapons'])

<div class="mx-auto">
    {{-- weapon info --}}
    @foreach ($weapons as $weapon)
        @if ($weapon['Id'] == $gearset->gearset_weapon_id)
            {{-- weapon --}}
            <img src="{{ asset('storage/weapons/Wst_' . $weapon['Name'] . '.png') }}" alt="{{ $weapon['Name'] }}" class="mx-auto p-4">
    
            <div class="grid grid-cols-2 gap-2 p-2">
                {{-- special --}}
                <img src="{{ asset('storage/subspe/Wsp_' . $weapon['Special'] . '.png') }}" alt="{{ $weapon['Special'] }}">
    
                {{-- sub --}}
                <img src="{{ asset('storage/subspe/Wsb_' . $weapon['Sub'] . '.png') }}" alt="{{ $weapon['Sub'] }}">
            </div>
        @endif
    @endforeach
</div>