<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('page_title', 'Secretary Portal') - SecuRx</title>
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

        <div class="p-6 border-b border-gray-200/50 flex justify-center">
            <a href="{{ url('/') }}" class="flex items-center gap-2 group">
                <img src="{{ asset('images/logo-1.png') }}" alt="SecuRx Logo"
                    class="h-10 w-auto object-contain transition-transform duration-300 group-hover:scale-105">
            </a>
        </div>

        <nav class="flex-1 p-4 space-y-2 overflow-y-auto hide-scrollbar">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 px-3">Operations</p>

            <a href="{{ route('secretary.dashboard') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-semibold transition {{ request()->routeIs('secretary.dashboard') ? 'bg-securx-cyan/10 text-securx-navy font-bold' : 'text-gray-500 hover:bg-white/60 hover:text-securx-navy' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('secretary.dashboard') ? 'text-securx-cyan' : '' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                    </path>
                </svg>
                Dashboard
            </a>

            <a href="{{ route('secretary.calendar') }}"
                class="flex items-center justify-between px-3 py-2.5 rounded-lg font-semibold transition {{ request()->routeIs('secretary.calendar') ? 'bg-securx-cyan/10 text-securx-navy font-bold' : 'text-gray-500 hover:bg-white/60 hover:text-securx-navy' }}">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 {{ request()->routeIs('secretary.calendar') ? 'text-securx-cyan' : '' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    Master Calendar
                </div>
                <span class="bg-orange-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">2</span>
            </a>

            <a href="{{ route('secretary.triage') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-semibold transition text-gray-500 hover:bg-white/60 hover:text-securx-navy">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                    </path>
                </svg>
                Triage & Queue
            </a>

            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 px-3 pt-4">Records</p>

            <a href="{{ route('secretary.patients') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-semibold transition text-gray-500 hover:bg-white/60 hover:text-securx-navy">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                    </path>
                </svg>
                Patient Directory
            </a>
        </nav>

        <div class="p-4 border-t border-gray-200/50">
            @php $user = auth()->user(); @endphp
            <a href="#"
                class="flex items-center gap-3 p-2 -mx-2 rounded-lg transition-all duration-200 group cursor-pointer hover:bg-white/60">

                <div
                    class="w-10 h-10 rounded-full bg-securx-navy flex items-center justify-center text-white font-bold shadow-sm group-hover:bg-securx-cyan transition-colors duration-300">
                    {{ strtoupper(substr($user->first_name ?? 'C', 0, 1) . substr($user->last_name ?? 'B', 0, 1)) }}
                </div>

                <div>
                    <p
                        class="text-sm font-bold text-securx-navy group-hover:text-securx-cyan transition-colors duration-300">
                        {{ $user->first_name ?? 'Clara' }} {{ substr($user->last_name ?? 'Bautista', 0, 1) }}.
                    </p>
                    <p class="text-xs text-gray-500">Front Desk Account</p>
                </div>
            </a>

            <form method="POST" action="{{ route('logout') }}" class="mt-3">
                @csrf
                <button type="submit"
                    class="w-full text-xs text-red-500 hover:text-red-700 font-bold transition text-left px-2">Log
                    Out</button>
            </form>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-screen overflow-hidden z-10 relative">

        <header
            class="h-16 flex items-center justify-between px-6 bg-white/40 backdrop-blur-md border border-gray-200/50 m-4 rounded-xl glass-panel hidden md:flex shadow-sm">
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

        <div class="flex-1 overflow-y-auto p-4 md:p-6 pb-24 hide-scrollbar">
            @yield('content')
        </div>
    </main>

    <style>
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
    @stack('scripts')
</body>

</html>
