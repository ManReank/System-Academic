@extends('layouts.app')

@section('title', 'Manajemen User')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="p-4 border-b flex flex-wrap gap-3 items-center justify-between">
        <form method="GET" class="flex gap-2 flex-wrap">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari nama / username / email..."
                   class="border rounded px-3 py-2 text-sm w-64">
            <select name="role" class="border rounded px-3 py-2 text-sm">
                <option value="">Semua Role</option>
                @foreach(['admin', 'guru', 'siswa'] as $r)
                    <option value="{{ $r }}" @selected(request('role') === $r)>{{ ucfirst($r) }}</option>
                @endforeach
            </select>
            <button class="bg-slate-700 text-white px-4 py-2 text-sm rounded">Filter</button>
        </form>
        <a href="{{ route('admin.users.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 text-sm rounded">
            + Tambah User
        </a>
    </div>

    <table class="w-full text-sm">
        <thead class="bg-gray-100 text-gray-700">
            <tr>
                <th class="text-left px-4 py-2">Nama</th>
                <th class="text-left px-4 py-2">Username</th>
                <th class="text-left px-4 py-2">Email</th>
                <th class="text-left px-4 py-2">Role</th>
                <th class="text-right px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $user->name }}</td>
                    <td class="px-4 py-2">{{ $user->username }}</td>
                    <td class="px-4 py-2">{{ $user->email }}</td>
                    <td class="px-4 py-2">
                        <span class="px-2 py-1 text-xs rounded
                            {{ $user->role === 'admin' ? 'bg-red-100 text-red-700' : '' }}
                            {{ $user->role === 'guru' ? 'bg-blue-100 text-blue-700' : '' }}
                            {{ $user->role === 'siswa' ? 'bg-green-100 text-green-700' : '' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td class="px-4 py-2 text-right">
                        <a href="{{ route('admin.users.edit', $user) }}"
                           class="text-blue-600 hover:underline mr-3">Edit</a>
                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                              class="inline" onsubmit="return confirm('Hapus user ini?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-gray-500 py-6">Belum ada data.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="p-4 border-t">
        {{ $users->links() }}
    </div>
</div>
@endsection
