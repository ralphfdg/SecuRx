@extends('layouts.public')

@section('title', 'Security Gatekeeper')

@section('content')
<div class="relative w-full min-h-[calc(100vh-80px)] overflow-hidden bg-slate-50 flex items-center justify-center py-12">
    
    <div class="absolute top-[-10%] left-[10%] w-[400px] h-[400px] bg-securx-cyan/20 rounded-full mix-blend-multiply filter blur-[100px] opacity-70 pointer-events-none"></div>
    <div class="absolute bottom-[-10%] right-[10%] w-[500px] h-[500px] bg-securx-navy/15 rounded-full mix-blend-multiply filter blur-[120px] opacity-70 pointer-events-none"></div>

    <div class="relative max-w-xl w-full mx-auto px-4 sm:px-6">
        
        <div class="bg-white/70 backdrop-blur-xl border border-white/60 shadow-2xl rounded-3xl overflow-hidden">
            
            <div class="bg-securx-navy px-8 py-6 text-center relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full filter blur-2xl transform translate-x-1/2 -translate-y-1/2"></div>
                
                <div class="w-16 h-16 mx-auto bg-white/10 rounded-2xl flex items-center justify-center backdrop-blur-sm border border-white/20 mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                
                <h2 class="text-2xl font-extrabold text-white tracking-tight">Prescription Found</h2>
                <p class="text-securx-cyan text-sm font-medium mt-1">Encrypted Payload Detected</p>
            </div>

            <div class="p-8 md:p-10">
                
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-8 flex items-start gap-3">
                    <svg class="w-5 h-5 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <div>
                        <h4 class="text-sm font-bold text-amber-800">Restricted Medical Record</h4>
                        <p class="text-xs text-amber-700 mt-1 leading-relaxed">
                            Under the Data Privacy Act of 2012, you must provide your professional credentials to decrypt and view this patient's medical data.
                        </p>
                    </div>
                </div>

                <form action="{{ route('verify.decrypt') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <input type="hidden" name="qr_uuid" value="{{ $qr_uuid }}">

                    <div>
                        <label for="prc_license" class="block text-sm font-bold text-securx-navy mb-2">PRC License Number <span class="text-red-500">*</span></label>
                        <input type="text" name="prc_license" id="prc_license" required placeholder="e.g. 0123456" class="w-full px-4 py-3 bg-white/50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-securx-cyan focus:border-securx-cyan transition-colors shadow-sm outline-none">
                    </div>

                    <div>
                        <label for="pharmacy_name" class="block text-sm font-bold text-securx-navy mb-2">Pharmacy / Branch Name <span class="text-red-500">*</span></label>
                        <input type="text" name="pharmacy_name" id="pharmacy_name" required placeholder="e.g. Mercury Drug - Balibago" class="w-full px-4 py-3 bg-white/50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-securx-cyan focus:border-securx-cyan transition-colors shadow-sm outline-none">
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full flex items-center justify-center gap-2 py-3.5 px-4 bg-gradient-to-r from-securx-navy to-slate-800 hover:from-slate-800 hover:to-slate-700 text-white rounded-xl font-bold transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path></svg>
                            Decrypt as Guest Pharmacist
                        </button>
                    </div>
                </form>

                <div class="relative mt-10 mb-8">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-slate-200"></div>
                    </div>
                    <div class="relative flex justify-center">
                        <span class="bg-slate-50/50 backdrop-blur-sm px-4 text-xs text-slate-400 font-bold uppercase tracking-widest">SecuRx Network Options</span>
                    </div>
                </div>

                <div class="space-y-4">
                    <a href="{{ route('login') }}" class="w-full flex items-center justify-center gap-2 py-3 px-4 bg-white border-2 border-securx-cyan text-securx-navy rounded-xl font-bold transition-all hover:bg-securx-cyan/5 shadow-sm">
                        <svg class="w-5 h-5 text-securx-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                        Log in as Registered Pharmacy
                    </a>

                    <div class="border border-slate-200 rounded-xl p-5 bg-white/50">
                        <h4 class="text-sm font-bold text-securx-navy mb-2">Want to join the SecuRx Network?</h4>
                        <p class="text-xs text-slate-500 mb-4 leading-relaxed">Registered pharmacies skip the PRC input process, track historical logs, and appear on our patient clinic maps.</p>
                        
                        <div class="bg-red-50 border-l-4 border-red-500 p-3 mb-4 rounded-r-md flex items-start gap-2">
                            <svg class="w-4 h-4 text-red-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            <p class="text-[11px] font-semibold text-red-800 uppercase tracking-wide">Serve Patient First. Account verification requires DOH review (24-48 hrs). Please dispense this prescription using the Guest Form above before applying.</p>
                        </div>

                        <a href="{{ route('register', ['role' => 'pharmacist']) }}" class="block w-full text-center py-2.5 px-4 bg-securx-gold hover:bg-yellow-500 text-securx-navy rounded-lg text-sm font-bold transition-colors shadow-sm">
                            Apply for Partnership
                        </a>
                    </div>
                </div>

            </div>
            
            <div class="bg-slate-50/80 border-t border-slate-100 px-8 py-4 flex items-center justify-center gap-2">
                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Secured by SecuRx Cryptography</span>
            </div>

        </div>
    </div>
</div>
@endsection