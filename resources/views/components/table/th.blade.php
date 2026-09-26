@props([
    'align' => 'left',
])

@php
    $alignments = [
        'left' => 'text-left',
        'center' => 'text-center',
        'right' => 'text-right',
    ];
@endphp

<th {{ $attributes->merge(['class' => 'px-5 py-3 font-semibold ' . ($alignments[$align] ?? $alignments['left'])]) }}>
    {{ $slot }}
</th>
