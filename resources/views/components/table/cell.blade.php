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

<td {{ $attributes->merge(['class' => 'px-5 py-4 align-middle ' . ($alignments[$align] ?? $alignments['left'])]) }}>
    {{ $slot }}
</td>
