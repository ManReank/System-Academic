<!DOCTYPE html>
<html>
<head><title>Dashboard Siswa</title></head>
<body>
    <h1>Dashboard Siswa</h1>
    <p>Selamat datang, {{ auth()->user()->name }}!</p>
    <form method="POST" action="/logout">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>
