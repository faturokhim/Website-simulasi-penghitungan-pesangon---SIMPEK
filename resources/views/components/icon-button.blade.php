@props([
    'icon',
    'label',
    'href' => null,
    'variant' => 'ghost',
    'size' => 'md',
    'type' => 'button',
    'disabled' => false,
])

@php
    $variants = [
        'ghost' => 'text-slate-600 border-transparent hover:bg-slate-100 hover:text-slate-900',
        'outline' => 'text-slate-700 border-slate-300 bg-white hover:bg-slate-50 shadow-xs',
        'primary' => 'text-white bg-primary border-transparent hover:bg-primary-800 shadow-xs',
        'danger' => 'text-white bg-rose-600 border-transparent hover:bg-rose-700 shadow-xs',
    ];
    $sizes = ['sm' => 'h-8 w-8', 'md' => 'h-9 w-9', 'lg' => 'h-10 w-10'];
    $iconSizes = ['sm' => 15, 'md' => 17, 'lg' => 18];

    $classes = implode(' ', [
        'inline-flex items-center justify-center rounded-button border transition-colors',
        'focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary focus-visible:ring-offset-2',
        'disabled:opacity-50 disabled:cursor-not-allowed',
        $sizes[$size] ?? $sizes['md'],
        $variants[$variant] ?? $variants['ghost'],
    ]);
@endphp

@if ($href)
    <a href="{{ $href }}"
       aria-label="{{ $label }}"
       title="{{ $label }}"
       {{ $attributes->merge(['class' => $classes]) }}>
        <x-icon :name="$icon" :size="$iconSizes[$size] ?? 17" />
    </a>
@else
    <button type="{{ $type }}"
            aria-label="{{ $label }}"
            title="{{ $label }}"
            {{ $attributes->merge(['class' => $classes]) }}
            @if ($disabled) disabled @endif>
        <x-icon :name="$icon" :size="$iconSizes[$size] ?? 17" />
    </button>
@endif
