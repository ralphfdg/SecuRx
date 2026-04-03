@extends('layouts.public')

@section('title', 'Guest Verification Portal')

@section('content')
<div class="relative w-full min-h-[calc(100vh-80px)] overflow-hidden bg-slate-50 flex items-center justify-center">
    
    <div class="absolute top-[-10%] left-[-10%] w-[500px] h-[500px] bg-securx-gold/20 rounded-full mix-blend-multiply filter blur-3xl opacity-60 pointer-events-none"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[600px] h-[600px] bg-securx-navy/10 rounded-full mix-blend-multiply filter blur-[150px] opacity-60 pointer-events-none"></div>

    <div class="relative max-w-2xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-12 z-10">
        
        @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 shadow-sm rounded-xl p-4 flex items-center gap-3">
            <svg class="w-6 h-6 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <p class="text-sm font-bold text-green-800">{{ session('success') }}</p>
        </div>
        @endif

        @if($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 shadow-sm rounded-xl p-4 flex items-center gap-3">
            <svg class="w-6 h-6 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            <p class="text-sm font-bold text-red-800">{{ $errors->first() }}</p>
        </div>
        @endif

        <div class="bg-white/70 backdrop-blur-xl border border-white/60 shadow-2xl rounded-3xl p-10 md:p-14 text-center relative overflow-hidden">
            
            <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-securx-cyan via-securx-gold to-securx-cyan background-animate"></div>

            <div class="mb-8">
                <div class="w-20 h-20 mx-auto bg-securx-navy/5 rounded-full flex items-center justify-center mb-6 relative">
                    <svg class="w-10 h-10 text-securx-navy relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                    <div class="absolute inset-0 rounded-full border-2 border-securx-gold/50 animate-ping"></div>
                </div>
                
                <h1 class="text-3xl font-extrabold text-securx-navy tracking-tight mb-3">
                    Guest Pharmacist Portal
                </h1>
                <p class="text-slate-600 font-medium">
                    System is active. Please aim your hardware scanner at the patient's SecuRx code and pull the trigger.
                </p>
            </div>

            <form action="#" method="GET" id="scanner-form" class="relative">
                
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-securx-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    
                    <input 
                        type="text" 
                        name="qr_uuid" 
                        id="scanner-input"
                        autofocus
                        autocomplete="off"
                        placeholder="Waiting for scanner input..." 
                        class="block w-full pl-12 pr-4 py-4 bg-white/50 border-2 border-securx-cyan/30 rounded-xl text-lg text-center text-slate-700 tracking-widest placeholder:text-slate-400 focus:ring-4 focus:ring-securx-cyan/20 focus:border-securx-cyan focus:bg-white transition-all outline-none shadow-inner"
                        required
                    >
                </div>

                <button type="submit" class="mt-6 w-full py-3.5 px-4 bg-slate-800 hover:bg-securx-navy text-white rounded-xl font-bold transition-colors shadow-md hidden" id="manual-submit">
                    Verify Code manually
                </button>

            </form>

            <div class="mt-8 text-xs text-slate-400">
                <p>Secured by AES-256 Cryptography &bull; DPA Compliant</p>
            </div>
        </div>
    </div>
</div>

<style>
    .background-animate {
        background-size: 200% 200%;
        animation: GradientFlow 3s ease infinite;
    }
    @keyframes GradientFlow {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }
</style>
@endsection