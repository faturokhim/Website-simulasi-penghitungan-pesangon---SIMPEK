@extends('layouts.app')

@section('header')
    <div>
        <p class="text-xs font-bold text-teal-800 uppercase tracking-wide">Kelola akses</p>
        <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Data Pengguna</h1>
        <p class="text-sm text-slate-600 mt-0.5">Ubah peran atau nonaktifkan akun bila perlu.</p>
    </div>
@endsection

@section('content')
<div class="table-shell">
    <div class="overflow-x-auto">
        <table class="w-full text-sm min-w-[720px]">
            <thead class="table-head text-xs">
                <tr>
                    <th class="px-6 py-3 text-left">Nama</th>
                    <th class="px-6 py-3 text-left">Email</th>
                    <th class="px-6 py-3 text-center">Peran</th>
                    <th class="px-6 py-3 text-center">Status</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($users as $user)
                <tr class="hover:bg-teal-50/50">
                    <td class="px-6 py-4 font-semibold text-slate-900">{{ $user->name }}</td>
                    <td class="px-6 py-4 text-slate-700">{{ $user->email }}</td>
                    <td class="px-6 py-4 text-center">
                        <span class="badge @if($user->role === 'admin') bg-teal-700 text-white border-teal-700 @else bg-slate-800 text-white border-slate-800 @endif">
                            {{ $user->role === 'admin' ? 'Admin' : 'Pekerja' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="badge @if($user->status === 'active') bg-emerald-100 text-emerald-900 border-emerald-300 @else bg-red-100 text-red-900 border-red-300 @endif">
                            {{ $user->status === 'active' ? 'Aktif' : $user->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="inline-flex flex-wrap items-center justify-center gap-1.5">
                            @csrf @method('PUT')
                            <label class="sr-only" for="role-{{ $user->id }}">Peran {{ $user->name }}</label>
                            <select id="role-{{ $user->id }}" name="role" class="text-xs font-semibold border border-slate-300 rounded-lg px-2 py-1.5 bg-white focus:ring-2 focus:ring-teal-600">
                                <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>Pekerja</option>
                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            <label class="sr-only" for="status-{{ $user->id }}">Status {{ $user->name }}</label>
                            <select id="status-{{ $user->id }}" name="status" class="text-xs font-semibold border border-slate-300 rounded-lg px-2 py-1.5 bg-white focus:ring-2 focus:ring-teal-600">
                                <option value="active" {{ $user->status === 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="inactive" {{ $user->status === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                            <button type="submit" class="px-3 py-1.5 text-xs font-bold text-white bg-teal-700 rounded-lg hover:bg-teal-800">Simpan</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-6 py-10 text-center text-sm text-slate-600">Belum ada data pengguna.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
