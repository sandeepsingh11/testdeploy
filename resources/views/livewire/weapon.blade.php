<div class="w-full">
    <label for="gearset-weapon-id" class="block @if(!$inline) text-center @endif">{{ $selectLabel }}</label>
    <select 
        wire:change="updateWeapon($event.target.value)" 
        name="gearset-weapon-id" 
        id="gearset-weapon"
        class="w-full rounded focus:ring-primary-400 focus:border-primary-400"
        >
        @foreach ($weapons as $weapon)
            <option value="{{ $weapon->id }}" data-name="{{ $weapon->weapon_name }}" @if($oldWeaponId == $weapon->id) selected  @endif>{{ __($weapon->weapon_name) }}</option>
        @endforeach
    </select>

    <div id="weapon-container">
        <img class="mx-auto @if($inline) inline-block @endif" src="{{ asset('storage/weapons/Wst_' . $weaponName . '.png') }}" alt="{{ __($weaponName) }}" loading="lazy">
        
        @if (!$inline)
            <div class="flex justify-evenly">
                <img src="{{ asset('storage/subspe/Wsp_' . $specialName . '.png') }}" alt="{{ $specialName }}" loading="lazy">
                <img src="{{ asset('storage/subspe/Wsb_' . $subName . '.png') }}" alt="{{ $subName }}" loading="lazy">
            </div>
        @else
            <img class="@if($inline) inline-block pl-8 @endif" src="{{ asset('storage/subspe/Wsp_' . $specialName . '.png') }}" alt="{{ $specialName }}" loading="lazy">
            <img class="@if($inline) inline-block pl-8 @endif" src="{{ asset('storage/subspe/Wsb_' . $subName . '.png') }}" alt="{{ $subName }}" loading="lazy">
        @endif
    </div>
</div>
