@props([
    'items' => [],
])

@if (count($items))
    <nav aria-label="Navigasi halaman">
        <ol class="flex flex-wrap items-center gap-1.5 text-xs text-slate-500">
            @foreach ($items as $index => $item)
                <li class="flex items-center gap-1.5">
                    @if ($index > 0)
                        <x-icon name="chevron-right" :size="14" class="text-slate-400" />
                    @endif
                    @if (! empty($item['href']) && $index !== count($items) - 1)
                        <a href="{{ $item['href'] }}" class="font-medium text-slate-500 transition-colors hover:text-primary-700">
                            {{ $item['label'] }}
                        </a>
                    @else
                        <span class="{{ $index === count($items) - 1 ? 'font-semibold text-slate-800' : 'font-medium' }}" @if ($index === count($items) - 1) aria-current="page" @endif>
                            {{ $item['label'] }}
                        </span>
                    @endif
                </li>
            @endforeach
        </ol>
    </nav>
@endif
