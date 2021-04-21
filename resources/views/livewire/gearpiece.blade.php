<div>
    <label for="gear-{{ $gearpieceType }}-id" class="block">{{ ucfirst($gearpieceType) }} gear</label>
    <select wire:change="updateGearpieceImage($event.target.value)" name="gear-{{ $gearpieceType }}-id" id="gear-{{ $gearpieceType }}-id">
        <option value="-1"></option>

        @foreach ($gearpieces as $gearpiece)
            @if ($gearpiece->gear_piece_type == lcfirst($gearpieceType[0]))
                <option value="{{ $gearpiece->id }}">{{ $gearpiece->gear_piece_name }}</option>
            @endif
        @endforeach
    </select>

    <div id="gp-{{ $gearpieceType }}">
        <img src="{{ asset('storage/gear/' . $modelName . '.png') }}" alt="">
    </div>
</div>
