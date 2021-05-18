@props(['skill' => 'unknown'])

<div class="p-4">
    <img src="{{ asset('storage/skills/' . $skill . '.png') }}" alt="{{ $skill }}">
</div>