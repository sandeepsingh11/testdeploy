<div class="w-full">
    <label for="gear-{{ $gearType }}-id" class="block text-center">{{ ucfirst($gearType) }} gear</label>
    <select 
        wire:change="updateGear($event.target.value)" 
        name="gear-{{ $gearType }}-id" 
        id="gear-{{ $gearType }}-id"
        class="w-full rounded focus:ring-primary-400 focus:border-primary-400"
        >
        <option value="-1">===== {{ $gearType }} =====</option>

        @foreach ($gears as $gear)
            @if ( $gear->baseGear->base_gear_type == Str::upper(lcfirst($gearType[0])) )
                <option value="{{ $gear->id }}" @if($oldGearId == $gear->id) selected @endif>{{ $gear->gear_title }}</option>
            @endif
        @endforeach
    </select>

    <div id="gear-{{ $gearType }}">
        <img class="mx-auto" src="{{ asset('storage/gear/' . $gearName . '.png') }}" alt="{{ $gearName }}">
        <div>
            <img class="mx-auto" src="{{ asset('storage/skills/' . $skillMain . '.png') }}" alt="{{ $skillMain }}">
        </div>
        <div class="flex justify-evenly">
            <img src="{{ asset('storage/skills/' . $skillSub1 . '.png') }}" alt="{{ $skillSub1 }}">
            <img src="{{ asset('storage/skills/' . $skillSub2 . '.png') }}" alt="{{ $skillSub2 }}">
            <img src="{{ asset('storage/skills/' . $skillSub3 . '.png') }}" alt="{{ $skillSub3 }}">
        </div>
    </div>
</div>
