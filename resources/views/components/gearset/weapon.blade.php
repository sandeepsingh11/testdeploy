@props(['gearset', 'weapon'])

<div class="mx-auto">
    {{-- weapon --}}
    <img src="{{ asset('storage/weapons/Wst_' . $weapon->weapon_name . '.png') }}" alt="{{ $weapon->weapon_name }}" class="mx-auto p-4">
    
    <div class="grid grid-cols-2 gap-2 p-2">
        {{-- special --}}
        <img src="{{ asset('storage/subspe/Wsp_' . $weapon->special->special_name . '.png') }}" alt="{{ $weapon->special->special_name }}">

        {{-- sub --}}
        <img src="{{ asset('storage/subspe/Wsb_' . $weapon->sub->sub_name . '.png') }}" alt="{{ $weapon->sub->sub_name }}">
    </div>
</div>