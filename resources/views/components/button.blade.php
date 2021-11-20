@props(['text' => ''])

<button {{ $attributes->merge(['type' => 'submit', 'class' => 'w-full bg-indigo-700 px-4 py-2 border border-transparent rounded text-white hover:bg-indigo-600 focus:bg-indigo-600 focus:ring focus:ring-indigo-300 disabled:opacity-25 transition duration-150']) }}>
    {{ $text }}
</button>
