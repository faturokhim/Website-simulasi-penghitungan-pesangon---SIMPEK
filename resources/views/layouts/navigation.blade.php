<nav class="sticky top-0 z-50 backdrop-blur-md bg-white/95 border-b border-slate-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5 group rounded-xl focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-600 focus-visible:ring-offset-2">
                    <div class="w-9 h-9 rounded-xl bg-teal-700 text-white flex items-center justify-center font-bold text-lg shadow-sm group-hover:bg-teal-800 transition-colors" aria-hidden="true">
                        S
                    </div>
                    <div class="flex flex-col">
                        <span class="text-lg font-extrabold tracking-tight text-slate-900 leading-none group-hover:text-teal-800 transition-colors">SIMPEK</span>
                        <span class="text-[11px] font-semibold text-teal-800 tracking-wide uppercase">Hak Ketenagakerjaan</span>
                    </div>
                </a>

                <div class="hidden md:flex md:items-center md:ms-8 space-x-1">
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}"
                           class="px-3.5 py-2 text-sm font-semibold rounded-xl transition-all focus-visible:ring-2 focus-visible:ring-teal-600 {{ request()->routeIs('admin.dashboard') ? 'bg-teal-700 text-white shadow-sm' : 'text-slate-700 hover:text-teal-900 hover:bg-teal-50' }}">
                            Dashboard
                        </a>
                        <a href="{{ route('admin.calculator') }}"
                           class="px-3.5 py-2 text-sm font-semibold rounded-xl transition-all focus-visible:ring-2 focus-visible:ring-teal-600 {{ request()->routeIs('admin.calculator') || request()->routeIs('admin.calculations.*') ? 'bg-teal-700 text-white shadow-sm' : 'text-slate-700 hover:text-teal-900 hover:bg-teal-50' }}">
                            Hitung Baru
                        </a>
                        <a href="{{ route('admin.verifications.index') }}"
                           class="px-3.5 py-2 text-sm font-semibold rounded-xl transition-all focus-visible:ring-2 focus-visible:ring-teal-600 {{ request()->routeIs('admin.verifications.*') ? 'bg-teal-700 text-white shadow-sm' : 'text-slate-700 hover:text-teal-900 hover:bg-teal-50' }}">
                            Verifikasi
                        </a>
                        <a href="{{ route('admin.reasons.index') }}"
                           class="px-3.5 py-2 text-sm font-semibold rounded-xl transition-all focus-visible:ring-2 focus-visible:ring-teal-600 {{ request()->routeIs('admin.reasons.*') ? 'bg-teal-700 text-white shadow-sm' : 'text-slate-700 hover:text-teal-900 hover:bg-teal-50' }}">
                            Alasan PHK
                        </a>
                        <a href="{{ route('admin.rules.index') }}"
                           class="px-3.5 py-2 text-sm font-semibold rounded-xl transition-all focus-visible:ring-2 focus-visible:ring-teal-600 {{ request()->routeIs('admin.rules.*') ? 'bg-teal-700 text-white shadow-sm' : 'text-slate-700 hover:text-teal-900 hover:bg-teal-50' }}">
                            Aturan
                        </a>
                        <a href="{{ route('admin.regulations.index') }}"
                           class="px-3.5 py-2 text-sm font-semibold rounded-xl transition-all focus-visible:ring-2 focus-visible:ring-teal-600 {{ request()->routeIs('admin.regulations.*') ? 'bg-teal-700 text-white shadow-sm' : 'text-slate-700 hover:text-teal-900 hover:bg-teal-50' }}">
                            Regulasi
                        </a>
                        <a href="{{ route('admin.users.index') }}"
                           class="px-3.5 py-2 text-sm font-semibold rounded-xl transition-all focus-visible:ring-2 focus-visible:ring-teal-600 {{ request()->routeIs('admin.users.*') ? 'bg-teal-700 text-white shadow-sm' : 'text-slate-700 hover:text-teal-900 hover:bg-teal-50' }}">
                            Pengguna
                        </a>
                    @else
                        <a href="{{ route('user.dashboard') }}"
                           class="px-3.5 py-2 text-sm font-semibold rounded-xl transition-all focus-visible:ring-2 focus-visible:ring-teal-600 {{ request()->routeIs('user.dashboard') ? 'bg-teal-700 text-white shadow-sm' : 'text-slate-700 hover:text-teal-900 hover:bg-teal-50' }}">
                            Dashboard
                        </a>
                        <a href="{{ route('user.calculator') }}"
                           class="px-3.5 py-2 text-sm font-semibold rounded-xl transition-all focus-visible:ring-2 focus-visible:ring-teal-600 {{ request()->routeIs('user.calculator') ? 'bg-teal-700 text-white shadow-sm' : 'text-slate-700 hover:text-teal-900 hover:bg-teal-50' }}">
                            Hitung Pesangon
                        </a>
                        <a href="{{ route('user.history') }}"
                           class="px-3.5 py-2 text-sm font-semibold rounded-xl transition-all focus-visible:ring-2 focus-visible:ring-teal-600 {{ request()->routeIs('user.history') ? 'bg-teal-700 text-white shadow-sm' : 'text-slate-700 hover:text-teal-900 hover:bg-teal-50' }}">
                            Riwayat
                        </a>
                        <a href="{{ route('user.regulations') }}"
                           class="px-3.5 py-2 text-sm font-semibold rounded-xl transition-all focus-visible:ring-2 focus-visible:ring-teal-600 {{ request()->routeIs('user.regulations') ? 'bg-teal-700 text-white shadow-sm' : 'text-slate-700 hover:text-teal-900 hover:bg-teal-50' }}">
                            Regulasi
                        </a>
                    @endif
                </div>
            </div>

            <div class="flex items-center gap-2 sm:gap-3">
                <div class="hidden sm:flex items-center gap-2">
                    <div class="text-right">
                        <div class="text-sm font-bold text-slate-900">{{ Auth::user()->name }}</div>
                        <div class="text-xs text-slate-600">{{ Auth::user()->email }}</div>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold {{ Auth::user()->isAdmin() ? 'bg-teal-700 text-white' : 'bg-slate-800 text-white' }}">
                        {{ Auth::user()->isAdmin() ? 'Admin' : 'Pekerja' }}
                    </span>
                </div>

                <form method="POST" action="{{ route('logout') }}" class="hidden sm:inline">
                    @csrf
                    <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-bold text-teal-900 bg-teal-50 hover:bg-teal-100 border border-teal-300 rounded-xl transition focus-visible:ring-2 focus-visible:ring-teal-600">
                        Keluar
                    </button>
                </form>

                <button type="button" id="mobileMenuBtn" class="md:hidden inline-flex items-center justify-center w-10 h-10 rounded-xl border border-slate-300 text-slate-800 hover:bg-slate-100 focus-visible:ring-2 focus-visible:ring-teal-600" aria-expanded="false" aria-controls="mobileMenu" aria-label="Buka menu navigasi">
                    <svg id="mobileMenuIconOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <svg id="mobileMenuIconClose" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>
    </div>

    <div id="mobileMenu" class="md:hidden hidden border-t border-slate-200 bg-white">
        <div class="px-4 py-3 space-y-1 text-sm font-semibold">
            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2.5 rounded-xl {{ request()->routeIs('admin.dashboard') ? 'bg-teal-700 text-white' : 'text-slate-800 hover:bg-teal-50' }}">Dashboard</a>
                <a href="{{ route('admin.calculator') }}" class="block px-3 py-2.5 rounded-xl {{ request()->routeIs('admin.calculator') ? 'bg-teal-700 text-white' : 'text-slate-800 hover:bg-teal-50' }}">Hitung Baru</a>
                <a href="{{ route('admin.verifications.index') }}" class="block px-3 py-2.5 rounded-xl {{ request()->routeIs('admin.verifications.*') ? 'bg-teal-700 text-white' : 'text-slate-800 hover:bg-teal-50' }}">Verifikasi</a>
                <a href="{{ route('admin.reasons.index') }}" class="block px-3 py-2.5 rounded-xl text-slate-800 hover:bg-teal-50">Alasan PHK</a>
                <a href="{{ route('admin.rules.index') }}" class="block px-3 py-2.5 rounded-xl text-slate-800 hover:bg-teal-50">Aturan</a>
                <a href="{{ route('admin.regulations.index') }}" class="block px-3 py-2.5 rounded-xl text-slate-800 hover:bg-teal-50">Regulasi</a>
                <a href="{{ route('admin.users.index') }}" class="block px-3 py-2.5 rounded-xl text-slate-800 hover:bg-teal-50">Pengguna</a>
            @else
                <a href="{{ route('user.dashboard') }}" class="block px-3 py-2.5 rounded-xl {{ request()->routeIs('user.dashboard') ? 'bg-teal-700 text-white' : 'text-slate-800 hover:bg-teal-50' }}">Dashboard</a>
                <a href="{{ route('user.calculator') }}" class="block px-3 py-2.5 rounded-xl {{ request()->routeIs('user.calculator') ? 'bg-teal-700 text-white' : 'text-slate-800 hover:bg-teal-50' }}">Hitung Pesangon</a>
                <a href="{{ route('user.history') }}" class="block px-3 py-2.5 rounded-xl {{ request()->routeIs('user.history') ? 'bg-teal-700 text-white' : 'text-slate-800 hover:bg-teal-50' }}">Riwayat</a>
                <a href="{{ route('user.regulations') }}" class="block px-3 py-2.5 rounded-xl {{ request()->routeIs('user.regulations') ? 'bg-teal-700 text-white' : 'text-slate-800 hover:bg-teal-50' }}">Regulasi</a>
            @endif
            <div class="pt-2 mt-2 border-t border-slate-200 flex items-center justify-between gap-2">
                <div class="min-w-0">
                    <div class="text-sm font-bold text-slate-900 truncate">{{ Auth::user()->name }}</div>
                    <div class="text-xs text-slate-600 truncate">{{ Auth::user()->email }}</div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="px-4 py-2 text-sm font-bold text-teal-900 bg-teal-50 border border-teal-300 rounded-xl">Keluar</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        (function () {
            var btn = document.getElementById('mobileMenuBtn');
            var menu = document.getElementById('mobileMenu');
            var iconOpen = document.getElementById('mobileMenuIconOpen');
            var iconClose = document.getElementById('mobileMenuIconClose');
            if (!btn || !menu) return;
            btn.addEventListener('click', function () {
                var isHidden = menu.classList.toggle('hidden');
                var expanded = String(!isHidden);
                btn.setAttribute('aria-expanded', expanded);
                btn.setAttribute('aria-label', isHidden ? 'Buka menu navigasi' : 'Tutup menu navigasi');
                if (iconOpen) iconOpen.classList.toggle('hidden', !isHidden);
                if (iconClose) iconClose.classList.toggle('hidden', isHidden);
            });
        })();
    </script>
</nav>
