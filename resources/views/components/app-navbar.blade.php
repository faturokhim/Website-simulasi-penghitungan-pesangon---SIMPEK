@props([
    'sidebar' => false,
])

@php
    $items = simpek_nav_items();
    $user = Auth::user();
    $isAdmin = $user->isAdmin();
@endphp

<header class="sticky top-0 z-40 border-b border-slate-200 bg-white/95 backdrop-blur-sm">
    <div class="page-container">
        <div class="flex h-16 items-center justify-between gap-4">
            <div class="flex min-w-0 items-center gap-6">
                <x-brand size="md" />

                <nav class="hidden items-center gap-1 md:flex {{ $sidebar ? 'lg:hidden' : '' }}"
                     aria-label="Navigasi utama">
                    @foreach ($items as $item)
                        <a href="{{ route($item['route']) }}"
                           class="inline-flex items-center gap-1.5 rounded-button px-3 py-2 text-sm font-medium transition-colors focus-visible:ring-2 focus-visible:ring-primary {{ request()->routeIs($item['match']) ? 'bg-primary-700 text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}"
                           @if (request()->routeIs($item['match'])) aria-current="page" @endif>
                            <x-icon :name="$item['icon']" :size="16" />
                            <span class="hidden lg:inline">{{ $item['label'] }}</span>
                        </a>
                    @endforeach
                </nav>
            </div>

            <div class="flex items-center gap-2 sm:gap-3">
                <div class="hidden items-center gap-2 sm:flex">
                    <div class="text-right leading-tight">
                        <div class="text-sm font-semibold text-slate-900">{{ $user->name }}</div>
                        <div class="text-xs text-slate-500">{{ $user->email }}</div>
                    </div>
                    <x-badge :variant="$isAdmin ? 'primary' : 'neutral'" class="ml-1">
                        {{ $isAdmin ? 'Admin' : 'Pekerja' }}
                    </x-badge>
                </div>

                <form method="POST" action="{{ route('logout') }}" class="hidden sm:block">
                    @csrf
                    <x-button type="submit" variant="secondary" size="sm" icon="log-out">
                        Keluar
                    </x-button>
                </form>

                <button type="button"
                        id="appMenuBtn"
                        class="inline-flex h-9 w-9 items-center justify-center rounded-button border border-slate-300 text-slate-700 transition hover:bg-slate-50 focus-visible:ring-2 focus-visible:ring-primary md:hidden"
                        aria-expanded="false"
                        aria-controls="appMenu"
                        aria-label="Buka menu navigasi">
                    <x-icon name="menu" :size="18" />
                </button>
            </div>
        </div>
    </div>

    <div id="appMenu" class="hidden border-t border-slate-200 bg-white md:hidden">
        <div class="page-container space-y-1 py-3">
            @foreach ($items as $item)
                <a href="{{ route($item['route']) }}"
                   class="flex items-center gap-2 rounded-input px-3 py-2 text-sm font-medium transition {{ request()->routeIs($item['match']) ? 'bg-primary-700 text-white' : 'text-slate-700 hover:bg-slate-100 hover:text-primary-700' }}">
                    <x-icon :name="$item['icon']" :size="16" />
                    {{ $item['label'] }}
                </a>
            @endforeach

            <div class="border-t border-slate-200 pt-3">
                <div class="mb-2 truncate text-xs text-slate-500">
                    Masuk sebagai <span class="font-semibold text-slate-800">{{ $user->name }}</span>
                    &bull; {{ $user->email }}
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-button type="submit" variant="secondary" size="sm" icon="log-out" class="w-full">
                        Keluar
                    </x-button>
                </form>
            </div>
        </div>
    </div>
</header>

@push('scripts')
<script>
    (function () {
        var btn = document.getElementById('appMenuBtn');
        var menu = document.getElementById('appMenu');
        if (!btn || !menu) return;
        btn.addEventListener('click', function () {
            var hidden = menu.classList.toggle('hidden');
            btn.setAttribute('aria-expanded', String(!hidden));
            btn.setAttribute('aria-label', hidden ? 'Buka menu navigasi' : 'Tutup menu navigasi');
        });
    })();
</script>
@endpush
