@extends('layouts.public')

@section('title', 'For Pharmacies')

@section('content')
<div class="flex flex-col items-center max-w-6xl mx-auto w-full">
    
    <div class="text-center mt-8 mb-16">
        <div class="inline-block py-1.5 px-4 rounded-full bg-securx-gold/10 border border-securx-gold/20 text-securx-gold text-xs font-bold tracking-widest uppercase mb-4">
            Dispensing Network
        </div>
        <h1 class="text-4xl md:text-6xl font-extrabold text-securx-navy mb-6 tracking-tight leading-tight">
            Enterprise-level security. <br/> <span class="text-securx-cyan">Zero hardware required.</span>
        </h1>
        <p class="text-lg md:text-xl text-gray-600 max-w-3xl mx-auto mb-10 leading-relaxed font-medium">
            Join the decentralized prescribing network. Use any standard web browser or mobile device to scan patient QR codes, verify cryptographic signatures, and automatically log dispensing telemetry.
        </p>
        
        <div class="flex justify-center gap-4 w-full">
            <a href="{{ route('register', ['role' => 'pharmacist']) }}" class="glass-btn-primary text-lg px-10">
                Join the Network
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 w-full">
        
        <div class="glass-panel p-10 bg-white/80">
            <div class="w-14 h-14 rounded-2xl bg-securx-cyan/10 flex items-center justify-center text-securx-cyan mb-6">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
            </div>
            <h3 class="text-2xl font-bold text-securx-navy mb-3">Universal Web Scanner</h3>
            <p class="text-gray-600 leading-relaxed">
                Lore ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
            </p>
        </div>

        <div class="glass-panel p-10 bg-white/80">
            <div class="w-14 h-14 rounded-2xl bg-securx-navy/10 flex items-center justify-center text-securx-navy mb-6">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
            </div>
            <h3 class="text-2xl font-bold text-securx-navy mb-3">Automated DUR Protection</h3>
            <p class="text-gray-600 leading-relaxed">
                Protect your pharmacy from regulatory liability. Our automated Drug Utilization Review engine instantly flags "Refill Too Soon" attempts and checks the patient's centralized history for contraindications.
            </p>
        </div>

    </div>

</div>
@endsection