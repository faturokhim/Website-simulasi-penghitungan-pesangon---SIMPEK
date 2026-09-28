<x-guest-layout>
    <div class="mb-6 text-center space-y-1">
        <h2 class="text-xl font-bold text-slate-900">Atur Ulang Kata Sandi</h2>
        <p class="text-xs text-slate-500">Masukkan kata sandi baru untuk akun Anda</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <label for="email" class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-600">Alamat Email</label>
            <x-input id="email" name="email" type="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-600">Kata Sandi Baru</label>
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
            <x-button type="submit" variant="primary" size="lg" class="w-full" icon="key">
                Simpan Kata Sandi Baru
            </x-button>
        </div>
    </form>
</x-guest-layout>
