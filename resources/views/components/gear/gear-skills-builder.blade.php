@props([
    'gears', 
    'skills',
    'gearSkills' => ['unknown', 'unknown', 'unknown', 'unknown'],
    'gearName' => 'Hed_FST000',
    'mainSkillId' => 26,
    'subSkill1Id' => 26,
    'subSkill2Id' => 26,
    'subSkill3Id' => 26,
])



<div> 
    {{-- gear skill slots --}}
    <div>
        <div>
            {{-- select game gear (and main skill) --}}
            @livewire('game-gear-select', ['gears' => $gears, 'skills' => $skills, 'gearName' => $gearName, 'mainSkill' => $gearSkills[0], 'mainSkillId' => $mainSkillId])

            {{-- sub skills --}}
            <div class="flex justify-evenly mb-4">
                <div id="gear-sub-1" class="drag-into border-2 border-r-0 border-b-0 border-solid border-gray-400 rounded-full bg-gray-900" style="width: 50px; height: 50px; box-shadow: 0 0 0 1px #000" data-source="slot">
                    <img 
                        src="{{ asset('storage/skills/' . $gearSkills[1] . '.png') }}" 
                        alt="{{ $gearSkills[1] }}"
                        class="draggable"
                        data-skill-id="{{ $subSkill1Id }}"
                        data-skill-name="{{ $gearSkills[1] }}"
                        data-skill-type="All"
                        draggable="true"
                    >
                </div>
                <div id="gear-sub-2" class="drag-into border-2 border-r-0 border-b-0 border-solid border-gray-400 rounded-full bg-gray-900" style="width: 50px; height: 50px; box-shadow: 0 0 0 1px #000" data-source="slot">
                    <img 
                        src="{{ asset('storage/skills/' . $gearSkills[2] . '.png') }}" 
                        alt="{{ $gearSkills[2] }}"
                        class="draggable"
                        data-skill-id="{{ $subSkill2Id }}"
                        data-skill-name="{{ $gearSkills[2] }}"
                        data-skill-type="All"
                        draggable="true"
                    >
                </div>
                <div id="gear-sub-3" class="drag-into border-2 border-r-0 border-b-0 border-solid border-gray-400 rounded-full bg-gray-900" style="width: 50px; height: 50px; box-shadow: 0 0 0 1px #000" data-source="slot">
                    <img 
                        src="{{ asset('storage/skills/' . $gearSkills[3] . '.png') }}" 
                        alt="{{ $gearSkills[3] }}"
                        class="draggable"
                        data-skill-id="{{ $subSkill3Id }}"
                        data-skill-name="{{ $gearSkills[3] }}"
                        data-skill-type="All"
                        draggable="true"
                    >
                </div>
            </div>

            <input type="hidden" name="gear-sub-1" id="hidden-gear-sub-1" value="{{ $subSkill1Id }}">
            <input type="hidden" name="gear-sub-2" id="hidden-gear-sub-2" value="{{ $subSkill2Id }}">
            <input type="hidden" name="gear-sub-3" id="hidden-gear-sub-3" value="{{ $subSkill3Id }}">
        </div>
    </div>

    {{-- skills bank --}}
    {{-- main skill exclusives --}}
    <div class="grid grid-cols-6 mb-6">
        @for ($i = 0; $i < sizeof($skills); $i++)
            @if ($skills[$i]['allowed'] === 'Main')
                <div data-source="bank">
                    <img 
                        src="{{ asset('storage/skills/' . $skills[$i]['skill'] . '.png') }}" 
                        alt="{{ $skills[$i]['skill'] }}"
                        class="draggable"
                        data-skill-id="{{ $skills[$i]['id'] }}"
                        data-skill-name="{{ $skills[$i]['skill'] }}"
                        data-skill-type="{{ $skills[$i]['allowed'] }}"
                        draggable="true"
                    >
                </div>
            @endif
        @endfor
    </div>

    <hr class="w-4/5 mx-auto border-primary-400 border-t-2">
    
    {{-- all other skills --}}
    <div class="grid grid-cols-7 mt-6">
        @for ($i = 0; $i < sizeof($skills) - 1; $i++) {{-- -1 to exclude skill #26, or 'unknown' --}}
            @if ($skills[$i]['allowed'] === 'All')
                <div data-source="bank">
                    <img 
                        src="{{ asset('storage/skills/' . $skills[$i]['skill'] . '.png') }}" 
                        alt="{{ $skills[$i]['skill'] }}"
                        class="draggable"
                        data-skill-id="{{ $skills[$i]['id'] }}"
                        data-skill-name="{{ $skills[$i]['skill'] }}"
                        data-skill-type="{{ $skills[$i]['allowed'] }}"
                        draggable="true"
                    >
                </div>
            @endif
        @endfor
    </div>
</div>