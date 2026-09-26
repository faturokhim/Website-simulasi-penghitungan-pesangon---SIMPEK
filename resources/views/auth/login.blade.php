<x-guest-layout>
    <div class="mb-6 text-center space-y-1">
        <h2 class="text-xl font-extrabold text-slate-900">Masuk ke SIMPEK</h2>
        <p class="text-xs text-slate-500">Penghitungan hak pesangon sesuai UU No. 6/2023 &amp; PP No. 35/2021</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Alamat Email</label>
            <input id="email" class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition" 
                   type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="nama@instansi.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-600">Kata Sandi</label>
                @if (Route::has('password.request'))
                    <a class="text-xs font-semibold text-teal-700 hover:text-teal-900" href="{{ route('password.request') }}">
                        Lupa sandi?
                    </a>
                @endif
            </div>
            <input id="password" class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition"
                   type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-teal-700 shadow-xs focus:ring-teal-500" name="remember">
                <span class="ms-2 text-xs font-medium text-slate-600">Ingat sesi saya</span>
            </label>
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full inline-flex items-center justify-center py-3 bg-gradient-to-r from-teal-700 to-teal-800 hover:from-teal-800 hover:to-teal-900 text-white font-bold text-sm rounded-xl shadow-md shadow-teal-900/20 transition">
                Masuk ke Aplikasi
            </button>
        </div>
    </form>

    <div class="mt-6 pt-5 border-t border-slate-200/80 text-center space-y-3">
        <p class="text-xs text-slate-500">Belum memiliki akun?</p>
        <a href="{{ route('register') }}" class="inline-flex items-center justify-center w-full px-4 py-2.5 border-2 border-teal-600 text-teal-800 font-bold text-xs rounded-xl hover:bg-teal-50/70 transition">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
            Daftar Akun Baru
        </a>
    </div>
</x-guest-layout>
