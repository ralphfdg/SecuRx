<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('page_title', 'Admin Command Center') - SecuRx</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/admin.js'])
</head>
<body class="antialiased bg-slate-50 text-gray-800 min-h-screen flex overflow-hidden selection:bg-securx-cyan selection:text-white relative">

    <div class="absolute top-[-10%] left-[-5%] w-96 h-96 bg-securx-cyan/20 rounded-full blur-[100px] pointer-events-none z-0"></div>
    <div class="absolute bottom-[-10%] right-[-5%] w-[500px] h-[500px] bg-securx-gold/15 rounded-full blur-[120px] pointer-events-none z-0"></div>

    <aside class="w-64 glass-panel m-4 flex flex-col z-20 hidden md:flex h-[calc(100vh-2rem)] border-r border-gray-200/50">
        <div class="p-6 border-b border-gray-200/50 flex justify-center">
            <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                <img src="{{ asset('images/logo-1.png') }}" alt="SecuRx Logo" class="h-10 w-auto object-contain transition-transform duration-300 group-hover:scale-105">
            </a>
        </div>

        <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 px-3">System Control</p>

            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-semibold transition {{ request()->routeIs('admin.dashboard') ? 'bg-securx-cyan/10 text-securx-navy font-bold' : 'text-gray-500 hover:bg-white/60 hover:text-securx-navy' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('admin.dashboard') ? 'text-securx-cyan' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                </svg>
                Dashboard
            </a>
            </nav>

        <div class="p-4 border-t border-gray-200/50">
            @php $user = auth()->user(); @endphp
            <div class="flex items-center gap-3 p-2 -mx-2 rounded-lg transition-all duration-200 group">
                <div class="w-10 h-10 rounded-full bg-securx-gold flex items-center justify-center text-white font-bold shadow-sm group-hover:bg-securx-cyan transition-colors duration-300">
                    {{ strtoupper(substr($user->first_name ?? 'A', 0, 1) . substr($user->last_name ?? 'D', 0, 1)) }}
                </div>
                <div>
                    <p class="text-sm font-bold text-securx-navy group-hover:text-securx-cyan transition-colors duration-300">
                        {{ $user->first_name ?? 'Admin' }}
                    </p>
                    <p class="text-xs text-gray-500">Administrator</p>
                </div>
            </div>
            
            <form method="POST" action="{{ route('logout') }}" class="mt-3">
                @csrf
                <button type="submit" class="w-full text-xs text-red-500 hover:text-red-700 font-bold transition text-left pl-2">Log Out</button>
            </form>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-screen overflow-hidden z-10 relative">
        <header class="h-16 flex items-center justify-between px-6 bg-white/40 backdrop-blur-md border-b border-gray-200/50 m-4 rounded-xl glass-panel hidden md:flex">
            <h2 class="text-lg font-bold text-securx-navy">@yield('page_title', 'Admin Dashboard')</h2>
        </header>

        <div class="flex-1 overflow-y-auto p-4 md:p-6 pb-24">
            @yield('content')
        </div>
    </main>
</body>
</html>