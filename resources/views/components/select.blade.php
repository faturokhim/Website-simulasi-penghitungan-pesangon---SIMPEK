@props([
    'disabled' => false,
])

<select {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' => 'w-full rounded-input border-slate-300 bg-white text-sm text-slate-900 shadow-xs transition focus:border-primary focus:ring-primary disabled:bg-slate-50 disabled:text-slate-500',
]) !!}>{{ $slot }}</select>
