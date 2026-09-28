<x-guest-layout>
    <div class="mb-6 text-center space-y-1">
        <h2 class="text-xl font-bold text-slate-900">Lupa Kata Sandi</h2>
        <p class="text-xs text-slate-500">Masukkan alamat Anda, tautan pengaturan ulang sandi akan dikirimkan</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-600">Alamat Email</label>
            <x-input id="email" name="email" type="email" :value="old('email')" required autofocus placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <div class="pt-2">
            <x-button type="submit" variant="primary" size="lg" class="w-full" icon="mail">
                Kirim Tautan Pengaturan Ulang
            </x-button>
        </div>
    </form>

    <div class="mt-6 border-t border-slate-200 pt-5 text-center">
        <a class="text-xs font-semibold text-primary-700 hover:text-primary-900 hover:underline" href="{{ route('login') }}">
            Kembali ke halaman masuk
        </a>
    </div>
</x-guest-layout>
