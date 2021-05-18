<div class="w-full">
    <label for="gear-{{ $gearType }}-id" class="block text-center">{{ ucfirst($gearType) }} gear</label>
    <select 
        wire:change="updateGear($event.target.value)" 
        name="gear-{{ $gearType }}-id" 
        id="gear-{{ $gearType }}-id"
        class="w-full"
        >
        <option value="-1">===== {{ $gearType }} =====</option>

        @foreach ($gears as $gear)
            @if ($gear->gear_type == lcfirst($gearType[0]))
                <option value="{{ $gear->id }}" @if($oldGear == $gear->id) selected  @endif>{{ $gear->gear_name }}</option>
            @endif
        @endforeach
    </select>

    <div id="gear-{{ $gearType }}">
        <img class="mx-auto" src="{{ asset('storage/gear/' . $modelName . '.png') }}" alt="{{ $modelName }}">
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
