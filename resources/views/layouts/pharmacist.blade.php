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
        class="w-64 glass-panel m-4 flex flex-col z-20 hidden md:flex h-[calc(100vh-2rem)] border-r border-gray-200/50 bg-white/60">

        <div class="p-6 border-b border-gray-200/50 flex justify-center">
            <a href="#" class="relative inline-block group pt-2 pb-1">
                <img src="{{ asset('images/logo-1.png') }}" alt="SecuRx Logo"
                    class="h-10 w-auto object-contain transition-transform duration-300 group-hover:scale-105">
                <span
                    class="absolute -bottom-2 right-0 text-[10px] font-extrabold uppercase tracking-widest text-emerald-600">RPh</span>
            </a>
        </div>

        <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
            <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-3 px-3">Dispensary</p>

            <a href="{{ route('pharmacist.dashboard') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-securx-cyan/10 text-securx-navy font-bold transition">
                <svg class="w-5 h-5 text-securx-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                    </path>
                </svg>
                Dashboard
            </a>

            <a href="{{ route('pharmacist.scanner') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-500 hover:bg-slate-100 hover:text-securx-navy font-semibold transition group">
                <svg class="w-5 h-5 text-gray-400 group-hover:text-securx-cyan transition-colors" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z">
                    </path>
                </svg>
                QR Scanner
            </a>

            <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-3 px-3 pt-4">Records & Audit</p>

            <a href="{{ route('pharmacist.logs') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-500 hover:bg-slate-100 hover:text-securx-navy font-semibold transition group">
                <svg class="w-5 h-5 text-gray-400 group-hover:text-securx-cyan transition-colors" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
                Dispensing Logs
            </a>

            <a href="#"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-500 hover:bg-slate-100 hover:text-securx-navy font-semibold transition group">
                <svg class="w-5 h-5 text-gray-400 group-hover:text-securx-cyan transition-colors" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                    </path>
                </svg>
                Override Justifications
            </a>

            <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-3 px-3 pt-4">Account</p>

            <a href="{{ route('pharmacist.settings') }}"
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
                    class="w-12 h-12 rounded-full bg-emerald-600 flex items-center justify-center text-white font-bold text-lg shadow-sm">
                    MR
                </div>
                <div>
                    <p class="text-sm font-bold text-securx-navy">Pharm. Reyes</p>
                    <p class="text-xs text-gray-500">Mercury Drug - Main</p>
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
            <h2 class="text-lg font-bold text-securx-navy">@yield('page_title', 'Pharmacist Dashboard')</h2>
            <div class="flex items-center gap-4 text-sm font-bold text-gray-500">
                <span>Network Status: <span class="text-emerald-600 flex items-center gap-1 inline-flex"><span
                            class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> Secure</span></span>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-4 md:p-6 pb-24">
            @yield('content')
        </div>
    </main>

</body>

</html>
