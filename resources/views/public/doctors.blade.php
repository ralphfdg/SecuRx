@extends('layouts.public')

@section('title', 'For Doctors & Clinics')

@section('content')
<div class="flex flex-col items-center max-w-6xl mx-auto w-full">
    
    <div class="text-center mt-8 mb-16">
        <div class="inline-block py-1.5 px-4 rounded-full bg-securx-navy/10 border border-securx-navy/20 text-securx-navy text-xs font-bold tracking-widest uppercase mb-4">
            Prescribing Authority
        </div>
        <h1 class="text-4xl md:text-6xl font-extrabold text-securx-navy mb-6 tracking-tight leading-tight">
            Protect your license. <br/> <span class="text-securx-cyan">Protect your patients.</span>
        </h1>
        <p class="text-lg md:text-xl text-gray-600 max-w-3xl mx-auto mb-10 leading-relaxed font-medium">
            Generate cryptographically secure prescriptions in seconds. SecuRx physically prevents forgery and utilizes an automated DUR engine to stop patients from early-refill abuse.
        </p>
        
        <div class="flex justify-center gap-4 w-full">
            <a href="{{ route('register', ['role' => 'doctor']) }}" class="glass-btn-primary text-lg px-10">
                Register as a Provider
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 w-full">
        
        <div class="glass-panel p-10 bg-white/80">
            <div class="w-14 h-14 rounded-2xl bg-securx-cyan/10 flex items-center justify-center text-securx-cyan mb-6">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
            </div>
            <h3 class="text-2xl font-bold text-securx-navy mb-3">Zero Forgery Risk</h3>
            <p class="text-gray-600 leading-relaxed">
                Paper pads and static PDFs are easily manipulated. Every SecuRx issuance generates a Secure Digital Prescription. If a prescription is altered, it instantly fails the pharmacist's cryptographic scan.
            </p>
        </div>

        <div class="glass-panel p-10 bg-white/80">
            <div class="w-14 h-14 rounded-2xl bg-securx-gold/15 flex items-center justify-center text-securx-gold mb-6">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </div>
            <h3 class="text-2xl font-bold text-securx-navy mb-3">Instant Revocation</h3>
            <p class="text-gray-600 leading-relaxed">
                Made a dosage error after the patient left your clinic? Access your Provider Dashboard to instantly revoke the UUID. The QR code becomes dead immediately, preventing any pharmacy from dispensing it.
            </p>
        </div>

    </div>

</div>
@endsection