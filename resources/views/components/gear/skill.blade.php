@props(['skill' => 'unknown', 'imgSize' => 50])

<div class="justify-self-center p-2">
    <img src="{{ asset('storage/skills/' . $skill . '.png') }}" alt="{{ $skill }}" width="{{ $imgSize }}" height="{{ $imgSize }}">
</div>