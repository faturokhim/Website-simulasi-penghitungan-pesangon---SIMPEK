@props([
    'disabled' => false,
])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' => 'w-full rounded-input border-slate-300 bg-white text-sm text-slate-900 placeholder-slate-400 shadow-xs transition focus:border-primary focus:ring-primary disabled:bg-slate-50 disabled:text-slate-500',
]) !!}>
