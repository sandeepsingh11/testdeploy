<div class="bg-gray-700 rounded-md shadow-lg w-1/4 h-full mx-2 mb-6">
    <x-gear.title :title="$gear->gear_name" />
    <x-gear.gear :modelName="$gear->gear_id" />

    <div class="flex justify-evenly">
        <x-gear.skill :skill="$skills[0]" />
        <x-gear.skill :skill="$skills[1]" />
        <x-gear.skill :skill="$skills[2]" />
        <x-gear.skill :skill="$skills[3]" />
    </div>

    <x-gear.desc :desc="$gear->gear_desc" />


    @auth
        @can('delete', $gear)
            <div class="flex justify-evenly">
                <div class="w-full">
                    <a href="{{ route('gears.edit', [$user, $gear]) }}" class="block">
                        <div class="bg-indigo-400 w-full py-2 rounded-bl-md text-center">Edit</div>
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