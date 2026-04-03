<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - SecuRx</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="antialiased bg-slate-50 text-gray-800 min-h-screen flex items-center justify-center relative selection:bg-securx-cyan selection:text-white overflow-hidden">

    <div class="absolute top-[5%] left-[10%] w-96 h-96 bg-securx-cyan/20 rounded-full blur-[100px] pointer-events-none">
    </div>
    <div
        class="absolute bottom-[5%] right-[10%] w-[400px] h-[400px] bg-securx-gold/15 rounded-full blur-[120px] pointer-events-none">
    </div>

    <div class="absolute top-6 right-6 md:top-8 md:right-8 z-20">
        <a href="{{ route('home') }}"
            class="px-4 py-2 bg-white/60 border border-gray-200 rounded-md text-sm font-semibold text-gray-500 hover:text-securx-navy hover:border-securx-cyan/30 hover:bg-white backdrop-blur-sm transition-all flex items-center gap-2 shadow-sm">
            &larr; Back to Home
        </a>
    </div>

    <div class="glass-panel p-8 md:p-10 z-10 mx-4 w-full max-w-md">

        <div class="flex flex-col items-center mb-10">
            <div class="flex items-center gap-1 text-3xl font-extrabold tracking-tight mb-2">
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    <img src="{{ asset('images/logo-1.png') }}" alt="SecuRx Logo"
                        class="h-14 w-auto object-contain transition-transform duration-300 group-hover:scale-105">
                </a>
            </div>
            <div class="w-16 h-1 bg-gradient-to-r from-securx-cyan to-securx-navy rounded-full mb-3"></div>
            <p class="text-gray-500 font-medium text-sm">Sign in to your account</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <div>
                <label for="login_id" class="block text-sm font-bold text-securx-navy mb-1.5">Email Address or
                    Username</label>
                <input type="text" id="login_id" name="login_id" placeholder="Enter your email or username"
                    class="glass-input w-full py-2.5 px-4" required autofocus>
            </div>

            <div>
                <label for="password" class="block text-sm font-bold text-securx-navy mb-1.5">Password</label>
                <div class="relative">
                    <input type="password" id="password" name="password" placeholder="••••••••"
                        class="glass-input w-full py-2.5 pl-4 pr-12" required>

                    <button type="button" onclick="togglePassword()"
                        class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-securx-cyan transition-colors"
                        title="Toggle Password Visibility">
                        <svg id="eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center text-gray-500 hover:text-securx-navy cursor-pointer transition-colors">
                    <input type="checkbox" name="remember"
                        class="rounded border-gray-300 text-securx-cyan focus:ring-securx-cyan shadow-sm">
                    <span class="ml-2 font-medium">Remember me</span>
                </label>
                <a href="#" class="text-securx-cyan hover:text-securx-navy font-bold transition-colors">Forgot
                    password?</a>
            </div>

            <button type="submit" class="glass-btn-primary w-full mt-2 text-lg">
                LOGIN
            </button>

            <div class="pt-6 mt-6 border-t border-gray-100 text-center space-y-2 text-sm text-gray-500 font-medium">
                <p>Don't have an account? <a href="{{ route('register') }}"
                        class="text-securx-cyan hover:text-securx-navy font-bold transition-colors">Sign up</a></p>
                <p>Need assistance? <a href="{{ route('help') }}"
                        class="hover:text-securx-navy font-semibold transition-colors">Visit Help Center</a></p>
            </div>
        </form>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML =
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>';
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML =
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>';
            }
        }
    </script>
</body>

</html>
