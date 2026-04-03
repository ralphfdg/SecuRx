<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pending Verification - SecuRx</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="antialiased bg-slate-50 text-gray-800 min-h-screen flex items-center justify-center relative selection:bg-securx-cyan selection:text-white py-12">

    <div
        class="absolute top-[5%] left-[10%] w-96 h-96 bg-securx-cyan/20 rounded-full blur-[100px] pointer-events-none fixed">
    </div>
    <div
        class="absolute bottom-[5%] right-[10%] w-[400px] h-[400px] bg-securx-gold/15 rounded-full blur-[120px] pointer-events-none fixed">
    </div>

    <div
        class="glass-panel bg-white/70 backdrop-blur-xl border border-white/60 shadow-2xl rounded-3xl p-8 md:p-12 z-10 mx-4 w-full max-w-lg relative text-center">

        <div class="flex justify-center mb-6">
            <div
                class="relative w-24 h-24 rounded-full bg-securx-gold/10 flex items-center justify-center border border-securx-gold/30 shadow-[0_0_40px_rgba(212,175,55,0.2)]">
                <svg class="w-12 h-12 text-securx-gold animate-pulse" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                    </path>
                </svg>
                <div class="absolute -bottom-1 -right-1 bg-white rounded-full p-1 shadow-md">
                    <svg class="w-6 h-6 text-securx-navy" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-center gap-2 mb-4">
            <img src="{{ asset('images/logo-1.png') }}" alt="SecuRx Logo" class="h-8 w-auto object-contain">
        </div>
        <h2 class="text-2xl font-extrabold text-securx-navy tracking-tight mb-2">Account Under Review</h2>

        <div class="bg-blue-50/50 border border-blue-100 rounded-xl p-5 mb-8 mt-6 text-left shadow-inner">
            <p class="text-gray-600 text-sm leading-relaxed">
                Thank you for registering with SecuRx. As part of our strict DOH compliance and patient safety
                protocols, all clinical and pharmacy accounts require manual verification.
            </p>
            <p class="text-gray-600 text-sm leading-relaxed mt-3">
                Our system administrators are currently reviewing your submitted <strong>PRC / LTO Credentials</strong>.
                You will be granted full access to the prescribing and dispensing portals within <span
                    class="font-bold text-securx-navy">24 to 48 hours</span>.
            </p>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full py-3.5 bg-gradient-to-r from-securx-navy to-slate-800 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                    </path>
                </svg>
                Sign Out For Now
            </button>
        </form>

        <p class="mt-6 text-xs text-gray-400">
            Need urgent access? Contact <a href="#" class="text-securx-cyan hover:underline">system support</a>.
        </p>

    </div>

</body>

</html>
