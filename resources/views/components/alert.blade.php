@props([
    'type' => 'info',
    'title' => null,
    'dismissible' => false,
])

@php
    $map = [
        'success' => ['bg-emerald-50 border-emerald-200 text-emerald-900', 'check-circle', 'text-emerald-600'],
        'error' => ['bg-rose-50 border-rose-200 text-rose-900', 'alert-circle', 'text-rose-600'],
        'danger' => ['bg-rose-50 border-rose-200 text-rose-900', 'alert-circle', 'text-rose-600'],
        'warning' => ['bg-amber-50 border-amber-200 text-amber-900', 'alert-triangle', 'text-amber-600'],
        'info' => ['bg-sky-50 border-sky-200 text-sky-900', 'info', 'text-sky-600'],
    ];
    [$classes, $icon, $iconClass] = $map[$type] ?? $map['info'];
@endphp

<div {{ $attributes->merge(['class' => 'flex items-start gap-3 rounded-card border p-4 ' . $classes]) }}
     @if ($type === 'error' || $type === 'danger') role="alert" @else role="status" @endif>
    <span class="mt-0.5 {{ $iconClass }}">
        <x-icon :name="$icon" :size="18" />
    </span>
    <div class="flex-1 min-w-0 text-sm">
        @if ($title)
            <p class="font-semibold">{{ $title }}</p>
        @endif
        <div class="{{ $title ? 'mt-0.5' : '' }} leading-relaxed">{{ $slot }}</div>
    </div>
    @if ($dismissible)
        <button type="button"
                class="shrink-0 rounded-badge p-1 hover:bg-black/5 focus-visible:ring-2 focus-visible:ring-current"
                aria-label="Tutup notifikasi"
                onclick="this.parentElement.remove()">
            <x-icon name="x" :size="16" />
        </button>
    @endif
</div>
