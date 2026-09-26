@props([
    'type' => 'text',
    'disabled' => false,
    'required' => false,
])

<input {{ $disabled ? 'disabled' : '' }}
       {{ $required ? 'required' : '' }}
       {!! $attributes->merge([
            'type' => $type,
            'class' => 'w-full rounded-input border-slate-300 bg-white text-sm text-slate-900 placeholder-slate-400 shadow-xs transition focus:border-primary focus:ring-primary disabled:bg-slate-50 disabled:text-slate-500',
       ]) !!}>
