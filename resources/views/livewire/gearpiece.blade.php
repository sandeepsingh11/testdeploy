<div class="w-full">
    <label for="gear-{{ $gearpieceType }}-id" class="block text-center">{{ ucfirst($gearpieceType) }} gear piece</label>
    <select 
        wire:change="updateGearpiece($event.target.value)" 
        name="gear-{{ $gearpieceType }}-id" 
        id="gear-{{ $gearpieceType }}-id"
        class="w-full"
        >
        <option value="-1">===== {{ $gearpieceType }} =====</option>

        @foreach ($gearpieces as $gearpiece)
            @if ($gearpiece->gear_piece_type == lcfirst($gearpieceType[0]))
                <option value="{{ $gearpiece->id }}">{{ $gearpiece->gear_piece_name }}</option>
            @endif
        @endforeach
    </select>

    <div id="gp-{{ $gearpieceType }}">
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
