@php
    $items = simpek_nav_items('admin');
@endphp

<aside class="hidden w-64 shrink-0 border-e border-slate-200 bg-surface lg:block" aria-label="Navigasi admin">
    <div class="sticky top-16 max-h-[calc(100vh-4rem)] overflow-y-auto px-3 py-5">
        <p class="px-3 pb-2 text-xs font-semibold uppercase tracking-wide text-slate-400">Menu Admin</p>

        <nav class="space-y-1">
            @foreach ($items as $item)
                <a href="{{ route($item['route']) }}"
                   class="flex items-center gap-2.5 rounded-input px-3 py-2.5 text-sm font-medium transition-colors focus-visible:ring-2 focus-visible:ring-primary {{ request()->routeIs($item['match']) ? 'bg-primary-700 text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}"
                   @if (request()->routeIs($item['match'])) aria-current="page" @endif>
                    <x-icon :name="$item['icon']" :size="17" />
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>

        <div class="mt-6 rounded-card border border-slate-200 bg-slate-50 p-4">
            <p class="text-xs font-semibold text-slate-700">Dasar Hukum</p>
            <p class="mt-1 text-xs leading-relaxed text-slate-500">
                UU No. 6 Tahun 2023 &amp; PP No. 35 Tahun 2021 tentang Pengupahan dan Pesangon.
            </p>
        </div>
    </div>
</aside>
