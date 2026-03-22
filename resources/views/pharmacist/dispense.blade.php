@extends('layouts.pharmacist')

@section('page_title', 'Confirm Dispense')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <div class="glass-panel p-8 bg-white/90 shadow-xl border-t-4 border-t-emerald-500">
        
        <div class="flex items-center gap-3 border-b border-gray-200 pb-6 mb-6">
            <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <h2 class="text-2xl font-extrabold text-securx-navy">Dispense Authorization</h2>
                <p class="text-sm text-gray-500">Finalizing cryptographic ledger entry for UUID: <span class="font-mono font-bold text-gray-700">8F92A-4B7C1</span></p>
            </div>
        </div>

        <div class="bg-gray-50 rounded-xl p-5 border border-gray-200 mb-8 flex justify-between items-center">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Authorized Drug</p>
                <h3 class="text-xl font-extrabold text-securx-navy">Amoxicillin 500mg</h3>
                <p class="text-sm text-gray-600 font-medium">Qty: 21 • Take 1 capsule 3x a day</p>
            </div>
            <div class="text-right">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Patient</p>
                <h3 class="text-base font-bold text-securx-navy">Ralph De Guzman</h3>
                <p class="text-sm text-gray-600 font-medium">Dr. Juan Santos</p>
            </div>
        </div>

        <form action="#" method="POST" class="space-y-8">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-securx-navy mb-1.5">Actual Brand Dispensed (If Generic Equivalent Used)</label>
                    <input type="text" value="Amoxil (Amoxicillin) 500mg" class="glass-input w-full py-3 px-4" required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-securx-navy mb-1.5">Lot / Batch Number *</label>
                    <input type="text" placeholder="e.g. LOT-4929" class="glass-input w-full py-3 px-4" required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-securx-navy mb-1.5">Expiration Date *</label>
                    <input type="month" class="glass-input w-full py-3 px-4" required>
                </div>
            </div>

            <div class="bg-securx-gold/5 border-l-4 border-l-securx-gold p-6 rounded-r-xl mt-8">
                <h4 class="text-securx-gold font-bold mb-2 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    Mandatory Clinical Override Justification
                </h4>
                <p class="text-sm text-gray-600 mb-4">The DUR system flagged a potential Penicillin allergy cross-reactivity. To proceed with dispensing, you must legally document your clinical justification.</p>
                
                <textarea rows="3" placeholder="I have consulted with the patient/prescriber and confirmed..." class="glass-input w-full py-3 px-4 border-securx-gold/30 focus:border-securx-gold focus:ring-securx-gold" required></textarea>
                <p class="text-xs text-gray-500 mt-2 font-medium italic">This justification will be permanently attached to the cryptographic ledger.</p>
            </div>

            <div class="pt-6 border-t border-gray-200 flex justify-between items-center">
                <a href="{{ route('pharmacist.scanner') }}" class="text-sm font-bold text-gray-500 hover:text-securx-navy transition">← Back to Scanner</a>
                
                <button type="button" onclick="completeDispense()" class="bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-lg shadow-[0_0_15px_rgba(16,185,129,0.3)] hover:shadow-[0_0_25px_rgba(16,185,129,0.5)] py-3.5 px-10 text-lg transition-all duration-300">
                    Log & Dispense Medication
                </button>
            </div>
        </form>

        <div id="dispense-success" class="hidden absolute inset-0 bg-white/95 rounded-xl z-10 flex flex-col items-center justify-center text-center p-10 backdrop-blur-sm">
            <div class="w-24 h-24 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-500 mb-6 border-4 border-white shadow-lg scale-0 animate-[popIn_0.5s_ease-out_forwards]">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <h2 class="text-3xl font-extrabold text-securx-navy mb-2">Transaction Secured</h2>
            <p class="text-gray-600 mb-8 max-w-md">The prescription has been marked as 'Dispensed' across the entire SecuRx network. The QR code can no longer be reused.</p>
            
            <a href="{{ route('pharmacist.dashboard') }}" class="bg-securx-navy hover:bg-slate-800 text-white font-bold py-3 px-8 rounded-lg transition-colors">Return to Dashboard</a>
        </div>

    </div>
</div>

<style>
    @keyframes popIn {
        0% { transform: scale(0); }
        80% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }
</style>

<script>
    function completeDispense() {
        // Show the success overlay seamlessly
        document.getElementById('dispense-success').classList.remove('hidden');
    }
</script>
@endsection