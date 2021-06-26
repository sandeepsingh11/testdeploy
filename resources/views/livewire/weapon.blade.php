<div class="w-full">
    <label for="gearset-weapon-id" class="block text-center">Weapon</label>
    <select 
        wire:change="updateWeapon($event.target.value)" 
        name="gearset-weapon-id" 
        id="gearset-weapon"
        class="w-full rounded focus:ring-primary-400 focus:border-primary-400"
        >
        @foreach ($weapons as $weapon)
            <option value="{{ $weapon->id }}" @if($oldWeapon == $weapon->id) selected  @endif>{{ __($weapon->weapon_name) }}</option>
        @endforeach
    </select>

    <div id="weapon-container">
        <img class="mx-auto" src="{{ asset('storage/weapons/Wst_' . $weaponName . '.png') }}" alt="{{ __($weaponName) }}">
        <div class="flex justify-evenly">
            <img src="{{ asset('storage/subspe/Wsp_' . $specialName . '.png') }}" alt="{{ $specialName }}">
            <img src="{{ asset('storage/subspe/Wsb_' . $subName . '.png') }}" alt="{{ $subName }}">
        </div>
    </div>
</div>
