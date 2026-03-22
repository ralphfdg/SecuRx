<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Account Pending - SecuRx</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-slate-50 text-gray-800 min-h-screen flex items-center justify-center relative selection:bg-securx-cyan selection:text-white">

    <div class="absolute top-[5%] left-[10%] w-96 h-96 bg-securx-cyan/20 rounded-full blur-[100px] pointer-events-none"></div>
    <div class="absolute bottom-[5%] right-[10%] w-[400px] h-[400px] bg-securx-gold/15 rounded-full blur-[120px] pointer-events-none"></div>

    <div class="glass-panel p-8 md:p-12 z-10 mx-4 w-full max-w-lg text-center border-t-4 border-t-securx-gold">
        
        <div class="mx-auto w-20 h-20 bg-securx-gold/10 rounded-full flex items-center justify-center mb-6 border border-securx-gold/20 shadow-inner">
            <svg class="w-10 h-10 text-securx-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>

        <div class="inline-block py-1 px-3 rounded-full bg-securx-gold/10 text-securx-gold text-xs font-bold tracking-widest uppercase mb-4">
            Under Review
        </div>

        <h1 class="text-2xl font-extrabold text-securx-navy mb-3">Verification in Progress</h1>
        
        <p class="text-gray-600 text-sm leading-relaxed mb-6">
            Your medical credentials have been securely transmitted to the SecuRx administrative team. To ensure the integrity of the network, professional accounts require manual verification before prescribing or dispensing access is granted.
        </p>

        <div class="bg-white/50 border border-gray-200 rounded-lg p-4 mb-8 text-left">
            <h3 class="text-xs font-bold text-securx-navy uppercase tracking-wider mb-2">What happens next?</h3>
            <ul class="text-sm text-gray-600 space-y-2 list-disc pl-4 marker:text-securx-cyan">
                <li>We will cross-reference your provided PRC/LTO numbers with the respective regulatory databases.</li>
                <li>You will receive an email notification once your account is fully activated (typically within 24-48 hours).</li>
            </ul>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="glass-btn-secondary w-full text-base py-3">
                Return to Homepage
            </button>
        </form>
    </div>

</body>
</html>