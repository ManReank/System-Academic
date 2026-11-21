<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - SMK Kemangkon</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-md w-96">
        <h1 class="text-2xl font-bold mb-6 text-center">Login Sistem Akademik</h1>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="/login">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Username</label>
                <input type="text" name="username" value="{{ old('username') }}"
                    class="w-full border rounded px-3 py-2" required autofocus>
            </div>
            <div class="mb-6">
                <label class="block text-sm font-medium mb-1">Password</label>
                <input type="password" name="password"
                    class="w-full border rounded px-3 py-2" required>
            </div>
            <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
                Login
            </button>
        </form>

        <div class="mt-4 text-xs text-gray-500">
            <p><b>Demo akun:</b></p>
            <p>admin / password</p>
            <p>budi / password (guru)</p>
            <p>siswa1 / password (siswa)</p>
        </div>
    </div>
</body>
</html>
