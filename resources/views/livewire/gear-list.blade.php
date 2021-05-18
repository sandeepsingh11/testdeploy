<div>
    {{-- gear type --}}
    <div>
        <label for="gear-type" class="block">Gear type</label>
        
        <input type="radio" name="gear-type" id="head" value="h" wire:change="updateGearList($event.target.value)" checked>
        <label for="head">Head</label>

        <input type="radio" name="gear-type" id="clothes" value="c" wire:change="updateGearList($event.target.value)">
        <label for="clothes">Clothes</label>

        <input type="radio" name="gear-type" id="shoes" value="s" wire:change="updateGearList($event.target.value)">
        <label for="shoes">Shoes</label>
    </div>

    {{-- gear list --}}
    <div>
        <label for="gear-id" class="block">Gear</label>
        <select name="gear-id" id="gear-id" wire:change="updateGearList($event.target.value)">
            @foreach ($gearList as $gear)
                <option value="{{ $gear['ModelName'] }}">{{ $gear['ModelName'] }}</option>
            @endforeach

            {{-- <template x-for="gear in gearList">
                <option x-value="gear.ModelName" x-text="gear.ModelName"></option>
            </template> --}}
        </select>
    </div>
</div>
