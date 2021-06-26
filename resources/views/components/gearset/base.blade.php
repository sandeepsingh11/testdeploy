<div class="bg-gray-700 rounded-md shadow-lg @if ($hover) transform hover:-translate-y-2 transition-transform @endif">
    @if ($link) <a href="{{ route('gearsets.show', [$user, $gearset]) }}"> @endif
        {{-- gearset's title --}}
        <x-gear.title :title="$gearset->gearset_title" />

        {{-- gearset's modes --}}
        <x-gearset.mode :gearset="$gearset" />

        {{-- body --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-2 md:gap-4">
            
            {{-- gearset's weapon --}}
            <x-gearset.weapon :gearset="$gearset" :weapon="$gearset->weapon" />
        
            {{-- gearset's gears --}}
            @foreach ($gears[$gearset->id] as $gear)
                <div>
                    {{-- gear --}}
                    <x-gear.gear :gearName="$gear->baseGear->base_gear_name" />
        
                    {{-- gear's skills --}}
                    <x-gear.skill :skillName="$gear->mainSkill->skill_name" />
                    <div class="flex justify-evenly">
                        <x-gear.skill :skillName="$gear->subSkill1->skill_name" />
                        <x-gear.skill :skillName="$gear->subSkill2->skill_name" />
                        <x-gear.skill :skillName="$gear->subSkill3->skill_name" />
                    </div>
                </div>
            @endforeach
        </div>

        {{-- gearset's description --}}
        <x-gear.desc :desc="$gearset->gearset_desc" />
    @if ($link) </a> @endif


    {{-- edit and delete gearset --}}
    @auth
        @can('delete', $gearset)
            <div class="flex justify-evenly">
                <a href="{{ route('gearsets.edit', [$user, $gearset]) }}" class="block w-full">
                    <div class="bg-indigo-400 w-full py-2 rounded-bl-md text-center">Edit</div>
                </a>

                <form action="{{ route('gearsets.delete', [$user, $gearset]) }}" method="post" class="w-full">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-400 w-full py-2 rounded-br-md">Delete</button>
                </form>
            </div>
        @endcan
    @endauth

</div>