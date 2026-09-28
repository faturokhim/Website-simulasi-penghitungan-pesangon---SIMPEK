@props([
    'transparent' => false,
])

@php
    $navItems = [
        ['label' => 'Fitur Sistem', 'href' => route('home') . '#fitur', 'icon' => 'layers'],
        ['label' => '23 Alasan PHK', 'href' => route('home') . '#skenario', 'icon' => 'clipboard-list'],
        ['label' => 'Dasar Hukum', 'href' => route('home') . '#regulasi', 'icon' => 'scale'],
    ];
@endphp

<header class="sticky top-0 z-40 border-b border-slate-200 bg-white">
    <div class="page-container">
        <div class="flex h-16 items-center justify-between gap-4">
            <x-brand size="md" />

            <nav class="hidden items-center gap-6 md:flex" aria-label="Navigasi utama">
                @foreach ($navItems as $item)
                    <a href="{{ $item['href'] }}"
                       class="text-sm font-medium text-slate-600 transition-colors hover:text-primary-700 focus-visible:ring-2 focus-visible:ring-primary rounded-badge px-1">
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </nav>

            <div class="flex items-center gap-2">
                @auth
                    @if (auth()->user()->isAdmin())
                        <x-button href="{{ route('admin.dashboard') }}" variant="secondary" size="sm" class="hidden sm:inline-flex">
                            Panel Admin
                        </x-button>
                        <x-button href="{{ route('user.calculator') }}" variant="primary" size="sm" icon="calculator">
                            Hitung Pesangon
                        </x-button>
                    @else
                        <x-button href="{{ route('user.dashboard') }}" variant="secondary" size="sm" class="hidden sm:inline-flex">
                            Dashboard Saya
                        </x-button>
                        <x-button href="{{ route('user.calculator') }}" variant="primary" size="sm" icon="calculator">
                            Hitung Pesangon
                        </x-button>
                    @endif
                @else
                    <x-button href="{{ route('login') }}" variant="ghost" size="sm" class="hidden sm:inline-flex">
                        Masuk
                    </x-button>
                    <x-button href="{{ route('register') }}" variant="primary" size="sm" icon="user-plus" class="hidden sm:inline-flex">
                        Daftar Akun
                    </x-button>
                @endauth

                <button type="button"
                        id="publicMenuBtn"
                        class="inline-flex h-9 w-9 items-center justify-center rounded-button border border-slate-300 text-slate-700 transition hover:bg-slate-50 focus-visible:ring-2 focus-visible:ring-primary md:hidden"
                        aria-expanded="false"
                        aria-controls="publicMenu"
                        aria-label="Buka menu navigasi">
                    <x-icon name="menu" :size="18" />
                </button>
            </div>
        </div>
    </div>

    <div id="publicMenu" class="hidden border-t border-slate-200 bg-white md:hidden">
        <div class="page-container space-y-1 py-3">
            @foreach ($navItems as $item)
                <a href="{{ $item['href'] }}"
                   class="flex items-center gap-2 rounded-input px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50 hover:text-primary-700">
                    <x-icon :name="$item['icon']" :size="16" />
                    {{ $item['label'] }}
                </a>
            @endforeach
            <div class="flex flex-wrap gap-2 border-t border-slate-200 pt-3">
                @auth
                    <x-button href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('user.dashboard') }}" variant="primary" size="sm" class="flex-1">
                        Buka Dashboard
                    </x-button>
                @else
                    <x-button href="{{ route('login') }}" variant="secondary" size="sm" class="flex-1">Masuk</x-button>
                    <x-button href="{{ route('register') }}" variant="primary" size="sm" class="flex-1">Daftar Akun</x-button>
                @endauth
            </div>
        </div>
    </div>
</header>

@push('scripts')
<script>
    (function () {
        var btn = document.getElementById('publicMenuBtn');
        var menu = document.getElementById('publicMenu');
        if (!btn || !menu) return;
        btn.addEventListener('click', function () {
            var hidden = menu.classList.toggle('hidden');
            btn.setAttribute('aria-expanded', String(!hidden));
            btn.setAttribute('aria-label', hidden ? 'Buka menu navigasi' : 'Tutup menu navigasi');
        });
    })();
</script>
@endpush
