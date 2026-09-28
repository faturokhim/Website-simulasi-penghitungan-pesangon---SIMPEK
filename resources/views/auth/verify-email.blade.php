<x-guest-layout>
    <div class="mb-6 text-center space-y-1">
        <h2 class="text-xl font-bold text-slate-900">Verifikasi Alamat Email</h2>
        <p class="text-xs text-slate-500">Sebelum mulai, mohon konfirmasi alamat email Anda dengan mengklik tautan yang baru saja kami kirimkan.</p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <x-alert type="success" class="mb-4">
            Tautan verifikasi baru telah dikirim ke alamat email yang Anda daftarkan.
        </x-alert>
    @endif

    <div class="space-y-3">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <x-button type="submit" variant="primary" size="lg" class="w-full" icon="send">
                Kirim Ulang Email Verifikasi
            </x-button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-button type="submit" variant="ghost" size="lg" class="w-full" icon="log-out">
                Keluar dari Akun
            </x-button>
        </form>
    </div>
</x-guest-layout>
