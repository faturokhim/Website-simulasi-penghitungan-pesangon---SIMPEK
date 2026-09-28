<x-guest-layout>
    <div class="mb-6 text-center space-y-1">
        <h2 class="text-xl font-bold text-slate-900">Konfirmasi Kata Sandi</h2>
        <p class="text-xs text-slate-500">Ini adalah area aman aplikasi. Mohon konfirmasi kata sandi Anda sebelum melanjutkan.</p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
        @csrf

        <!-- Password -->
        <div>
            <label for="password" class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-600">Kata Sandi</label>
            <x-input id="password" name="password" type="password" required autocomplete="current-password" placeholder="••••••••" autofocus />
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <div class="pt-2">
            <x-button type="submit" variant="primary" size="lg" class="w-full" icon="shield-check">
                Konfirmasi
            </x-button>
        </div>
    </form>
</x-guest-layout>
