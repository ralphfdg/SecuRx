<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verify Email - SecuRx</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-slate-50 text-gray-800 min-h-screen flex items-center justify-center relative selection:bg-securx-cyan selection:text-white">

    <div class="absolute top-[5%] left-[10%] w-96 h-96 bg-securx-cyan/20 rounded-full blur-[100px] pointer-events-none"></div>
    <div class="absolute bottom-[5%] right-[10%] w-[400px] h-[400px] bg-securx-gold/15 rounded-full blur-[120px] pointer-events-none"></div>

    <div class="glass-panel p-8 md:p-12 z-10 mx-4 w-full max-w-md text-center">
        
        <div class="mx-auto w-20 h-20 bg-securx-cyan/10 rounded-full flex items-center justify-center mb-6 border border-securx-cyan/20 shadow-inner">
            <svg class="w-10 h-10 text-securx-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
        </div>

        <h1 class="text-2xl font-extrabold text-securx-navy mb-3">Check your inbox</h1>
        
        <p class="text-gray-600 text-sm leading-relaxed mb-8">
            Thanks for signing up for SecuRx! Before getting started, could you verify your email address by clicking on the link we just emailed to you?
        </p>

        <form method="POST" action="{{ route('verification.send') }}" class="mb-4">
            @csrf
            <button type="submit" class="glass-btn-primary w-full text-base py-3">
                Resend Verification Email
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm text-gray-500 hover:text-securx-navy font-semibold underline transition-colors">
                Log Out
            </button>
        </form>
    </div>

</body>
</html>