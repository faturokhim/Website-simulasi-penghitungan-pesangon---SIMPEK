<x-guest-layout>
    <div class="mb-6 text-center space-y-1">
        <h2 class="text-xl font-bold text-slate-900">Daftar Akun SIMPEK</h2>
        <p class="text-xs text-slate-500">Akses simulasi mandiri dan riwayat perhitungan hak PHK</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-600">Nama Lengkap</label>
            <x-input id="name" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Nama Anda" />
            <x-input-error :messages="$errors->get('name')" class="mt-1" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-600">Alamat Email</label>
            <x-input id="email" name="email" type="email" :value="old('email')" required autocomplete="username" placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-600">Kata Sandi</label>
            <x-input id="password" name="password" type="password" required autocomplete="new-password" placeholder="Minimal 8 karakter" />
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-600">Konfirmasi Kata Sandi</label>
            <x-input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" placeholder="Ulangi kata sandi" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <div class="pt-2">
            <x-button type="submit" variant="primary" size="lg" class="w-full" icon="user-plus">
                Daftar Akun Sekarang
            </x-button>
        </div>

        <div class="text-center">
            <a class="text-xs font-semibold text-primary-700 hover:text-primary-900 hover:underline" href="{{ route('login') }}">
                Sudah memiliki akun? Masuk di sini
            </a>
        </div>
    </form>
</x-guest-layout>
