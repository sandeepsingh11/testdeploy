@props(['link' => '', 'text' => ''])

<a href="{{ $link }}" {{ $attributes->merge(['class' => 'cursor:pointer bg-pink-600 text-white px-4 py-2 rounded hover:bg-pink-700 transition-colors']) }}>
    {{ $text }}
</a>
