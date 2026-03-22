<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - SecuRx</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-securx-dark text-gray-200 min-h-screen flex items-center justify-center relative selection:bg-securx-cyan selection:text-white">

    <div class="absolute top-[10%] left-[15%] w-96 h-96 bg-securx-cyan/10 rounded-full blur-[120px] pointer-events-none"></div>

    <div class="absolute top-6 right-6 md:top-8 md:right-8">
        <a href="{{ route('home') }}" class="px-4 py-2 bg-white/5 border border-white/10 rounded-md text-sm text-gray-300 hover:text-white hover:bg-white/10 hover:border-white/20 transition flex items-center gap-2 shadow-sm">
            &larr; Back to Home
        </a>
    </div>

    <div class="w-full max-w-md bg-white/5 backdrop-blur-lg border border-white/10 shadow-2xl rounded-xl p-8 md:p-10 z-10 mx-4">
        
        <div class="flex flex-col items-center mb-10">
            <div class="flex items-center gap-1 text-3xl font-extrabold tracking-tight mb-2">
                <span class="text-securx-cyan">Secu</span><span class="text-white">Rx</span>
            </div>
            <div class="w-24 h-1 bg-gradient-to-r from-securx-cyan to-securx-navy rounded-full mb-3"></div>
            <p class="text-gray-400 text-sm">Sign in to your account</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf
            
            <div>
                <label for="login_id" class="block text-sm font-bold text-gray-300 mb-1.5">Email Address or Username</label>
                <input type="text" id="login_id" name="login_id" placeholder="Enter your email or username" 
                       class="w-full bg-black/30 border border-white/10 text-gray-100 placeholder-gray-500 focus:ring-securx-cyan focus:border-securx-cyan rounded-md py-2.5 px-4 shadow-inner transition-all" required autofocus>
            </div>

            <div>
                <label for="password" class="block text-sm font-bold text-gray-300 mb-1.5">Password</label>
                <div class="relative">
                    <input type="password" id="password" name="password" placeholder="••••••••" 
                           class="w-full bg-black/30 border border-white/10 text-gray-100 placeholder-gray-500 focus:ring-securx-cyan focus:border-securx-cyan rounded-md py-2.5 pl-4 pr-12 shadow-inner transition-all" required>
                    
                    <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-securx-cyan transition-colors" title="Toggle Password Visibility">
                        <svg id="eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center text-gray-400 hover:text-gray-300 cursor-pointer transition-colors">
                    <input type="checkbox" name="remember" class="rounded bg-black/30 border-white/20 text-securx-cyan focus:ring-securx-cyan focus:ring-offset-securx-dark">
                    <span class="ml-2 font-medium">Remember me</span>
                </label>
                <a href="#" class="text-securx-cyan hover:text-white font-medium transition-colors">Forgot password?</a>
            </div>

            <button type="submit" class="w-full bg-securx-cyan/90 hover:bg-securx-cyan text-white font-bold py-3 px-4 rounded-lg shadow-[0_0_15px_rgba(28,181,209,0.3)] hover:shadow-[0_0_25px_rgba(28,181,209,0.5)] hover:-translate-y-0.5 transition-all duration-300 mt-2">
                LOGIN
            </button>

            <div class="pt-4 mt-6 border-t border-white/10 text-center space-y-2 text-sm text-gray-400 font-medium">
                <p>Don't have an account? <a href="{{ route('register') }}" class="text-securx-cyan hover:text-white transition-colors">Sign up</a></p>
                <p>Need assistance? <a href="{{ route('help') }}" class="hover:text-white transition-colors">Visit Help Center</a></p>
            </div>
        </form>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                // Switch to Eye-Slash SVG path
                eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>';
            } else {
                passwordInput.type = 'password';
                // Switch back to Normal Eye SVG path
                eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>';
            }
        }
    </script>
</body>
</html>