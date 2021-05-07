<div>
    {{-- gearpiece list --}}
    <div>
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
                        <option value="{{ $gearpiece['ModelName'] }}">{{ $gearpiece['ModelName'] }}</option>
                    @endforeach

                </optgroup>
                
                @php $i++; @endphp

            @endforeach
        </select>


        {{-- gearpiece image --}}
        <div>
            <img src="{{ asset('storage/gear/' . $gpName . '.png') }}" alt="{{ $gpName }}" class="mx-auto">
        </div>

        {{-- list skills for drag-and-drop --}}
        <x-gear-piece.skills-builder :skills="$skills" :skillMain="$gpSkill" :skillId="$gpSkillId" />
    </div>
</div>
