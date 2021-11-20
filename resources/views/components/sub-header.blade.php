@props(['text' => ''])

<h3 {{ $attributes->merge(['class' => 'mb-4 text-3xl']) }}>
    {{ $text }}
</h3>
