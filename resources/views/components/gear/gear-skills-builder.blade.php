@props([
    'gears', 
    'skills',
    'gearSkills' => ['unknown', 'unknown', 'unknown', 'unknown'],
    'gearName' => 'Hed_FST000',
    'mainSkillId' => 27,
    'subSkill1Id' => 27,
    'subSkill2Id' => 27,
    'subSkill3Id' => 27,
])



<div> 
    {{-- gear skill slots --}}
    <div>
        <div>
            {{-- select game gear (and main skill) --}}
            @livewire('base-gear-select', ['gears' => $gears, 'skills' => $skills, 'gearName' => $gearName, 'mainSkill' => $gearSkills[0], 'mainSkillId' => $mainSkillId])

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

            <input type="hidden" name="skill-sub-1" id="hidden-skill-sub-1" value="{{ $subSkill1Id }}">
            <input type="hidden" name="skill-sub-2" id="hidden-skill-sub-2" value="{{ $subSkill2Id }}">
            <input type="hidden" name="skill-sub-3" id="hidden-skill-sub-3" value="{{ $subSkill3Id }}">
        </div>
    </div>

    {{-- skills bank --}}
    {{-- main skill exclusives --}}
    <div class="grid grid-cols-6 mb-6">
        @foreach ($skills->where('is_main', true) as $skill)
            <div data-source="bank">
                <img 
                    src="{{ asset('storage/skills/' . $skill->skill_name . '.png') }}" 
                    alt="{{ $skill->skill_name }}"
                    class="draggable"
                    data-skill-id="{{ $skill->id }}"
                    data-skill-name="{{ $skill->skill_name }}"
                    data-skill-type="Main"
                    draggable="true"
                >
            </div>
        @endforeach
    </div>

    <hr class="w-4/5 mx-auto border-primary-400 border-t-2">
    
    {{-- all other skills --}}
    <div class="grid grid-cols-7 mt-6">
        @foreach ($skills->where('is_main', false) as $skill)
            <div data-source="bank">
                @if ($skill->id != 27) {{-- exclude skill 27 ('unknown') --}}
                    <img 
                        src="{{ asset('storage/skills/' . $skill->skill_name . '.png') }}" 
                        alt="{{ $skill->skill_name }}"
                        class="draggable"
                        data-skill-id="{{ $skill->id }}"
                        data-skill-name="{{ $skill->skill_name }}"
                        data-skill-type="All"
                        draggable="true"
                    >
                @endif
            </div>
        @endforeach
    </div>
</div>