<div class="bg-purple-300">
    <x-gear-piece.title :title="$gearpiece->gear_piece_name" />
    <x-gear-piece.gear :modelName="$gearpiece->gear_piece_id" />
    <x-gear-piece.skill :skill="$skills[0]" />
    <x-gear-piece.skill :skill="$skills[1]" />
    <x-gear-piece.skill :skill="$skills[2]" />
    <x-gear-piece.skill :skill="$skills[3]" />
    <x-gear-piece.desc :desc="$gearpiece->gear_piece_desc" />
</div>