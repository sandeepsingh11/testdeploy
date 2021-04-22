<div>
    <label for="gear-weapon" class="block">Weapon</label>
    <select wire:change="updateWeapon($event.target.value)" name="gear-weapon" id="gear-weapon">
        @foreach ($weapons as $weapon)
            <option value="{{ $weapon['Id'] }}">{{ $weapon['Name'] }}</option>
        @endforeach
    </select>

    <div id="weapon-container">
        <img src="{{ asset('storage/weapons/Wst_' . $weaponName . '.png') }}" alt="{{ $weaponName }}">
        <div class="flex">
            <img src="{{ asset('storage/subspe/Wsp_' . $specialName . '.png') }}" alt="{{ $specialName }}">
            <img src="{{ asset('storage/subspe/Wsb_' . $subName . '.png') }}" alt="{{ $subName }}">
        </div>
    </div>
</div>
