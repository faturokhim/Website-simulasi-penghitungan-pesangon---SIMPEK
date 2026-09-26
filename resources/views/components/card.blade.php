@props([
    'href' => null,
    'padded' => true,
])

@php
    $classes = 'bg-surface border border-slate-200 rounded-card shadow-card';
    if ($padded) {
        $classes .= ' p-5 sm:p-6';
    }
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes . ' block transition-shadow hover:shadow-card-hover']) }}>
        {{ $slot }}
    </a>
@else
    <div {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </div>
@endif
