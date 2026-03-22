<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Patient Portal - SecuRx</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="antialiased bg-slate-50 text-gray-800 min-h-screen flex overflow-hidden selection:bg-securx-cyan selection:text-white relative">

    <div
        class="absolute top-[-10%] left-[-5%] w-96 h-96 bg-securx-cyan/20 rounded-full blur-[100px] pointer-events-none z-0">
    </div>
    <div
        class="absolute bottom-[-10%] right-[-5%] w-[500px] h-[500px] bg-securx-gold/15 rounded-full blur-[120px] pointer-events-none z-0">
    </div>

    <aside
        class="w-64 glass-panel m-4 flex flex-col z-20 hidden md:flex h-[calc(100vh-2rem)] border-r border-gray-200/50">

        <div class="p-6 border-b border-gray-200/50 flex items-center gap-2">
            <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                <img src="{{ asset('images/logo-1.png') }}" alt="SecuRx Logo"
                    class="h-12 w-auto object-contain transition-transform duration-300 group-hover:scale-105">
            </a>
        </div>

        <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 px-3">Main Menu</p>

            <a href="{{ route('patient.dashboard') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-securx-cyan/10 text-securx-navy font-bold transition">
                <svg class="w-5 h-5 text-securx-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                    </path>
                </svg>
                Dashboard
            </a>

            <a href="{{ route('patient.qr-live') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-500 hover:bg-white/60 hover:text-securx-navy font-semibold transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
                My Prescriptions
            </a>

            <a href="{{ route('patient.qr-print') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-500 hover:bg-white/60 hover:text-securx-navy font-semibold transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z">
                    </path>
                </svg>
                Live QR Code
            </a>

            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 px-3 pt-4">Settings & Privacy</p>

            <a href="{{ route('patient.profile.medical') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-500 hover:bg-white/60 hover:text-securx-navy font-semibold transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                Medical Profile
            </a>

            <a href="{{ route('patient.consent') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-500 hover:bg-white/60 hover:text-securx-navy font-semibold transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                    </path>
                </svg>
                Data Consent
            </a>
        </nav>

        <div class="p-4 border-t border-gray-200/50">
            <a href="{{ route('patient.settings') }}"
                class="flex items-center gap-3 p-2 -mx-2 rounded-lg hover:bg-slate-100 transition-all duration-200 group cursor-pointer">
                <div
                    class="w-10 h-10 rounded-full bg-securx-navy flex items-center justify-center text-white font-bold shadow-sm group-hover:bg-securx-cyan transition-colors duration-300">
                    JD
                </div>

                <div>
                    <p
                        class="text-sm font-bold text-securx-navy group-hover:text-securx-cyan transition-colors duration-300">
                        John D.</p>
                    <p class="text-xs text-gray-500">Patient Account</p>
                </div>
            </a>
            <form method="POST" action="{{ route('logout') }}" class="mt-3">
                @csrf
                <button type="submit" class="w-full text-xs text-red-500 hover:text-red-700 font-bold transition">Log
                    Out</button>
            </form>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-screen overflow-hidden z-10 relative">

        <header
            class="h-16 flex items-center justify-between px-6 bg-white/40 backdrop-blur-md border-b border-gray-200/50 m-4 rounded-xl glass-panel hidden md:flex">
            <h2 class="text-lg font-bold text-securx-navy">@yield('page_title', 'Dashboard')</h2>

            <div class="flex items-center gap-4">
                <button class="relative p-2 text-gray-400 hover:text-securx-cyan transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                        </path>
                    </svg>
                    <span
                        class="absolute top-1 right-1 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white"></span>
                </button>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-4 md:p-6 pb-24">
            @yield('content')
        </div>
    </main>

</body>

</html>
