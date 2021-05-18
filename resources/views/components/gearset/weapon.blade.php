@props(['gearset', 'weapons'])

<div>
    {{-- weapon info --}}
    @foreach ($weapons as $weapon)
        @if ($weapon['Id'] == $gearset->gearset_weapon_id)
            {{-- weapon --}}
            <img src="{{ asset('storage/weapons/Wst_' . $weapon['Name'] . '.png') }}" alt="{{ $weapon['Name'] }}" class="mx-auto">
    
            <div class="flex justify-center p-2">
                {{-- special --}}
                <img src="{{ asset('storage/subspe/Wsp_' . $weapon['Special'] . '.png') }}" alt="{{ $weapon['Special'] }}" class="mx-2">
    
                {{-- sub --}}
                <img src="{{ asset('storage/subspe/Wsb_' . $weapon['Sub'] . '.png') }}" alt="{{ $weapon['Sub'] }}" class="mx-2">
            </div>
        @endif
    @endforeach
</div>