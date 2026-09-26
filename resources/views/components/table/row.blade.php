@props([
    'hover' => true,
])

<tr {{ $attributes->merge(['class' => $hover ? 'transition-colors hover:bg-primary-50/60' : '']) }}>
    {{ $slot }}
</tr>
