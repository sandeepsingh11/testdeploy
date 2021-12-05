@props([
    'filteredList' => [],
    'selectId' => ''
])

<style>
    .search-input {
	    background: #fff no-repeat 5px center url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16px' height='16px' class='h-6 w-6' fill='none' viewBox='0 0 24 24' stroke='currentColor'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z' /%3E%3C/svg%3E");
    }
</style>

<div>
    <div class="flex">
        {{-- search --}}
        <input
            type="text" 
            wire:model.debounce.500ms="searchTerm" 
            wire:keydown="search"
            class="search-input w-1/2 sm:w-full rounded-tl rounded-bl  pl-7 focus:ring-primary-400 focus:border-primary-400"
        >

        {{-- select --}}
        <select 
            name="{{ $selectId }}" 
            id="{{ $selectId }}"
            wire:change="selectUpdate($event.target.value)"
            {{ $attributes->merge(['class' => 'w-1/2 sm:w-full rounded-tr rounded-br focus:ring-primary-400 focus:border-primary-400']) }}
        >
            @foreach ($filteredList as $key => $value)
                <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>
    </div>
</div>