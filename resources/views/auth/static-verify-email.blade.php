<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verify Email - SecuRx</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased bg-slate-50 flex items-center justify-center min-h-screen relative py-12">
    <div
        class="absolute top-[5%] left-[10%] w-96 h-96 bg-securx-cyan/20 rounded-full blur-[100px] pointer-events-none fixed">
    </div>
    <div
        class="absolute bottom-[5%] right-[10%] w-[400px] h-[400px] bg-securx-gold/15 rounded-full blur-[120px] pointer-events-none fixed">
    </div>

    <div
        class="glass-panel bg-white/70 backdrop-blur-xl border border-white/60 shadow-2xl rounded-3xl p-10 z-10 w-full max-w-md text-center mx-4">
        <div class="flex justify-center mb-6">
            <div class="w-20 h-20 bg-blue-50 rounded-full flex items-center justify-center border border-blue-100">
                <svg class="w-10 h-10 text-securx-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                    </path>
                </svg>
            </div>
        </div>

        <h2 class="text-2xl font-bold text-securx-navy mb-3">Verify your email address</h2>
        <p class="text-gray-500 text-sm mb-8 leading-relaxed">
            We've sent a secure verification link to <strong>{{ auth()->user()->email }}</strong>. Please check your
            inbox to verify your identity.
        </p>

        <a href="{{ route('2fa.setup') }}"
            class="block w-full py-3 bg-securx-navy text-white rounded-xl font-bold shadow-md hover:bg-slate-800 transition-colors">
            [Demo] I have verified my email
        </a>

        <button class="mt-4 text-sm text-gray-400 font-medium hover:text-securx-cyan transition-colors">
            Resend Verification Email
        </button>
    </div>
</body>

</html>
