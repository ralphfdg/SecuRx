<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forgot Password - SecuRx</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-slate-50 text-gray-800 min-h-screen flex items-center justify-center relative selection:bg-securx-cyan selection:text-white">

    <div class="absolute top-[5%] left-[10%] w-96 h-96 bg-securx-cyan/20 rounded-full blur-[100px] pointer-events-none"></div>

    <div class="absolute top-6 right-6 z-20">
        <a href="{{ route('login') }}" class="px-4 py-2 bg-white/60 border border-gray-200 rounded-md text-sm font-semibold text-gray-500 hover:text-securx-navy hover:bg-white transition-all flex items-center gap-2">
            &larr; Back to Login
        </a>
    </div>

    <div class="glass-panel p-8 md:p-10 z-10 mx-4 w-full max-w-md">
        
        <div class="flex flex-col items-center mb-8 text-center">
            <div class="w-14 h-14 bg-securx-gold/10 rounded-full flex items-center justify-center text-securx-gold mb-4 border border-securx-gold/20">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
            </div>
            <h1 class="text-2xl font-extrabold text-securx-navy mb-2">Forgot Password?</h1>
            <p class="text-gray-500 font-medium text-sm">
                No problem. Just let us know your email address and we will securely email you a password reset link.
            </p>
        </div>

        @if (session('status'))
            <div class="mb-6 p-4 bg-securx-cyan/10 border border-securx-cyan/20 text-securx-navy font-bold text-sm rounded-lg text-center">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
            @csrf

            <div>
                <label for="email" class="block text-sm font-bold text-securx-navy mb-1.5">Registered Email Address</label>
                <input type="email" id="email" name="email" class="glass-input w-full py-2.5 px-4" required autofocus>
                @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="glass-btn-primary w-full text-base py-3">
                Email Password Reset Link
            </button>
        </form>
    </div>

</body>
</html>