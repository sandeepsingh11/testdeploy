<div>
    {{-- gearpiece type --}}
    <div>
        <label for="gear-piece-type" class="block">Gearpiece type</label>
        
        <input type="radio" name="gear-piece-type" id="head" value="h" wire:change="updateGpList($event.target.value)" checked>
        <label for="head">Head</label>

        <input type="radio" name="gear-piece-type" id="clothes" value="c" wire:change="updateGpList($event.target.value)">
        <label for="clothes">Clothes</label>

        <input type="radio" name="gear-piece-type" id="shoes" value="s" wire:change="updateGpList($event.target.value)">
        <label for="shoes">Shoes</label>
    </div>

    {{-- gearpiece list --}}
    <div>
        <label for="gear-piece-id" class="block">Gearpiece</label>
        <select name="gear-piece-id" id="gear-piece-id" wire:change="updateGpList($event.target.value)">
            @foreach ($gpList as $gearpiece)
                <option value="{{ $gearpiece['ModelName'] }}">{{ $gearpiece['ModelName'] }}</option>
            @endforeach

            {{-- <template x-for="gearpiece in gpList">
                <option x-value="gearpiece.ModelName" x-text="gearpiece.ModelName"></option>
            </template> --}}
        </select>
    </div>
</div>
