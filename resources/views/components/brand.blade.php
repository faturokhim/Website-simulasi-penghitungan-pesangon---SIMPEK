@props([
    'href' => null,
    'size' => 'md',
    'tone' => 'light',
])

@php
    $href = $href ?? route('home');
    $sizes = [
        'sm' => ['box' => 'h-8 w-8 text-sm', 'name' => 'text-sm', 'tag' => 'text-[9px]'],
        'md' => ['box' => 'h-9 w-9 text-base', 'name' => 'text-base', 'tag' => 'text-[10px]'],
        'lg' => ['box' => 'h-11 w-11 text-lg', 'name' => 'text-xl', 'tag' => 'text-[10px]'],
    ];
    $s = $sizes[$size] ?? $sizes['md'];

    $nameTone = $tone === 'dark' ? 'text-white' : 'text-slate-900';
    $tagTone = $tone === 'dark' ? 'text-primary-200' : 'text-primary-700';
@endphp

<a href="{{ $href }}"
   {{ $attributes->merge(['class' => 'group inline-flex items-center gap-2.5 rounded-button focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary focus-visible:ring-offset-2']) }}>
    <span class="flex {{ $s['box'] }} shrink-0 items-center justify-center rounded-badge bg-primary text-white shadow-xs transition-colors group-hover:bg-primary-800"
          aria-hidden="true">
        <x-icon name="scale" :size="$size === 'lg' ? 24 : ($size === 'sm' ? 16 : 20)" :stroke-width="2.25" />
    </span>
    <span class="flex flex-col leading-none">
        <span class="font-bold tracking-tight {{ $s['name'] }} {{ $nameTone }} transition-colors group-hover:text-primary-700">SIMPEK</span>
        <span class="mt-1 font-semibold uppercase tracking-wider {{ $s['tag'] }} {{ $tagTone }}">Hak Ketenagakerjaan</span>
    </span>
</a>
