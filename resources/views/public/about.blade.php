@extends('layouts.public')

@section('title', 'About the System')

@section('content')
<div class="flex flex-col items-center max-w-6xl mx-auto w-full space-y-20">
    
    <div class="text-center mt-8">
        <div class="inline-block py-1.5 px-4 rounded-full bg-securx-cyan/10 border border-securx-cyan/20 text-securx-cyan text-xs font-bold tracking-widest uppercase mb-4">
            Our Mission
        </div>
        <h1 class="text-4xl md:text-5xl font-extrabold text-securx-navy mb-6 tracking-tight">
            Redefining Prescription Security
        </h1>
        <p class="text-lg text-gray-600 max-w-3xl mx-auto leading-relaxed">
            SecuRx was developed to bridge the critical gap between telehealth providers and physical pharmacies. By decentralizing the verification process, we empower independent pharmacies to securely dispense medication without needing expensive, proprietary hardware integrations.
        </p>
    </div>

    <div class="w-full">
        <h2 class="text-2xl font-bold text-securx-navy mb-8 text-center">How The System Works</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
            
            <div class="hidden md:block absolute top-1/2 left-[15%] right-[15%] h-0.5 bg-gradient-to-r from-securx-cyan/20 via-securx-gold/30 to-securx-navy/20 -z-10 transform -translate-y-1/2"></div>

            <div class="glass-panel p-8 text-center flex flex-col items-center relative bg-white/80">
                <div class="w-16 h-16 rounded-full bg-securx-cyan/10 border-2 border-securx-cyan/30 flex items-center justify-center text-securx-cyan mb-6 shadow-sm">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-securx-navy mb-2">1. Issuance</h3>
                <p class="text-sm text-gray-600">The verified physician generates a prescription. The backend cryptographically signs the data and assigns a unique UUID.</p>
            </div>

            <div class="glass-panel p-8 text-center flex flex-col items-center relative bg-white/80">
                <div class="w-16 h-16 rounded-full bg-securx-gold/10 border-2 border-securx-gold/30 flex items-center justify-center text-securx-gold mb-6 shadow-sm">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-securx-navy mb-2">2. Portability</h3>
                <p class="text-sm text-gray-600">The patient receives a dynamic QR code containing the UUID. This can be saved offline or printed for complete accessibility.</p>
            </div>

            <div class="glass-panel p-8 text-center flex flex-col items-center relative bg-white/80">
                <div class="w-16 h-16 rounded-full bg-securx-navy/10 border-2 border-securx-navy/20 flex items-center justify-center text-securx-navy mb-6 shadow-sm">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-securx-navy mb-2">3. Verification</h3>
                <p class="text-sm text-gray-600">The pharmacist scans the code. Our DUR engine verifies authenticity and tracks refill telemetry in real-time.</p>
            </div>

        </div>
    </div>

    <div class="w-full pb-12">
        <h2 class="text-2xl font-bold text-securx-navy mb-8 text-center">The Development Team</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
            
            <div class="glass-panel p-6 flex flex-col items-center text-center">
                <div class="w-24 h-24 rounded-full bg-gray-200 mb-4 overflow-hidden border-4 border-white shadow-md">
                    <img src="https://ui-avatars.com/api/?name=Ralph+De+Guzman&background=1CB5D1&color=fff" alt="Ralph" class="w-full h-full object-cover">
                </div>
                <h3 class="font-bold text-lg text-securx-navy">Ralph De Guzman</h3>
                <p class="text-securx-cyan text-sm font-semibold mb-3">Lead Developer / BSIT-3</p>
                <p class="text-xs text-gray-500">Angeles University Foundation</p>
            </div>

            <div class="glass-panel p-6 flex flex-col items-center text-center">
                <div class="w-24 h-24 rounded-full bg-gray-200 mb-4 overflow-hidden border-4 border-white shadow-md">
                    <img src="https://ui-avatars.com/api/?name=Developer+Two&background=2C348A&color=fff" alt="Dev 2" class="w-full h-full object-cover">
                </div>
                <h3 class="font-bold text-lg text-securx-navy">[Teammate Name]</h3>
                <p class="text-securx-cyan text-sm font-semibold mb-3">Frontend Engineer / BSIT-3</p>
                <p class="text-xs text-gray-500">Angeles University Foundation</p>
            </div>

            <div class="glass-panel p-6 flex flex-col items-center text-center">
                <div class="w-24 h-24 rounded-full bg-gray-200 mb-4 overflow-hidden border-4 border-white shadow-md">
                    <img src="https://ui-avatars.com/api/?name=Developer+Three&background=D6A850&color=fff" alt="Dev 3" class="w-full h-full object-cover">
                </div>
                <h3 class="font-bold text-lg text-securx-navy">[Teammate Name]</h3>
                <p class="text-securx-cyan text-sm font-semibold mb-3">Systems Analyst / BSIT-3</p>
                <p class="text-xs text-gray-500">Angeles University Foundation</p>
            </div>

        </div>
    </div>

</div>
@endsection