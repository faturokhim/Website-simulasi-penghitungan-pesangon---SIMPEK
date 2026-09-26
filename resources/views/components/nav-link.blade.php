@props(['active' => false])

@php
    $classes = $active
        ? 'inline-flex items-center border-b-2 border-primary-700 px-1 pt-1 text-sm font-semibold text-slate-900 transition duration-150 ease-in-out'
        : 'inline-flex items-center border-b-2 border-transparent px-1 pt-1 text-sm font-medium text-slate-500 transition duration-150 ease-in-out hover:border-slate-300 hover:text-slate-800';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
