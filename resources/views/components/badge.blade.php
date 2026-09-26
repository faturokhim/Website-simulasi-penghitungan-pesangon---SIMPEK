@props([
    'variant' => 'neutral',
    'icon' => null,
])

@php
    $variants = [
        'neutral' => 'bg-slate-100 text-slate-700 border-slate-200',
        'primary' => 'bg-primary-100 text-primary-900 border-primary-200',
        'success' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
        'warning' => 'bg-amber-100 text-amber-900 border-amber-200',
        'danger' => 'bg-rose-100 text-rose-800 border-rose-200',
        'info' => 'bg-sky-100 text-sky-900 border-sky-200',
    ];
@endphp

<span {{ $attributes->merge(['class' => 'badge ' . ($variants[$variant] ?? $variants['neutral'])]) }}>
    @if ($icon)
        <x-icon :name="$icon" :size="12" :stroke-width="2.5" />
    @endif
    {{ $slot }}
</span>
