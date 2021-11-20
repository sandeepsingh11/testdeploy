@props(['text' => ''])

<h2 {{ $attributes->merge(['class' => 'mb-6 text-4xl']) }}>
    {{ $text }}
</h2>
