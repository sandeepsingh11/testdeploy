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
        <div class="mx-auto">
            {{-- select game gear (and main skill) --}}
            @livewire('game-gear-select', ['gears' => $gears, 'skills' => $skills, 'gearName' => $gearName, 'mainSkill' => $gearSkills[0], 'mainSkillId' => $mainSkillId])

            {{-- sub skills --}}
            <div class="flex justify-evenly mb-4">
                <div id="gear-sub-1" class="drag-into border-solid border border-gray-900 rounded-full" style="width: 32px; height: 32px" data-source="slot">
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
                <div id="gear-sub-2" class="drag-into border-solid border border-gray-900 rounded-full" style="width: 32px; height: 32px" data-source="slot">
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
                <div id="gear-sub-3" class="drag-into border-solid border border-gray-900 rounded-full" style="width: 32px; height: 32px" data-source="slot">
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
    <div class="flex flex-wrap mb-8">
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
    {{-- all other skills --}}
    <div class="flex flex-wrap">
        @for ($i = 0; $i < sizeof($skills); $i++)
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