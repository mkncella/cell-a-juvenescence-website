@props([
    'href' => '#',
])

@php
    $path = request()->path();
    $path = $path == '/' ? $path : '/' . $path;
    $isActive = $path == $href;
@endphp

<a {{ $attributes->merge(['class' => 'block py-1 !no-underline rounded-sm md:p-0 md:text-sm flex hover:!text-[#557fff]'])->merge(['class' => $isActive ? '!text-[#557fff] pointer-events-none' : '!text-gray-900 md:!border-0 md:hover:!text-blue-700'])->merge(['href' => $href]) }}>
    {{ $slot }}
</a>

{{-- 
 
<a href="/about-us" 
    :class="isActive('/about-us') ? '' : ''"
    :aria-current="isActive('/about-us') ? 'page' : null">About Us <span x-text="isActive('/about-us') ? 'yes' : 'no'"></span>
</a>

--}}