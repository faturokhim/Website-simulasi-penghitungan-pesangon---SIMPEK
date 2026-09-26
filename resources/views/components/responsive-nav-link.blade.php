@props(['active' => false])

@php
    $classes = $active
        ? 'block border-l-4 border-primary-700 bg-primary-50 px-3 py-2.5 text-start text-sm font-semibold text-primary-900 transition duration-150 ease-in-out'
        : 'block border-l-4 border-transparent px-3 py-2.5 text-start text-sm font-medium text-slate-600 transition duration-150 ease-in-out hover:border-slate-300 hover:bg-slate-50 hover:text-slate-900';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
