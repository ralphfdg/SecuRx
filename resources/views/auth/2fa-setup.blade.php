<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Setup 2FA - SecuRx</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-slate-50 flex items-center justify-center min-h-screen relative py-12">
    <div class="absolute top-[5%] left-[10%] w-96 h-96 bg-securx-cyan/20 rounded-full blur-[100px] pointer-events-none fixed"></div>
    <div class="absolute bottom-[5%] right-[10%] w-[400px] h-[400px] bg-securx-gold/15 rounded-full blur-[120px] pointer-events-none fixed"></div>

    <div class="glass-panel bg-white/70 backdrop-blur-xl border border-white/60 shadow-2xl rounded-3xl p-10 z-10 w-full max-w-lg mx-4">
        <h2 class="text-2xl font-bold text-securx-navy mb-2">Secure Your Medical Data</h2>
        <p class="text-gray-500 text-sm mb-6">SecuRx requires Two-Factor Authentication (2FA) to protect your sensitive prescriptions.</p>

        <div class="flex flex-col md:flex-row gap-6 items-center bg-white/50 p-6 rounded-2xl border border-gray-100 mb-8">
            <div class="bg-white p-3 rounded-xl shadow-sm border border-gray-200 shrink-0">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=SecuRx-Demo-2FA" alt="2FA QR Code" class="w-32 h-32">
            </div>
            <div>
                <p class="text-sm text-gray-600 font-medium mb-3">Scan this QR code with your authenticator app (Google Authenticator, Authy, etc.)</p>
                <div class="bg-gray-100 p-2 rounded-lg text-center font-mono text-xs text-gray-700 tracking-widest">
                    A3B8 K9P2 X4M1 Q7R5
                </div>
            </div>
        </div>

        <form action="{{ route('patient.dashboard') }}" method="GET">
            <label class="block text-sm font-bold text-securx-navy mb-2">Enter the 6-digit code from your app</label>
            <input type="text" placeholder="• • • • • •" class="w-full text-center tracking-[1em] text-xl py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-securx-cyan mb-6" required>
            
            <button type="submit" class="w-full py-3.5 bg-gradient-to-r from-securx-cyan to-blue-600 text-white rounded-xl font-bold shadow-lg hover:shadow-xl transition-all">
                Verify & Enter Dashboard
            </button>
        </form>
    </div>
</body>
</html>