@props(['modelName' => null])

<div class="p-4">
    <img src="{{ asset('storage/gear/' . $modelName . '.png') }}" alt="{{ $modelName }}" class="mx-auto">
</div>