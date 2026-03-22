<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Provider Portal - SecuRx</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="antialiased bg-slate-50 text-gray-800 min-h-screen flex overflow-hidden selection:bg-securx-cyan selection:text-white relative">

    <div
        class="absolute top-[-10%] left-[-5%] w-[500px] h-[500px] bg-securx-navy/10 rounded-full blur-[120px] pointer-events-none z-0">
    </div>
    <div
        class="absolute bottom-[-10%] right-[-5%] w-[400px] h-[400px] bg-securx-cyan/15 rounded-full blur-[100px] pointer-events-none z-0">
    </div>

    <aside
        class="w-64 glass-panel m-4 flex flex-col z-20 hidden md:flex h-[calc(100vh-2rem)] border-r border-gray-200/50 bg-white/60">

        <div class="p-6 border-b border-gray-200/50 flex justify-center">
            <a href="{{ route('doctors.home') }}" class="relative inline-block group pt-2 pb-1">
                <img src="{{ asset('images/logo-1.png') }}" alt="SecuRx Logo"
                    class="h-10 w-auto object-contain transition-transform duration-300 group-hover:scale-105">
                <span
                    class="absolute -bottom-2 right-0 text-[10px] font-extrabold uppercase tracking-widest text-securx-gold">MD</span>
            </a>
        </div>

        <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
            <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-3 px-3">Main Menu</p>

            <a href="{{ route('doctor.dashboard') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-securx-cyan/10 text-securx-navy font-bold transition">
                <svg class="w-5 h-5 text-securx-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                    </path>
                </svg>
                Dashboard
            </a>

            <a href="{{ route('doctor.prescribe') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-500 hover:bg-slate-100 hover:text-securx-navy font-semibold transition group">
                <svg class="w-5 h-5 text-gray-400 group-hover:text-securx-cyan transition-colors" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Create Prescription
            </a>

            <a href="{{ route('doctor.history') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-500 hover:bg-slate-100 hover:text-securx-navy font-semibold transition group">
                <svg class="w-5 h-5 text-gray-400 group-hover:text-securx-cyan transition-colors" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                    </path>
                </svg>
                Rx History & Revoke
            </a>

            <a href="{{ route('doctor.directory') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-500 hover:bg-slate-100 hover:text-securx-navy font-semibold transition group">
                <svg class="w-5 h-5 text-gray-400 group-hover:text-securx-cyan transition-colors" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                    </path>
                </svg>
                Patient Directory
            </a>

            <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-3 px-3 pt-4">Insights & Account
            </p>

            <a href="{{ route('doctor.analytics') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-500 hover:bg-slate-100 hover:text-securx-navy font-semibold transition group">
                <svg class="w-5 h-5 text-gray-400 group-hover:text-securx-cyan transition-colors" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                </svg>
                Prescribing Analytics
            </a>

            <a href="{{ route('doctor.settings') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-500 hover:bg-slate-100 hover:text-securx-navy font-semibold transition group">
                <svg class="w-5 h-5 text-gray-400 group-hover:text-securx-cyan transition-colors" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                    </path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                Profile & Settings
            </a>
        </nav>

        <div class="p-6 border-t border-gray-200/50 flex flex-col items-center">
            <div class="flex items-center gap-3 w-full mb-4">
                <div
                    class="w-12 h-12 rounded-full bg-securx-navy flex items-center justify-center text-white font-bold text-lg shadow-sm">
                    Dr
                </div>
                <div>
                    <p class="text-sm font-bold text-securx-navy">Dr. Santos</p>
                    <p class="text-xs text-gray-500">Internal Medicine</p>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}" class="w-full text-center">
                @csrf
                <button type="submit" class="text-sm font-bold text-red-500 hover:text-red-700 transition-colors">
                    Log Out
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-screen overflow-hidden z-10 relative">
        <header
            class="h-16 flex items-center justify-between px-6 bg-white/40 backdrop-blur-md border-b border-gray-200/50 m-4 rounded-xl glass-panel hidden md:flex">
            <h2 class="text-lg font-bold text-securx-navy">@yield('page_title', 'Provider Dashboard')</h2>
            <div class="flex items-center gap-4 text-sm font-bold text-gray-500">
                <span>License Valid: <span class="text-green-600">Active</span></span>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-4 md:p-6 pb-24">
            @yield('content')
        </div>
    </main>

</body>

</html>
