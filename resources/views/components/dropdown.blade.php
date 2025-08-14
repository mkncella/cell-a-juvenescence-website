@props([
    'contextId' => '',
    'trigger' => 'click',
    'placement' => 'right-start',
])

@php

    // allowed trigger
    if (!in_array($trigger, ['click', 'hover'])) {
        $trigger = 'click';
    }
    
    $defaultId = "dropdown";
    $contextId = $defaultId . $contextId;
    $buttonId = $contextId . "Button";
@endphp

<div class="relative" x-data="{
    isOpen: false,
    _placement: @js($placement),
    placement: null,
    placement_class: '',
    buttonBoundingClient: {},
    toggle() {
        this.isOpen = !this.isOpen
    },
    activated() {
        this.isOpen = true
    },
    deActivated() {
        this.isOpen = false
    },
    init() {

        const positions = {
            bottom: 'top-full left-0',            // di bawah tombol
            'bottom-start': 'top-full left-0',    // di bawah, rata kiri
            'bottom-end': 'top-full right-0',     // di bawah, rata kanan
        
            top: 'bottom-full left-0',            // di atas tombol
            'top-start': 'bottom-full left-0',    // di atas, rata kiri
            'top-end': 'bottom-full right-0',     // di atas, rata kanan
        
            right: 'left-full top-1/2 -translate-y-1/2', // kanan, tengah
            'right-start': 'left-full top-0',     // kanan, atas
            'right-end': 'left-full bottom-0',    // kanan, bawah
        
            left: 'right-full top-1/2 -translate-y-1/2', // kiri, tengah
            'left-start': 'right-full top-0',     // kiri, atas
            'left-end': 'right-full bottom-0',    // kiri, bawah
        }
        

        this.placement_class = positions[this._placement] || positions.bottom
    },

}">

    <button
        {{ $button->attributes->merge(['class' => 'flex items-center justify-between w-full px-4 py-2 hover:bg-gray-100']) }}
        type="button" x-ref="button"

        @if ($trigger == 'click')
            @@click="() => toggle"
        @elseif ($trigger == 'hover')
            @@mouseenter="activated"
            @@mouseleave="deActivated"
        @endif
        
    >{{ $button }}</button>

    @isset($dropdownMenu)
    
      <div 
          {{ $dropdownMenu->attributes->merge(['class' => 'absolute z-12 bg-white divide-y divide-gray-100 rounded-lg shadow-lg w-44']) }}
          x-show="isOpen"
          x-transition
          x-cloak
          :class="placement_class"

          @if ($trigger == 'click')
              @@click="() => toggle"
          @elseif ($trigger == 'hover')
              @@mouseenter="activated"
              @@mouseleave="deActivated"
          @endif
      >{{ $dropdownMenu }}</div>
        
    @endisset


</div>

{{-- <button 
    id="{{ $buttonId }}" 
    data-dropdown-toggle="{{ $contextId }}" 
    data-dropdown-trigger="{{ $trigger }}" 
    data-dropdown-placement="{{ $placement }}"
    {{ $button->attributes->merge(['class' => 'flex items-center justify-between w-full px-4 py-2 hover:bg-gray-100']) }}
    type="button"
>{{ $button }}</button> --}}



{{-- <div 
    id="{{ $contextId }}" 
    {{ $dropdownMenu->attributes->merge(['class' => 'z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44']) }}
>{{ $dropdownMenu }}</div> --}}

{{-- <x-slot:button 
    id="{{ $buttonId }}" 
    data-dropdown-toggle="{{ $contextId }}" 
    data-dropdown-trigger="{{ $trigger }}" 
    data-dropdown-placement="{{ $placement }}"
    {{ $attributes->merge(['class' => 'flex items-center justify-between w-full px-4 py-2 hover:bg-gray-100']) }}
    type="button"
></x-slot:button> --}}


{{-- <x-slot:dropdownMenu 
    id="{{ $contextId }}" 
    {{ $attributes->merge(['class' => 'z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44']) }}
></x-slot:dropdownMenu> --}}

{{-- <button id="doubleDropdownButton" data-dropdown-toggle="doubleDropdown" 
    data-dropdown-trigger="hover" 
    data-dropdown-placement="right-start"
    type="button"
    class="flex items-center justify-between w-full px-4 py-2 hover:bg-gray-100">
    Became Our Partner
    <svg class="w-2.5 h-2.5 ms-2.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
            d="m1 1 4 4 4-4" />
    </svg>
</button> --}}

{{-- <div id="doubleDropdown" 
    class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44">
    <ul class="py-2 text-sm text-gray-700">
        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Overview</a></li>
        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">My downloads</a></li>
        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Billing</a></li>
        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Rewards</a></li>
    </ul>
</div> --}}