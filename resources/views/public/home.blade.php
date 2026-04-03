@extends('layouts.public')

@section('title', 'Home')

@section('content')
<div class="relative w-full overflow-hidden bg-slate-50 min-h-screen">
    
    <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-securx-cyan/20 rounded-full mix-blend-multiply filter blur-3xl opacity-70"></div>
    <div class="absolute top-[20%] right-[-5%] w-72 h-72 bg-securx-navy/10 rounded-full mix-blend-multiply filter blur-3xl opacity-70"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-12 pb-24 lg:pt-20 lg:pb-32 flex flex-col items-center">
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center w-full">
            
            <div class="flex flex-col items-start text-left z-10">
                <div class="inline-flex items-center py-1.5 px-4 rounded-full bg-white/60 backdrop-blur-md border border-white/50 shadow-sm text-securx-cyan text-xs font-bold tracking-widest uppercase mb-6">
                    <span class="w-2 h-2 rounded-full bg-securx-cyan mr-2 animate-pulse"></span>
                    Next-Generation Healthcare
                </div>
                
                <h1 class="text-5xl md:text-6xl lg:text-7xl font-extrabold text-securx-navy mb-6 tracking-tight leading-tight">
                    Secure Prescriptions. <br/> 
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-securx-cyan to-blue-500">Offline Ready.</span>
                </h1>
                
                <p class="text-lg md:text-xl text-slate-600 max-w-2xl mb-10 leading-relaxed font-medium">
                    A decentralized, cryptographic prescribing network bridging the gap between telehealth clinics and independent pharmacies. No central servers required at the point of dispensing.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto">
                    <a href="{{ route('login') }}" class="inline-flex justify-center items-center px-8 py-3.5 text-base font-bold text-white bg-securx-navy rounded-xl hover:bg-slate-800 transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                        Access System
                    </a>
                    <a href="{{ route('about') }}" class="inline-flex justify-center items-center px-8 py-3.5 text-base font-bold text-securx-navy bg-white/50 backdrop-blur-md border border-white/50 rounded-xl hover:bg-white/80 transition-all shadow-sm hover:shadow-md hover:-translate-y-0.5">
                        View Architecture
                    </a>
                </div>
            </div>

            <div class="relative w-full max-w-lg mx-auto lg:max-w-none z-10 mt-8 lg:mt-0">
                <div class="relative rounded-3xl overflow-hidden shadow-2xl border border-white/50 aspect-[4/3] group">
                    <img src="https://images.unsplash.com/photo-1584901066880-7a314044582e?q=80&w=1000&auto=format&fit=crop" alt="Doctor and Pharmacist" class="object-cover w-full h-full transform group-hover:scale-105 transition-transform duration-700 ease-in-out">
                    <div class="absolute inset-0 bg-gradient-to-tr from-securx-navy/10 to-transparent"></div>
                </div>

                <div class="absolute -bottom-6 -left-4 md:-left-12 bg-white/70 backdrop-blur-xl border border-white/60 shadow-xl rounded-2xl p-4 flex items-center gap-4 animate-bounce" style="animation-duration: 3s;">
                    <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center text-green-600 shadow-inner">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-securx-navy">Verified Prescription</p>
                        <p class="text-xs text-slate-500 font-medium">Cryptographically Secured</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8 w-full mt-24 lg:mt-32 z-10">
            
            <div class="bg-white/60 backdrop-blur-lg border border-white/50 shadow-lg rounded-2xl p-8 hover:-translate-y-2 transition-transform duration-300 relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-32 h-32 bg-securx-cyan/10 rounded-full filter blur-3xl group-hover:bg-securx-cyan/20 transition-colors"></div>
                <div class="w-14 h-14 rounded-xl bg-white border border-slate-100 shadow-sm flex items-center justify-center mb-6 text-securx-cyan font-extrabold text-2xl relative z-10">1</div>
                <h3 class="text-xl font-bold text-securx-navy mb-3 relative z-10">Cryptographic Validation</h3>
                <p class="text-slate-600 text-sm leading-relaxed relative z-10">Every prescription is locked with a dynamic UUID, mathematically preventing forgery and unauthorized duplication.</p>
            </div>
            
            <div class="bg-white/60 backdrop-blur-lg border border-white/50 shadow-lg rounded-2xl p-8 hover:-translate-y-2 transition-transform duration-300 relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-32 h-32 bg-securx-gold/10 rounded-full filter blur-3xl group-hover:bg-securx-gold/20 transition-colors"></div>
                <div class="w-14 h-14 rounded-xl bg-white border border-slate-100 shadow-sm flex items-center justify-center mb-6 text-securx-gold font-extrabold text-2xl relative z-10">2</div>
                <h3 class="text-xl font-bold text-securx-navy mb-3 relative z-10">Automated DUR Engine</h3>
                <p class="text-slate-600 text-sm leading-relaxed relative z-10">Built-in Drug Utilization Review automatically flags early refills to prevent medication hoarding and abuse.</p>
            </div>
            
            <div class="bg-white/60 backdrop-blur-lg border border-white/50 shadow-lg rounded-2xl p-8 hover:-translate-y-2 transition-transform duration-300 relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-32 h-32 bg-securx-navy/5 rounded-full filter blur-3xl group-hover:bg-securx-navy/10 transition-colors"></div>
                <div class="w-14 h-14 rounded-xl bg-white border border-slate-100 shadow-sm flex items-center justify-center mb-6 text-securx-navy font-extrabold text-2xl relative z-10">3</div>
                <h3 class="text-xl font-bold text-securx-navy mb-3 relative z-10">Universal Verification</h3>
                <p class="text-slate-600 text-sm leading-relaxed relative z-10">A secure web-based portal allows any partnered independent pharmacy to scan codes without complex hardware.</p>
            </div>

        </div>
    </div>
</div>
@endsection