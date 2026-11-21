@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="max-w-2xl bg-white rounded-lg shadow p-6">
    <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-4">
        @csrf @method('PUT')

        <div>
            <label class="block text-sm font-medium mb-1">Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                   class="w-full border rounded px-3 py-2" required>
            @error('name')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Username</label>
            <input type="text" name="username" value="{{ old('username', $user->username) }}"
                   class="w-full border rounded px-3 py-2" required>
            @error('username')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                   class="w-full border rounded px-3 py-2" required>
            @error('email')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Password Baru <span class="text-gray-500">(kosongkan jika tidak diubah)</span></label>
            <input type="password" name="password" class="w-full border rounded px-3 py-2">
            @error('password')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Role</label>
            <select name="role" class="w-full border rounded px-3 py-2" required>
                @foreach(['admin', 'guru', 'siswa'] as $r)
                    <option value="{{ $r }}" @selected(old('role', $user->role) === $r)>{{ ucfirst($r) }}</option>
                @endforeach
            </select>
            @error('role')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="flex gap-2">
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">Update</button>
            <a href="{{ route('admin.users.index') }}" class="border px-6 py-2 rounded">Batal</a>
        </div>
    </form>
</div>
@endsection
