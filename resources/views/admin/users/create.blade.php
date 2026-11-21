@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')
<div class="max-w-2xl bg-white rounded-lg shadow p-6">
    <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-4">
        @csrf
        @foreach([
            ['name' => 'name', 'label' => 'Nama Lengkap', 'type' => 'text'],
            ['name' => 'username', 'label' => 'Username', 'type' => 'text'],
            ['name' => 'email', 'label' => 'Email', 'type' => 'email'],
            ['name' => 'password', 'label' => 'Password', 'type' => 'password'],
        ] as $field)
            <div>
                <label class="block text-sm font-medium mb-1">{{ $field['label'] }}</label>
                <input type="{{ $field['type'] }}" name="{{ $field['name'] }}" value="{{ old($field['name']) }}"
                       class="w-full border rounded px-3 py-2" required>
                @error($field['name'])
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        @endforeach

        <div>
            <label class="block text-sm font-medium mb-1">Role</label>
            <select name="role" class="w-full border rounded px-3 py-2" required>
                <option value="">-- Pilih Role --</option>
                @foreach(['admin', 'guru', 'siswa'] as $r)
                    <option value="{{ $r }}" @selected(old('role') === $r)>{{ ucfirst($r) }}</option>
                @endforeach
            </select>
            @error('role')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="flex gap-2">
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">Simpan</button>
            <a href="{{ route('admin.users.index') }}" class="border px-6 py-2 rounded">Batal</a>
        </div>
    </form>
</div>
@endsection
