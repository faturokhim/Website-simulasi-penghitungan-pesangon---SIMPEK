@props([
    'variant' => 'primary',
    'size' => 'md',
    'href' => null,
    'type' => 'button',
    'icon' => null,
    'iconPosition' => 'left',
    'disabled' => false,
])

@php
    $variants = [
        'primary' => 'bg-primary text-white border-transparent hover:bg-primary-800 shadow-xs',
        'secondary' => 'bg-white text-slate-700 border-slate-300 hover:bg-slate-50 shadow-xs',
        'outline' => 'bg-transparent text-primary border-primary-700 hover:bg-primary-50',
        'ghost' => 'bg-transparent text-slate-600 border-transparent hover:bg-slate-100 hover:text-slate-900',
        'danger' => 'bg-rose-600 text-white border-transparent hover:bg-rose-700 shadow-xs',
        'success' => 'bg-emerald-700 text-white border-transparent hover:bg-emerald-800 shadow-xs',
        'warning' => 'bg-amber-600 text-white border-transparent hover:bg-amber-700 shadow-xs',
        'dark' => 'bg-slate-900 text-white border-transparent hover:bg-slate-800 shadow-xs',
        'light' => 'bg-white text-primary-800 border-transparent hover:bg-primary-50 shadow-xs',
    ];

    $sizes = [
        'xs' => 'px-2.5 py-1.5 text-xs gap-1.5',
        'sm' => 'px-3 py-2 text-xs gap-1.5',
        'md' => 'px-4 py-2.5 text-sm gap-2',
        'lg' => 'px-6 py-3 text-sm sm:text-base gap-2',
    ];

    $iconSizes = ['xs' => 14, 'sm' => 16, 'md' => 18, 'lg' => 20];

    $classes = [
        'inline-flex items-center justify-center rounded-button border font-semibold',
        'transition-colors duration-150',
        'focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary focus-visible:ring-offset-2',
        'disabled:opacity-50 disabled:cursor-not-allowed',
        $sizes[$size] ?? $sizes['md'],
        $variants[$variant] ?? $variants['primary'],
    ];
@endphp

@if ($href)
    <a href="{{ $href }}"
       {{ $attributes->merge(['class' => implode(' ', $classes)]) }}
       @if ($disabled) aria-disabled="true" tabindex="-1" @endif>
        @if ($icon && $iconPosition === 'left')
            <x-icon :name="$icon" :size="$iconSizes[$size] ?? 18" />
        @endif
        {{ $slot }}
        @if ($icon && $iconPosition === 'right')
            <x-icon :name="$icon" :size="$iconSizes[$size] ?? 18" />
        @endif
    </a>
@else
    <button type="{{ $type }}"
            {{ $attributes->merge(['class' => implode(' ', $classes)]) }}
            @if ($disabled) disabled @endif>
        @if ($icon && $iconPosition === 'left')
            <x-icon :name="$icon" :size="$iconSizes[$size] ?? 18" />
        @endif
        {{ $slot }}
        @if ($icon && $iconPosition === 'right')
            <x-icon :name="$icon" :size="$iconSizes[$size] ?? 18" />
        @endif
    </button>
@endif
