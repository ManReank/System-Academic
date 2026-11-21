<!DOCTYPE html>
<html>
<head><title>Dashboard Guru</title></head>
<body>
    <h1>Dashboard Guru</h1>
    <p>Selamat datang, {{ auth()->user()->name }}!</p>
    <form method="POST" action="/logout">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>
