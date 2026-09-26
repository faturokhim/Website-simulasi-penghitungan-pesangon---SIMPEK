@props([
    'label',
    'value',
    'hint' => null,
    'icon' => null,
    'tone' => 'default',
    'href' => null,
])

@php
    $tones = [
        'default' => 'bg-surface text-slate-900 border-slate-200 hover:shadow-card-hover',
        'primary' => 'bg-primary-700 text-white border-primary-700 hover:bg-primary-800',
        'success' => 'bg-emerald-50 text-emerald-900 border-emerald-200',
        'warning' => 'bg-amber-50 text-amber-900 border-amber-200',
    ];
    $iconTones = [
        'default' => 'bg-primary-100 text-primary-700',
        'primary' => 'bg-white/15 text-white',
        'success' => 'bg-emerald-100 text-emerald-700',
        'warning' => 'bg-amber-100 text-amber-700',
    ];
    $labelTone = ['default' => 'text-slate-600', 'primary' => 'text-primary-100', 'success' => 'text-emerald-700', 'warning' => 'text-amber-700'];
    $valueTone = ['default' => 'text-slate-900', 'primary' => 'text-white', 'success' => 'text-emerald-900', 'warning' => 'text-amber-900'];
    $hintTone = ['default' => 'text-slate-500', 'primary' => 'text-primary-100', 'success' => 'text-emerald-600', 'warning' => 'text-amber-700'];

    $base = 'flex items-start justify-between gap-4 rounded-card border p-5 shadow-card transition-shadow ' . ($tones[$tone] ?? $tones['default']);
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $base]) }}>
@else
    <div {{ $attributes->merge(['class' => $base]) }}>
@endif
        <div class="min-w-0">
            <p class="text-xs font-semibold uppercase tracking-wide {{ $labelTone[$tone] ?? $labelTone['default'] }}">{{ $label }}</p>
            <p class="mt-1.5 text-3xl font-bold leading-none tabular {{ $valueTone[$tone] ?? $valueTone['default'] }}">{{ $value }}</p>
            @if ($hint)
                <p class="mt-2 text-xs {{ $hintTone[$tone] ?? $hintTone['default'] }}">{{ $hint }}</p>
            @endif
        </div>
        @if ($icon)
            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-badge {{ $iconTones[$tone] ?? $iconTones['default'] }}">
                <x-icon :name="$icon" :size="20" />
            </span>
        @endif
@if ($href)
    </a>
@else
    </div>
@endif
