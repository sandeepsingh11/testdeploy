<div class="bg-gray-700 rounded-md shadow-lg w-1/4 h-full mx-2 mb-6">
    <x-gear-piece.title :title="$gearpiece->gear_piece_name" />
    <x-gear-piece.gear :modelName="$gearpiece->gear_piece_id" />

    <div class="flex justify-evenly">
        <x-gear-piece.skill :skill="$skills[0]" />
        <x-gear-piece.skill :skill="$skills[1]" />
        <x-gear-piece.skill :skill="$skills[2]" />
        <x-gear-piece.skill :skill="$skills[3]" />
    </div>

    <x-gear-piece.desc :desc="$gearpiece->gear_piece_desc" />


    @auth
        @can('delete', $gearpiece)
        <div class="flex justify-evenly">
                <form action="" method="post" class="w-full">
                    @csrf
                    @method('UPDATE')
                    <button type="submit" class="bg-indigo-400 w-full py-2 rounded-bl-md">Edit</button>
                </form>

                <form action="{{ route('gearpieces.delete', [$user, $gearpiece]) }}" method="post" class="w-full">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-400 w-full py-2 rounded-br-md">Delete</button>
                </form>
            </div>
        @endcan
    @endauth
</div>