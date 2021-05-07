@props(['gearpieces', 'skills'])

<div> 
    {{-- gearpiece skill slots --}}
    <div>
        <div class="mx-auto">
            {{-- select game gearpiece (and main skill) --}}
            @livewire('game-gp-select', ['gearpieces' => $gearpieces, 'skills' => $skills])

            {{-- sub skills --}}
            <div class="flex justify-evenly mb-4">
                <div id="gear-piece-sub-1" class="drag-into border-solid border border-gray-900 rounded-full" style="width: 32px; height: 32px" data-source="slot">
                    <img 
                        src="{{ asset('storage/skills/unknown.png') }}" 
                        alt="unknown"
                        class="draggable"
                        data-skill-id="26"
                        data-skill-name="unknown"
                        data-skill-type="All"
                        draggable="true"
                    >
                </div>
                <div id="gear-piece-sub-2" class="drag-into border-solid border border-gray-900 rounded-full" style="width: 32px; height: 32px" data-source="slot">
                    <img 
                        src="{{ asset('storage/skills/unknown.png') }}" 
                        alt="unknown"
                        class="draggable"
                        data-skill-id="26"
                        data-skill-name="unknown"
                        data-skill-type="All"
                        draggable="true"
                    >
                </div>
                <div id="gear-piece-sub-3" class="drag-into border-solid border border-gray-900 rounded-full" style="width: 32px; height: 32px" data-source="slot">
                    <img 
                        src="{{ asset('storage/skills/unknown.png') }}" 
                        alt="unknown"
                        class="draggable"
                        data-skill-id="26"
                        data-skill-name="unknown"
                        data-skill-type="All"
                        draggable="true"
                    >
                </div>
            </div>

            <input type="hidden" name="gear-piece-sub-1" id="hidden-gear-piece-sub-1" value="">
            <input type="hidden" name="gear-piece-sub-2" id="hidden-gear-piece-sub-2" value="">
            <input type="hidden" name="gear-piece-sub-3" id="hidden-gear-piece-sub-3" value="">
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