@props(['skill' => 'unknown', 'imgSize' => 50])

<div class="mx-auto p-2">
    <img src="{{ asset('storage/skills/' . $skill . '.png') }}" alt="{{ $skill }}" width="{{ $imgSize }}" height="{{ $imgSize }}" class="mx-auto">
</div>