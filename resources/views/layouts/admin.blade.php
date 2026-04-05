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
                <svg class="w-5 h-5 {{ request()->routeIs('admin.dashboard') ? 'text-securx-cyan' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                Dashboard
            </a>

            <a href="{{ route('admin.users') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-semibold transition {{ request()->routeIs('admin.users') ? 'bg-securx-cyan/10 text-securx-navy font-bold' : 'text-gray-500 hover:bg-white/60 hover:text-securx-navy' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('admin.users') ? 'text-securx-cyan' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                User Management
            </a>

            <a href="{{ route('admin.dataset') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-semibold transition {{ request()->routeIs('admin.dataset') ? 'bg-securx-cyan/10 text-securx-navy font-bold' : 'text-gray-500 hover:bg-white/60 hover:text-securx-navy' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('admin.dataset') ? 'text-securx-cyan' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                Dataset Import
            </a>

            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mt-4 mb-2 px-3">Security & Logs</p>

            <a href="{{ route('admin.logs') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-semibold transition {{ request()->routeIs('admin.logs') ? 'bg-securx-cyan/10 text-securx-navy font-bold' : 'text-gray-500 hover:bg-white/60 hover:text-securx-navy' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('admin.logs') ? 'text-securx-cyan' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Audit Logs
            </a>

            <a href="{{ route('admin.backup') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-semibold transition {{ request()->routeIs('admin.backup') ? 'bg-securx-cyan/10 text-securx-navy font-bold' : 'text-gray-500 hover:bg-white/60 hover:text-securx-navy' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('admin.backup') ? 'text-securx-cyan' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                System Backup
            </a>

            <a href="{{ route('admin.settings') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-semibold transition {{ request()->routeIs('admin.settings') ? 'bg-securx-cyan/10 text-securx-navy font-bold' : 'text-gray-500 hover:bg-white/60 hover:text-securx-navy' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('admin.settings') ? 'text-securx-cyan' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                Global Settings
            </a>
        </nav>

        <div class="p-4 border-t border-gray-200/50">
            @php $user = auth()->user(); @endphp
            
            <a href="{{ route('admin.profile') }}" class="flex items-center gap-3 p-2 -mx-2 rounded-lg transition-all duration-200 group hover:bg-white/60">
                <div class="w-10 h-10 rounded-full bg-securx-gold flex items-center justify-center text-white font-bold shadow-sm group-hover:bg-securx-cyan transition-colors duration-300">
                    {{ strtoupper(substr($user->first_name ?? 'A', 0, 1) . substr($user->last_name ?? 'D', 0, 1)) }}
                </div>
                <div>
                    <p class="text-sm font-bold text-securx-navy group-hover:text-securx-cyan transition-colors duration-300">
                        {{ $user->first_name ?? 'Admin' }}
                    </p>
                    <p class="text-xs text-gray-500">Administrator</p>
                </div>
            </a>
            
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