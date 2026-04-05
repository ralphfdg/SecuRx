<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dispensary Portal - SecuRx</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="antialiased bg-slate-50 text-gray-800 min-h-screen flex overflow-hidden selection:bg-securx-cyan selection:text-white relative">

    <div
        class="absolute top-[-10%] left-[-5%] w-[500px] h-[500px] bg-securx-navy/10 rounded-full blur-[120px] pointer-events-none z-0">
    </div>
    <div
        class="absolute bottom-[-10%] right-[-5%] w-[400px] h-[400px] bg-emerald-500/10 rounded-full blur-[100px] pointer-events-none z-0">
    </div>

    <aside
        class="w-64 glass-panel m-4 flex flex-col z-20 hidden md:flex h-[calc(100vh-2rem)] border-r border-gray-200/50 bg-white/60 rounded-2xl shadow-sm">

        <div class="p-6 border-b border-gray-200/50 flex justify-center shrink-0">
            <a href="{{ route('home') }}" class="relative inline-block group pt-2 pb-1">
                <img src="{{ asset('images/logo-1.png') }}" alt="SecuRx Logo"
                    class="h-10 w-auto object-contain transition-transform duration-300 group-hover:scale-105">
                <span
                    class="absolute -bottom-2 right-0 text-[10px] font-extrabold uppercase tracking-widest text-emerald-600">RPh</span>
            </a>
        </div>

        <nav class="flex-1 p-4 space-y-1.5 overflow-y-auto custom-scrollbar">
            <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-3 px-3">Dispensary</p>

            <a href="{{ route('pharmacist.dashboard') ?? '#' }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-securx-cyan/10 text-securx-navy font-bold transition shadow-sm">
                <svg class="w-5 h-5 text-securx-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                    </path>
                </svg>
                Dashboard
            </a>

            <a href="{{ route('pharmacist.scanner') ?? '#' }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-gray-500 hover:bg-white hover:text-securx-navy hover:shadow-sm font-semibold transition group">
                <svg class="w-5 h-5 text-gray-400 group-hover:text-securx-cyan transition-colors" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z">
                    </path>
                </svg>
                QR Scanner
            </a>

            <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-3 px-3 pt-5">Records & Audit</p>

            <a href="{{ route('pharmacist.logs') ?? '#' }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-gray-500 hover:bg-white hover:text-securx-navy hover:shadow-sm font-semibold transition group">
                <svg class="w-5 h-5 text-gray-400 group-hover:text-securx-cyan transition-colors" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
                Dispensing Logs
            </a>
        </nav>

        <div class="p-4 border-t border-gray-200/50 flex flex-col gap-2 shrink-0">

            <a href="{{ route('pharmacist.settings') ?? '#' }}"
                class="flex items-center gap-3 w-full p-2.5 rounded-xl hover:bg-white/80 transition group cursor-pointer border border-transparent hover:border-gray-200 hover:shadow-sm">
                <div
                    class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 font-black text-sm shadow-inner group-hover:bg-emerald-600 group-hover:text-white transition-colors shrink-0">
                    JR
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-securx-navy truncate">Pharm. Rizal</p>
                    <p
                        class="text-[10px] font-bold text-gray-400 uppercase tracking-wider group-hover:text-emerald-600 transition-colors">
                        Profile & Settings</p>
                </div>
                <svg class="w-4 h-4 text-gray-300 group-hover:text-emerald-500 transition-transform group-hover:translate-x-1 shrink-0"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>

            <form method="POST" action="{{ route('logout') ?? '#' }}" class="w-full">
                @csrf
                <button type="submit"
                    class="w-full flex items-center justify-center gap-2 py-2 px-4 rounded-xl text-sm font-bold text-red-500 hover:bg-red-50 hover:text-red-700 transition border border-transparent hover:border-red-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                        </path>
                    </svg>
                    Log Out
                </button>
            </form>

        </div>
    </aside>

    <main class="flex-1 flex flex-col h-screen overflow-hidden z-10 relative">

        <header
            class="h-16 flex items-center justify-between px-6 bg-white/60 backdrop-blur-md border-b border-gray-200/50 m-4 rounded-2xl shadow-sm hidden md:flex shrink-0">
            <h2 class="text-lg font-extrabold text-securx-navy">@yield('page_title', 'Pharmacist Dashboard')</h2>
            <div class="flex items-center gap-4 text-sm font-bold text-gray-500">
                <span class="flex items-center gap-2">
                    System Link:
                    <span
                        class="text-emerald-600 flex items-center gap-1.5 inline-flex bg-emerald-50 border border-emerald-100 px-2 py-0.5 rounded-md">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        Secure
                    </span>
                </span>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-4 md:p-6 pb-24 custom-scrollbar">
            @yield('content')
        </div>

    </main>

    @stack('scripts')
</body>

</html>
