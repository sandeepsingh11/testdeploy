@props(['skills', 'skillMain' => 'unknown', 'skillId' => 26])

<div>
    {{-- skill slots --}}
    <div>
        <div class="mx-auto">
            <div id="gear-piece-main" class="drag-into border-solid border border-gray-900 rounded-full mx-auto mb-4" style="width: 64px; height: 64px" data-source="slot">
                <img 
                    src="{{ asset('storage/skills/' . $skillMain . '.png') }}" 
                    alt="{{ $skillMain }}"
                    class="draggable"
                    data-skill-id="{{ $skillId }}"
                    data-skill-name="{{ $skillMain }}"
                    data-skill-type="Main"
                    draggable="true"
                >
            </div>

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

            <input type="hidden" name="gear-piece-main" id="hidden-gear-piece-main" value="">
            <input type="hidden" name="gear-piece-sub-1" id="hidden-gear-piece-sub-1" value="">
            <input type="hidden" name="gear-piece-sub-2" id="hidden-gear-piece-sub-2" value="">
            <input type="hidden" name="gear-piece-sub-3" id="hidden-gear-piece-sub-3" value="">
        </div>
    </div>

    {{-- skills bank --}}
    <div class="flex flex-wrap mb-8">
        @for ($i = 0; $i < sizeof($skills); $i++)
            @if ($skills[$i]['allowed'] === 'Main')
                <div data-source="bank">
                    <img 
                        src="{{ asset('storage/skills/' . $skills[$i]['skill'] . '.png') }}" 
                        alt=""
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
    <div class="flex flex-wrap">
        @for ($i = 0; $i < sizeof($skills); $i++)
            @if ($skills[$i]['allowed'] === 'All')
                <div data-source="bank">
                    <img 
                        src="{{ asset('storage/skills/' . $skills[$i]['skill'] . '.png') }}" 
                        alt=""
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