<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>2FA Verification - SecuRx</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-slate-50 text-gray-800 min-h-screen flex items-center justify-center relative selection:bg-securx-cyan selection:text-white">

    <div class="absolute top-[5%] left-[10%] w-96 h-96 bg-securx-cyan/20 rounded-full blur-[100px] pointer-events-none"></div>

    <div class="glass-panel p-8 md:p-10 z-10 mx-4 w-full max-w-md text-center">
        
        <div class="flex flex-col items-center mb-8">
            <div class="w-14 h-14 bg-securx-cyan/10 rounded-full flex items-center justify-center text-securx-cyan mb-4 border border-securx-cyan/20 shadow-sm">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"></path></svg>
            </div>
            <h1 class="text-2xl font-extrabold text-securx-navy mb-2">Two-Factor Authentication</h1>
            <p class="text-gray-500 font-medium text-sm leading-relaxed" id="instruction-text">
                Please confirm access to your account by entering the authentication code provided by your authenticator application.
            </p>
        </div>

        <form method="POST" action="#" class="space-y-6">
            @csrf

            <div id="otp-input-group">
                <label for="code" class="block text-sm font-bold text-securx-navy mb-1.5 text-left">Secure Code</label>
                <input type="text" id="code" name="code" placeholder="000000" class="glass-input w-full py-3 px-4 text-center tracking-[0.5em] text-2xl font-bold" autofocus autocomplete="one-time-code">
            </div>

            <div id="recovery-input-group" class="hidden">
                <label for="recovery_code" class="block text-sm font-bold text-securx-navy mb-1.5 text-left">Recovery Code</label>
                <input type="text" id="recovery_code" name="recovery_code" placeholder="xxxx-xxxx" class="glass-input w-full py-3 px-4 text-center tracking-widest text-lg font-mono">
            </div>

            <button type="submit" class="glass-btn-primary w-full text-base py-3 shadow-[0_4px_14px_0_rgba(28,181,209,0.39)]">
                Authenticate
            </button>
        </form>

        <div class="mt-6 pt-6 border-t border-gray-100">
            <button type="button" onclick="toggleRecovery()" id="toggle-button" class="text-sm text-gray-500 hover:text-securx-cyan font-bold transition-colors">
                Use a recovery code instead
            </button>
        </div>
    </div>

    <script>
        function toggleRecovery() {
            const otpGroup = document.getElementById('otp-input-group');
            const recoveryGroup = document.getElementById('recovery-input-group');
            const instruction = document.getElementById('instruction-text');
            const toggleBtn = document.getElementById('toggle-button');

            if (otpGroup.classList.contains('hidden')) {
                // Switch back to OTP
                otpGroup.classList.remove('hidden');
                recoveryGroup.classList.add('hidden');
                instruction.textContent = "Please confirm access to your account by entering the authentication code provided by your authenticator application.";
                toggleBtn.textContent = "Use a recovery code instead";
            } else {
                // Switch to Recovery Code
                otpGroup.classList.add('hidden');
                recoveryGroup.classList.remove('hidden');
                instruction.textContent = "Please confirm access to your account by entering one of your emergency recovery codes.";
                toggleBtn.textContent = "Use an authenticator app instead";
            }
        }
    </script>
</body>
</html>