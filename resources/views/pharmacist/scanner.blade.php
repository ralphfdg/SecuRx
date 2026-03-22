@extends('layouts.pharmacist')

@section('page_title', 'Secure QR Decryption')

@section('content')
<div class="max-w-7xl mx-auto">

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 h-full">
        
        <div class="lg:col-span-5 flex flex-col h-full space-y-6">
            
            <div class="glass-panel p-6 bg-white/90">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-extrabold text-securx-navy">Web-Based Scanner</h2>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Camera Active
                    </span>
                </div>
                <p class="text-sm text-gray-500 mb-6">Align the patient's QR code within the frame to decrypt the cryptographic UUID.</p>

                <div class="relative w-full aspect-square bg-slate-900 rounded-xl overflow-hidden border-4 border-slate-800 shadow-inner flex items-center justify-center group cursor-pointer" onclick="simulateScan()">
                    
                    <div class="absolute w-full h-0.5 bg-emerald-500 shadow-[0_0_15px_rgba(16,185,129,0.8)] z-10 scan-line"></div>
                    
                    <div class="absolute inset-8 border-2 border-white/20 rounded-lg">
                        <div class="absolute top-0 left-0 w-8 h-8 border-t-4 border-l-4 border-emerald-500 rounded-tl-lg"></div>
                        <div class="absolute top-0 right-0 w-8 h-8 border-t-4 border-r-4 border-emerald-500 rounded-tr-lg"></div>
                        <div class="absolute bottom-0 left-0 w-8 h-8 border-b-4 border-l-4 border-emerald-500 rounded-bl-lg"></div>
                        <div class="absolute bottom-0 right-0 w-8 h-8 border-b-4 border-r-4 border-emerald-500 rounded-br-lg"></div>
                    </div>

                    <p class="text-white/50 font-bold text-sm z-0 group-hover:text-emerald-400 transition-colors">Click frame to simulate scan</p>
                </div>
            </div>

            <div class="glass-panel p-6 bg-white/90">
                <h3 class="text-sm font-bold text-securx-navy mb-3">Manual UUID Fallback</h3>
                <div class="flex gap-3">
                    <input type="text" placeholder="e.g. 8F92A-4B7C1" class="glass-input w-full py-2.5 px-4 font-mono uppercase tracking-wider text-sm">
                    <button type="button" class="bg-slate-800 hover:bg-slate-700 text-white font-bold py-2.5 px-6 rounded-lg transition-colors">Verify</button>
                </div>
            </div>

        </div>

        <div class="lg:col-span-7 flex flex-col">
            
            <div id="scan-empty" class="flex-1 bg-slate-800 border border-slate-700 rounded-2xl p-10 shadow-lg flex flex-col items-center justify-center text-center transition-all duration-300">
                <div class="w-20 h-20 bg-slate-700/50 rounded-full flex items-center justify-center text-slate-500 mb-6">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Awaiting Decryption</h3>
                <p class="text-slate-400 font-medium max-w-sm">Scan a patient's SecuRx QR code to instantly verify authenticity and load their Drug Utilization Review (DUR) data.</p>
            </div>

            <div id="scan-populated" class="hidden flex-1 bg-slate-800 border border-slate-700 rounded-2xl shadow-lg overflow-hidden transition-all duration-300 flex flex-col">
                
                <div class="p-6 border-b border-slate-700 bg-emerald-900/20 flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-emerald-500/20 rounded-full flex items-center justify-center text-emerald-400 border border-emerald-500/30">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-extrabold text-emerald-400">Signature Verified</h2>
                            <p class="text-xs text-slate-400 font-mono">UUID: <span class="text-white">8F92A-4B7C1</span></p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-slate-400">Issued By</p>
                        <p class="text-sm font-bold text-white">Dr. Juan Santos, MD</p>
                    </div>
                </div>

                <div class="p-8 space-y-8 flex-1 overflow-y-auto">
                    
                    <div>
                        <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-4 border-b border-slate-700 pb-2">Prescription Payload</h4>
                        <div class="bg-slate-900/50 rounded-xl p-5 border border-slate-700/50">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-2xl font-extrabold text-white">Amoxicillin 500mg</h3>
                                    <p class="text-lg text-securx-cyan font-medium mt-1">Take 1 capsule 3x a day</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-slate-400 font-bold uppercase">Qty</p>
                                    <p class="text-2xl font-extrabold text-white">21</p>
                                </div>
                            </div>
                            <div class="flex gap-6 text-sm border-t border-slate-700/50 pt-4 mt-2">
                                <div><span class="text-slate-500">Duration:</span> <span class="text-white font-bold">7 Days</span></div>
                                <div><span class="text-slate-500">Refills Left:</span> <span class="text-white font-bold">0</span></div>
                                <div><span class="text-slate-500">Date Issued:</span> <span class="text-white font-bold">Today</span></div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-4 border-b border-slate-700 pb-2">Drug Utilization Review (DUR)</h4>
                        
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-10 h-10 rounded-full bg-slate-700 flex items-center justify-center text-white font-bold shadow-inner">RD</div>
                            <div>
                                <p class="text-sm font-bold text-white">Ralph De Guzman</p>
                                <p class="text-xs text-slate-400">DOB: Jan 15, 2005 (21) | Blood: O+</p>
                            </div>
                        </div>

                        <div class="bg-securx-gold/10 border border-securx-gold/30 rounded-xl p-4 flex gap-4 mt-2">
                            <div class="text-securx-gold mt-1">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-securx-gold font-bold mb-1">DUR Warning: Documented Allergy</h4>
                                <p class="text-sm text-slate-300">Patient profile indicates an allergy to <span class="font-bold text-white">Penicillin</span>. Cross-reactivity with Amoxicillin is possible. Pharmacist intervention and clinical judgment required.</p>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="p-6 border-t border-slate-700 bg-slate-900/80 flex justify-end gap-4">
                    <button onclick="resetScanner()" class="bg-transparent border border-slate-600 text-slate-300 font-bold py-3 px-6 rounded-lg hover:bg-slate-800 transition">Cancel Scan</button>
                    <a href="{{ route('pharmacist.dispense') }}" class="bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-lg shadow-[0_0_15px_rgba(16,185,129,0.3)] py-3 px-8 transition-all duration-300 flex items-center gap-2">
                        Proceed to Dispensing
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    /* Smooth CSS Animation for the Scanner Laser */
    @keyframes scan {
        0%, 100% { top: 5%; opacity: 0; }
        10%, 90% { opacity: 1; }
        50% { top: 95%; }
    }
    .scan-line {
        animation: scan 3s ease-in-out infinite;
    }
</style>

<script>
    function simulateScan() {
        // Play a satisfying beep sound (optional, but great for presentation)
        const audio = new Audio('https://assets.mixkit.co/active_storage/sfx/2869/2869-preview.mp3');
        audio.volume = 0.2;
        audio.play().catch(e => console.log("Audio play prevented by browser"));

        // Hide empty state, show data
        document.getElementById('scan-empty').classList.add('hidden');
        document.getElementById('scan-populated').classList.remove('hidden');
    }

    function resetScanner() {
        document.getElementById('scan-populated').classList.add('hidden');
        document.getElementById('scan-empty').classList.remove('hidden');
    }
</script>
@endsection