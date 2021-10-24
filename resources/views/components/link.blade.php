@props(['link' => '#', 'text' => ''])

<a href="{{ $link }}" {{ $attributes->merge(['class' => 'cursor:pointer text-indigo-800 hover:text-indigo-600 hover:underline transition-colors']) }}>
    {{ $text }}
</a>
