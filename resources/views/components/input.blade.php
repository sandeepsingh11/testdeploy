@props(['disabled' => false, 'value' => ''])

{{-- @error($errorName)
    @php
        $errorClass = 'border-red-500';
    @endphp
@enderror --}}

<input 
    {{ $disabled ? 'disabled' : '' }} 
    {!! $attributes->merge(['class' => 'p-2.5 rounded-lg shadow-sm border-2 border-gray-300 focus:border-indigo-600']) !!}
    value="{{ $value }}"
>