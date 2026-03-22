@extends('layouts.public')

@section('title', 'Home')

@section('content')
<div class="flex flex-col items-center text-center">
    
    <div class="glass-panel p-12 md:p-20 max-w-5xl w-full flex flex-col items-center mt-4 md:mt-8">
        
        <div class="inline-block py-1.5 px-4 rounded-full bg-securx-cyan/10 border border-securx-cyan/20 text-securx-cyan text-xs font-bold tracking-widest uppercase mb-8">
            Next-Generation Healthcare
        </div>
        
        <h1 class="text-5xl md:text-7xl font-extrabold text-securx-navy mb-6 tracking-tight leading-tight">
            Secure Prescriptions. <br/> <span class="text-securx-cyan">Offline Ready.</span>
        </h1>
        
        <p class="text-lg md:text-xl text-gray-600 max-w-3xl mb-10 leading-relaxed font-medium">
            A decentralized, cryptographic prescribing network bridging the gap between telehealth clinics and independent pharmacies. No central servers required at the point of dispensing.
        </p>
        
        <div class="flex flex-col sm:flex-row gap-5 w-full sm:w-auto">
            <a href="{{ route('login') }}" class="glass-btn-primary text-lg px-10">
                Access System
            </a>
            <a href="{{ route('about') }}" class="glass-btn-secondary text-lg px-10 border-securx-cyan/20">
                View Architecture
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 w-full max-w-6xl mt-16">
        
        <div class="glass-panel p-8 text-left hover:-translate-y-1 transition-transform duration-300">
            <div class="w-12 h-12 rounded-2xl bg-securx-cyan/10 flex items-center justify-center mb-6 text-securx-cyan font-bold text-xl">1</div>
            <h3 class="text-xl font-bold text-securx-navy mb-3">Cryptographic Validation</h3>
            <p class="text-gray-600 text-sm leading-relaxed">Every prescription is locked with a dynamic UUID, mathematically preventing forgery and unauthorized duplication.</p>
        </div>
        
        <div class="glass-panel p-8 text-left hover:-translate-y-1 transition-transform duration-300">
            <div class="w-12 h-12 rounded-2xl bg-securx-gold/15 flex items-center justify-center mb-6 text-securx-gold font-bold text-xl">2</div>
            <h3 class="text-xl font-bold text-securx-navy mb-3">Automated DUR Engine</h3>
            <p class="text-gray-600 text-sm leading-relaxed">Built-in Drug Utilization Review automatically flags early refills to prevent medication hoarding and abuse.</p>
        </div>
        
        <div class="glass-panel p-8 text-left hover:-translate-y-1 transition-transform duration-300">
            <div class="w-12 h-12 rounded-2xl bg-securx-navy/10 flex items-center justify-center mb-6 text-securx-navy font-bold text-xl">3</div>
            <h3 class="text-xl font-bold text-securx-navy mb-3">Universal Verification</h3>
            <p class="text-gray-600 text-sm leading-relaxed">A secure web-based portal allows any partnered independent pharmacy to scan codes without complex hardware.</p>
        </div>

    </div>
</div>
@endsection