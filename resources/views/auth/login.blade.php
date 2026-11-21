<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SMK Kemangkon</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-xl w-full max-w-sm">
        <h1 class="text-2xl font-bold mb-1 text-slate-800">SMK Kemangkon</h1>
        <p class="text-sm text-slate-500 mb-6">Sistem Akademik</p>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="/login" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium mb-1">Username</label>
                <input type="text" name="username" value="{{ old('username') }}"
                       class="w-full border rounded px-3 py-2" required autofocus>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Password</label>
                <input type="password" name="password" class="w-full border rounded px-3 py-2" required>
            </div>
            <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded transition">
                Login
            </button>
        </form>

        <div class="mt-6 text-xs text-gray-500 bg-gray-50 p-3 rounded">
            <p class="font-medium mb-1">Akun Demo:</p>
            <p><code>admin</code> / <code>password</code></p>
            <p><code>budi</code> / <code>password</code></p>
            <p><code>siswa1</code> / <code>password</code></p>
        </div>
    </div>
</body>
</html>
