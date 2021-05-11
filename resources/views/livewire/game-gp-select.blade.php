<div>
    {{-- gearpiece list --}}
    <label for="gear-piece-id" class="block text-white text-center">Gearpiece</label>
    <select 
        name="gear-piece-id" 
        id="gear-piece-id"
        class="block w-full"
        wire:change="updateGearpiece($event.target.value)"
    >

        @php $i = 0; @endphp
        @foreach ($gearpieces as $gearpieceType)
            
            {{-- head, clothing, or shoes group --}}
            <optgroup label="{{ $gearpieceTypes[$i] }}">
                
                @foreach ($gearpieceType as $gearpiece)
                    {{-- gearpiece --}}
                    <option value="{{ $gearpiece['ModelName'] }}" @if($gearpiece['ModelName'] === $gpName) selected @endif>{{ $gearpiece['ModelName'] }}</option>
                @endforeach

            </optgroup>
            
            @php $i++; @endphp

        @endforeach
    </select>


    {{-- gearpiece image --}}
    <div>
        <img src="{{ asset('storage/gear/' . $gpName . '.png') }}" alt="{{ $gpName }}" class="mx-auto">
    </div>

    
    <div id="gear-piece-main" class="drag-into border-solid border border-gray-900 rounded-full mx-auto mb-4" style="width: 64px; height: 64px" data-source="slot">
        <img 
            src="{{ asset('storage/skills/' . $mainSkill . '.png') }}" 
            alt="{{ $mainSkill }}"
            class="draggable"
            data-skill-id="{{ $mainSkillId }}"
            data-skill-name="{{ $mainSkill }}"
            data-skill-type="Main"
            draggable="true"
        >
    </div>

    <input type="hidden" name="gear-piece-main" id="hidden-gear-piece-main" value="{{ $mainSkillId }}">
</div>
