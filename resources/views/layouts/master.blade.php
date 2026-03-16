<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SecuRx - Capstone MVP</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased flex h-screen overflow-hidden">

    <aside class="w-64 bg-slate-900 text-white flex flex-col">
        <div class="h-16 flex items-center justify-center border-b border-slate-800 font-bold text-xl tracking-widest">
            Secu<span class="text-blue-500">Rx</span>
        </div>
        
        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
            <a href="#" class="block px-4 py-2 rounded bg-blue-600 text-white font-medium">Dashboard</a>
            <a href="#" class="block px-4 py-2 rounded hover:bg-slate-800 text-gray-300 transition">Scan QR (Phase 2)</a>
            <a href="#" class="block px-4 py-2 rounded hover:bg-slate-800 text-gray-300 transition">Analytics (Phase 2)</a>
        </nav>

        <div class="p-4 border-t border-slate-800">
            <p class="text-sm font-semibold">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</p>
            <p class="text-xs text-slate-400 capitalize">{{ Auth::user()->role }}</p>
            
            <form method="POST" action="{{ route('logout') }}" class="mt-4">
                @csrf
                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white py-2 rounded text-sm transition">
                    Log Out
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 flex flex-col overflow-hidden">
        <header class="h-16 bg-white shadow-sm flex items-center justify-between px-6">
            <h2 class="font-semibold text-gray-800 text-lg">@yield('header', 'Dashboard')</h2>
        </header>

        <div class="flex-1 overflow-y-auto p-6">
            @yield('content')
        </div>
    </main>

</body>
</html>