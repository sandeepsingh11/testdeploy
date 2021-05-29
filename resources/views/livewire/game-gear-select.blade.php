<div>
    {{-- gear list --}}
    <label for="gear-id" class="block">Select gear:</label>
    <select 
        name="gear-id" 
        id="gear-id"
        class="block w-full rounded focus:ring-primary-400 focus:border-primary-400"
        wire:change="updateGear($event.target.value)"
    >

        @php $i = 0; @endphp
        @foreach ($gears as $gearType)
            
            {{-- head, clothing, or shoes group --}}
            <optgroup label="{{ $gearTypes[$i] }}">
                
                @foreach ($gearType as $gear)
                    {{-- gear --}}
                    <option value="{{ $gear['ModelName'] }}" @if($gear['ModelName'] === $gearName) selected @endif>{{ $gear['ModelName'] }}</option>
                @endforeach

            </optgroup>
            
            @php $i++; @endphp

        @endforeach
    </select>


    {{-- gear image --}}
    <div>
        <img src="{{ asset('storage/gear/' . $gearName . '.png') }}" alt="{{ $gearName }}" class="mx-auto">
    </div>

    <div id="gear-main" class="drag-into border-2 border-r-0 border-b-0 border-solid border-gray-400 rounded-full bg-gray-900 mx-auto mb-4" style="width: 64px; height: 64px; box-shadow: 0 0 0 1px #000" data-source="slot">
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

    <input type="hidden" name="gear-main" id="hidden-gear-main" value="{{ $mainSkillId }}">
</div>
