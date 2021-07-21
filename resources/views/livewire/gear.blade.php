<div class="w-full">
    <label for="gear-{{ Str::lower($gearType) }}-id" class="block text-center">{{ $gearType }} gear</label>
    <select 
        wire:change="updateGear($event.target.value)" 
        name="gear-{{ Str::lower($gearType) }}-id" 
        id="gear-{{ Str::lower($gearType) }}-id"
        class="w-full rounded focus:ring-primary-400 focus:border-primary-400"
        >
        <option value="-1">===== {{ $gearType }} =====</option>

        @foreach ($gears as $gear)
            @if ( $gear->baseGears->base_gear_type == $gearType[0] )
                <option value="{{ $gear->id }}" @if($oldGearId == $gear->id) selected @endif>{{ $gear->gear_title }}</option>
            @endif
        @endforeach
    </select>

    <div id="gear-{{ $gearType }}">
        <img class="mx-auto" src="{{ asset('storage/gear/' . $gearName . '.png') }}" alt="{{ $gearName }}" loading="lazy">
        <div>
            <img class="mx-auto" src="{{ asset('storage/skills/' . $skillMain . '.png') }}" alt="{{ $skillMain }}" loading="lazy">
        </div>
        <div class="flex justify-evenly">
            <img src="{{ asset('storage/skills/' . $skillSub1 . '.png') }}" alt="{{ $skillSub1 }}" loading="lazy">
            <img src="{{ asset('storage/skills/' . $skillSub2 . '.png') }}" alt="{{ $skillSub2 }}" loading="lazy">
            <img src="{{ asset('storage/skills/' . $skillSub3 . '.png') }}" alt="{{ $skillSub3 }}" loading="lazy">
        </div>
    </div>
</div>
