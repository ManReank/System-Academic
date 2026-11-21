<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - SMK Kemangkon</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen overflow-hidden">
        <!-- SIDEBAR -->
        <aside class="w-64 bg-slate-900 text-white flex flex-col flex-shrink-0">
            <div class="p-6 border-b border-slate-700">
                <h1 class="text-xl font-bold">SMK Kemangkon</h1>
                <p class="text-xs text-slate-400 mt-1">Sistem Akademik</p>
            </div>

            <nav class="flex-1 p-4 space-y-1 overflow-y-auto text-sm">
                @php
                    $user = auth()->user();
                    $menus = [];
                    if ($user->isAdmin()) {
                        $menus = [
                            ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'pattern' => 'admin.dashboard'],
                            ['label' => 'Manajemen User', 'route' => 'admin.users.index', 'pattern' => 'admin.users.*'],
                        ];
                    } elseif ($user->isGuru()) {
                        $menus = [
                            ['label' => 'Dashboard', 'route' => 'guru.dashboard', 'pattern' => 'guru.dashboard'],
                        ];
                    } elseif ($user->isSiswa()) {
                        $menus = [
                            ['label' => 'Dashboard', 'route' => 'siswa.dashboard', 'pattern' => 'siswa.dashboard'],
                        ];
                    }
                @endphp

                @foreach($menus as $menu)
                    <a href="{{ route($menu['route']) }}"
                       class="block px-4 py-2 rounded transition {{ request()->routeIs($menu['pattern']) ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">
                        {{ $menu['label'] }}
                    </a>
                @endforeach
            </nav>

            <div class="p-4 border-t border-slate-700">
                <p class="font-medium text-sm">{{ $user->name }}</p>
                <p class="text-xs text-slate-400 capitalize">{{ $user->role }}</p>
                <form method="POST" action="{{ route('logout') }}" class="mt-3">
                    @csrf
                    <button class="w-full bg-red-600 hover:bg-red-700 text-white text-sm py-2 rounded transition">
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- MAIN -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-white shadow px-6 py-4">
                <h2 class="text-lg font-semibold text-gray-800">@yield('title', 'Dashboard')</h2>
            </header>

            <main class="flex-1 overflow-y-auto p-6">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
