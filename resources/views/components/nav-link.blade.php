@props(['href', 'label', 'mobile' => false])

@php
    $isActive = request()->is(ltrim($href, '/'));
@endphp

<a href="{{ $href }}"
   class="{{ $mobile ? 'block' : '' }} text-sm font-medium transition-colors duration-200 !no-underline {{ $isActive ? 'text-blue-700 activvve' : '!text-gray-700 hover:!text-blue-700' }}">
    {{ $label }}
</a>
