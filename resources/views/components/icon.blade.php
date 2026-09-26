@props([
    'name',
    'size' => 18,
    'strokeWidth' => 2,
    'label' => null,
])

@php
    $svg = lucide_icon_svg($name);
@endphp

@if ($svg)
    <svg {{ $attributes->merge(['class' => 'shrink-0']) }}
         width="{{ $size }}"
         height="{{ $size }}"
         viewBox="0 0 24 24"
         fill="none"
         stroke="currentColor"
         stroke-width="{{ $strokeWidth }}"
         stroke-linecap="round"
         stroke-linejoin="round"
         @if ($label) role="img" aria-label="{{ $label }}" @else aria-hidden="true" @endif
    >{!! $svg !!}</svg>
@endif
