<div class="bg-gray-700 rounded-md shadow-lg h-full mb-6">
    
    {{-- gear's title --}}
    <x-gear-piece.title :title="$gear->gear_name" />

    {{-- gear's modes --}}
    <x-gear.mode :gear="$gear" />

    {{-- body --}}
    <div class="flex justify-evenly">
        
        {{-- gear's weapon --}}
        <x-gear.weapon :gear="$gear" :weapons="$weapons" />
    
        {{-- gear's gearpieces --}}
        @foreach ($gearpieces[$gear->id] as $gearpiece)
            <div>
                {{-- gear --}}
                <x-gear-piece.gear :modelName="$gearpiece->gear_piece_id" />
    
                {{-- get this gearpiece's skills --}}
                @php
                    $gpc = new App\Http\Controllers\User\GearPieceController;
                    $skills = $gpc->getGearPieceSkills($gearpiece);
                @endphp
    
                {{-- gearpiece's skills --}}
                <x-gear-piece.skill :skill="$skills[0]" />
                <div class="flex justify-evenly">
                    <x-gear-piece.skill :skill="$skills[1]" />
                    <x-gear-piece.skill :skill="$skills[2]" />
                    <x-gear-piece.skill :skill="$skills[3]" />
                </div>
            </div>
        @endforeach
    </div>

    {{-- gear's description --}}
    <x-gear-piece.desc :desc="$gear->gear_desc" />
</div>