@props(['link' => '#', 'text' => ''])

<li>
    <a 
        href="{{ $link }}" 
        {{ $attributes->merge(['class' => "block p-3 hover:bg-primary-600 focus:hover:bg-primary-600 transition-colors"]) }}
    >
        {{ $text }}
    </a>
</li>
