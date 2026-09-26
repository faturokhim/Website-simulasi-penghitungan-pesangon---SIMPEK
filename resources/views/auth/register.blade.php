<x-guest-layout>
    <div class="mb-6 text-center space-y-1">
        <h2 class="text-xl font-extrabold text-slate-900">Daftar Akun SIMPEK</h2>
        <p class="text-xs text-slate-500">Akses simulasi mandiri dan riwayat perhitungan hak PHK</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Nama Lengkap</label>
            <input id="name" class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition" 
                   type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Nama Anda" />
            <x-input-error :messages="$errors->get('name')" class="mt-1" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Alamat Email</label>
            <input id="email" class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition" 
                   type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Kata Sandi</label>
            <input id="password" class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition"
                   type="password" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter" />
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Konfirmasi Kata Sandi</label>
            <input id="password_confirmation" class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition"
                   type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi kata sandi" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full inline-flex items-center justify-center py-3 bg-gradient-to-r from-teal-700 to-teal-800 hover:from-teal-800 hover:to-teal-900 text-white font-bold text-sm rounded-xl shadow-md shadow-teal-900/20 transition">
                Daftar Akun Sekarang
            </button>
        </div>

        <div class="mt-4 text-center">
            <a class="text-xs font-semibold text-teal-700 hover:text-teal-900 hover:underline" href="{{ route('login') }}">
                Sudah memiliki akun? Masuk di sini
            </a>
        </div>
    </form>
</x-guest-layout>
