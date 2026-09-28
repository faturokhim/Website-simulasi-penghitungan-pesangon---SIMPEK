<x-guest-layout>
    <div class="mb-6 text-center space-y-1">
        <h2 class="text-xl font-bold text-slate-900">Masuk ke SIMPEK</h2>
        <p class="text-xs text-slate-500">Penghitungan hak pesangon sesuai UU No. 6/2023 &amp; PP No. 35/2021</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-600">Alamat Email</label>
            <x-input id="email" name="email" type="email" :value="old('email')" required autofocus autocomplete="username" placeholder="nama@instansi.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div>
            <div class="mb-1.5 flex items-center justify-between">
                <label for="password" class="block text-xs font-semibold uppercase tracking-wide text-slate-600">Kata Sandi</label>
                @if (Route::has('password.request'))
                    <a class="text-xs font-semibold text-primary-700 hover:text-primary-900" href="{{ route('password.request') }}">
                        Lupa sandi?
                    </a>
                @endif
            </div>
            <x-input id="password" name="password" type="password" required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-primary-700 shadow-xs focus:ring-primary-500" name="remember">
                <span class="ms-2 text-xs font-medium text-slate-600">Ingat sesi saya</span>
            </label>
        </div>

        <div class="pt-2">
            <x-button type="submit" variant="primary" size="lg" class="w-full" icon="log-in">
                Masuk ke Aplikasi
            </x-button>
        </div>
    </form>

    <div class="mt-6 space-y-3 border-t border-slate-200 pt-5 text-center">
        <p class="text-xs text-slate-500">Belum memiliki akun?</p>
        <x-button href="{{ route('register') }}" variant="outline" size="md" class="w-full" icon="user-plus">
            Daftar Akun Baru
        </x-button>
    </div>
</x-guest-layout>
