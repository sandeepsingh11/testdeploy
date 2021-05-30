<div class="bg-gray-700 rounded-md shadow-lg @if ($hover) transform hover:-translate-y-2 transition-transform @endif">
    @if ($link) <a href="{{ route('gears.show', [$user, $gear]) }}"> @endif
        <x-gear.title :title="$gear->gear_name" />
        <x-gear.gear :modelName="$gear->gear_id" />
    
        <div class="grid grid-cols-4 items-end">
            <x-gear.skill :skill="$skills[0]" :imgSize=64 />
            <x-gear.skill :skill="$skills[1]" />
            <x-gear.skill :skill="$skills[2]" />
            <x-gear.skill :skill="$skills[3]" />
        </div>
    
        <x-gear.desc :desc="$gear->gear_desc" />
    @if ($link) </a> @endif


    @auth
        @can('delete', $gear)
            <div class="flex justify-evenly">
                <div class="w-full">
                    <a href="{{ route('gears.edit', [$user, $gear]) }}" class="block">
                        <div class="bg-secondary-400 w-full py-2 rounded-bl-md text-center">Edit</div>
                    </a>
                </div>

                <form action="{{ route('gears.delete', [$user, $gear]) }}" method="post" class="w-full">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-400 w-full py-2 rounded-br-md">Delete</button>
                </form>
            </div>
        @endcan
    @endauth
</div>