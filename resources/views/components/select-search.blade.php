@props([
    'filteredList' => [],
    'selectId' => ''
])

<div>
    {{-- search --}}
    <div>
        <input type="text" wire:model.debounce.500ms="searchTerm" wire:keydown="search">
    </div>

    {{-- select --}}
    <select 
        name="{{ $selectId }}" 
        id="{{ $selectId }}"
        wire:change="selectUpdate($event.target.value)"
        {{ $attributes->merge(['class' => 'block w-full rounded focus:ring-primary-400 focus:border-primary-400']) }}
    >
        @foreach ($filteredList as $key => $value)
            <option value="{{ $key }}">{{ $value }}</option>
        @endforeach
    </select>
</div>