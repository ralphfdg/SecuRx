<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SecuRx - @yield('title', 'Secure Digital Prescriptions')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-slate-50 text-gray-800 min-h-screen flex flex-col relative overflow-x-hidden selection:bg-securx-cyan selection:text-white">

    <div class="absolute top-[-10%] left-[-5%] w-96 h-96 bg-securx-cyan/20 rounded-full blur-[100px] pointer-events-none z-0"></div>
    <div class="absolute bottom-[10%] right-[-5%] w-[500px] h-[500px] bg-securx-gold/15 rounded-full blur-[120px] pointer-events-none z-0"></div>

    <header class="relative z-10 w-full border-b border-gray-200/50 bg-white/40 backdrop-blur-md">
        <nav class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            
            <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                <img src="{{ asset('images/logo-1.png') }}" alt="SecuRx Logo" class="h-10 w-auto object-contain transition-transform duration-300 group-hover:scale-105">    
            </a>

            <div class="hidden lg:flex gap-8 items-center text-sm font-semibold text-gray-600">
                <a href="{{ route('about') }}" class="hover:text-securx-cyan transition">About</a>
                <a href="{{ route('doctors.home') }}" class="hover:text-securx-cyan transition">For Doctor</a>
                <a href="{{ route('pharmacies.home') }}" class="hover:text-securx-cyan transition">For Pharmacy</a>
                <a href="{{ route('contact') }}" class="hover:text-securx-cyan transition">Contact Us</a>
            </div>

            <div class="hidden lg:flex gap-6 items-center">
                <a href="{{ route('login') }}" class="text-sm font-bold text-securx-navy hover:text-securx-cyan transition">
                    Login
                </a>
                <a href="{{ route('register') }}" class="glass-btn-primary text-sm px-6 py-2.5">
                    Register
                </a>
            </div>

        </nav>
    </header>

    <main class="relative z-10 flex-grow w-full">
        @yield('content')
    </main>

    <footer class="relative z-10 border-t border-gray-200 bg-white/50 backdrop-blur-md mt-20">
        <div class="max-w-7xl mx-auto px-6 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-lg font-bold text-securx-navy mb-4">SecuRx Network</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">A decentralized prescribing platform bridging telehealth and local pharmacies securely.</p>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider mb-4">Platform</h3>
                    <ul class="space-y-2 text-sm text-gray-500">
                        <li><a href="#" class="hover:text-securx-cyan transition">For Doctors</a></li>
                        <li><a href="#" class="hover:text-securx-cyan transition">For Pharmacies</a></li>
                        <li><a href="#" class="hover:text-securx-cyan transition">For Patients</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider mb-4">Support</h3>
                    <ul class="space-y-2 text-sm text-gray-500">
                        <li><a href="{{ route('help') }}" class="hover:text-securx-cyan transition">Help Center</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-securx-cyan transition">Contact Us</a></li>
                        <li><a href="#" class="hover:text-securx-cyan transition">API Documentation</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider mb-4">Legal</h3>
                    <ul class="space-y-2 text-sm text-gray-500">
                        <li><a href="{{ route('privacy') }}" class="hover:text-securx-cyan transition">Privacy Policy</a></li>
                        <li><a href="{{ route('terms') }}" class="hover:text-securx-cyan transition">Terms of Service</a></li>
                        <li><a href="{{ route('accessibility') }}" class="hover:text-securx-cyan transition">Accessibility</a></li>
                    </ul>
                </div>
            </div>
            <div class="mt-12 pt-8 border-t border-gray-200 text-center text-sm text-gray-400">
                &copy; {{ date('Y') }} SecuRx Angeles University Foundation Capstone. All rights reserved.
            </div>
        </div>
    </footer>

</body>
</html>