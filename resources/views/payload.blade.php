@extends('layouts.public')

@section('title', 'Decrypted Prescription')

@section('content')
    <div class="relative w-full min-h-screen pb-20 bg-slate-50 overflow-hidden">

        <div
            class="absolute top-0 left-[-10%] w-[600px] h-[600px] bg-securx-cyan/15 rounded-full mix-blend-multiply filter blur-[120px] pointer-events-none">
        </div>
        <div
            class="absolute bottom-[20%] right-[-5%] w-[500px] h-[500px] bg-securx-navy/10 rounded-full mix-blend-multiply filter blur-[120px] pointer-events-none">
        </div>

        <div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pt-12">

            <div class="flex items-center justify-between mb-8 pb-6 border-b border-slate-200">
                <div>
                    <h1 class="text-3xl font-extrabold text-securx-navy flex items-center gap-3">
                        <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                            </path>
                        </svg>
                        Verified Medical Payload
                    </h1>
                    <p class="text-slate-500 font-medium mt-1 text-sm">Decrypted via AES-256 &bull; Session locked to PRC
                        License</p>
                </div>
                <div class="text-right hidden md:block">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Prescription ID</p>
                    <p class="font-mono text-securx-cyan font-bold text-sm">UUID-A456-426614174000</p>
                </div>
            </div>

            <div class="bg-red-50 border-l-4 border-red-500 p-5 rounded-r-xl shadow-sm mb-8 flex items-start gap-4 animate-pulse"
                style="animation-iteration-count: 3;">
                <div class="bg-red-100 rounded-full p-2 shrink-0">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                        </path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-red-800 font-bold">DUR Engine Warning: Severe Allergy Detected</h3>
                    <p class="text-red-700 text-sm mt-1">Patient profile indicates a High Severity allergy to
                        <strong>Penicillin</strong>. Please verify alternative medications with the prescribing physician
                        before dispensing.
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="space-y-6 lg:col-span-1">

                    <div
                        class="bg-white/70 backdrop-blur-md border border-white/60 shadow-lg rounded-2xl p-6 relative overflow-hidden">
                        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Patient Profile</h3>
                        <h2 class="text-xl font-bold text-securx-navy mb-1">Maria Dela Cruz</h2>
                        <p class="text-slate-600 text-sm font-medium mb-4">Female, 62 yrs old &bull; Blood Type: O+</p>
                        <div class="border-t border-slate-100 pt-4">
                            <p class="text-xs text-slate-500 mb-1">Known Allergies:</p>
                            <div class="flex flex-wrap gap-2">
                                <span
                                    class="inline-block px-2.5 py-1 bg-red-100 text-red-700 text-xs font-bold rounded-md">Penicillin</span>
                                <span
                                    class="inline-block px-2.5 py-1 bg-slate-100 text-slate-700 text-xs font-bold rounded-md">Dust
                                    Mites</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white/70 backdrop-blur-md border border-white/60 shadow-lg rounded-2xl p-6">
                        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Prescribing Physician
                        </h3>
                        <h2 class="text-lg font-bold text-securx-navy">Dr. Juan Santos, MD</h2>
                        <p class="text-securx-cyan text-sm font-semibold mb-3">Internal Medicine &bull; Cardiology</p>
                        <div class="space-y-1 text-sm text-slate-600">
                            <p><span class="font-semibold text-slate-400">Clinic:</span> Apex Health Center</p>
                            <p><span class="font-semibold text-slate-400">PRC No:</span> 0012345</p>
                            <p><span class="font-semibold text-slate-400">Date Issued:</span> Oct 12, 2026</p>
                        </div>
                    </div>

                </div>

                <div class="lg:col-span-2 space-y-6">

                    <div class="bg-white/70 backdrop-blur-md border border-white/60 shadow-xl rounded-2xl p-6 md:p-8">
                        <h3 class="text-lg font-bold text-securx-navy border-b border-slate-200 pb-4 mb-6">Authorized
                            Medications</h3>

                        <div
                            class="p-4 rounded-xl border-2 border-securx-cyan/20 bg-white/50 mb-4 flex justify-between items-start">
                            <div>
                                <h4 class="text-lg font-extrabold text-slate-800">Losartan Potassium</h4>
                                <p class="text-securx-cyan font-bold text-sm mb-2">50mg Tablet</p>
                                <p class="text-slate-600 text-sm"><strong>Sig:</strong> Take 1 tablet daily in the morning.
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-2xl font-black text-securx-navy">30</p>
                                <p class="text-xs text-slate-400 font-bold uppercase">Auth Qty</p>
                            </div>
                        </div>

                        <div
                            class="p-4 rounded-xl border border-slate-200 bg-slate-50 mb-6 flex justify-between items-start">
                            <div>
                                <h4 class="text-lg font-extrabold text-slate-800">Amoxicillin</h4>
                                <p class="text-securx-cyan font-bold text-sm mb-2">500mg Capsule</p>
                                <p class="text-slate-600 text-sm"><strong>Sig:</strong> Take 1 capsule every 8 hours for 7
                                    days.</p>
                            </div>
                            <div class="text-right">
                                <p class="text-2xl font-black text-securx-navy">21</p>
                                <p class="text-xs text-slate-400 font-bold uppercase">Auth Qty</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-securx-navy rounded-2xl shadow-xl overflow-hidden relative">
                        <div
                            class="absolute top-0 right-0 w-40 h-40 bg-white/5 rounded-full filter blur-2xl transform translate-x-1/2 -translate-y-1/2 pointer-events-none">
                        </div>

                        <div class="p-6 md:p-8">
                            <h3 class="text-lg font-bold text-white mb-6">Fulfillment Ledger</h3>

                            <form action="#" method="POST" class="space-y-6">
                                @csrf

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div>
                                        <select name="dispensed_to" id="dispensed_to"
                                            class="w-full px-4 py-3 bg-slate-800/50 border border-slate-600 rounded-xl text-white focus:ring-2 focus:ring-securx-cyan outline-none">
                                            <option value="self">{{ $prescription->patient->name }} (Patient / Self)
                                            </option>

                                            @foreach ($prescription->patient->authorizedRepresentatives as $rep)
                                                <option value="{{ $rep->id }}">{{ $rep->full_name }}
                                                    ({{ $rep->relationship }})
                                                </option>
                                            @endforeach

                                            <option value="manual">Other / Emergency Representative...</option>
                                        </select>

                                        <div id="manual_inputs" class="hidden grid-cols-2 gap-4 mt-4">
                                            <input type="text" name="manual_name" placeholder="Full Name"
                                                class="w-full px-4 py-3 bg-slate-800/50 border border-slate-600 rounded-xl text-white placeholder-slate-500 focus:ring-2 focus:ring-securx-cyan outline-none">
                                            <input type="text" name="manual_relationship" placeholder="Relationship"
                                                class="w-full px-4 py-3 bg-slate-800/50 border border-slate-600 rounded-xl text-white placeholder-slate-500 focus:ring-2 focus:ring-securx-cyan outline-none">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-300 mb-2">ID Presented
                                            (Required)</label>
                                        <input type="text" placeholder="e.g. Senior Citizen ID / Driver's License"
                                            class="w-full px-4 py-3 bg-slate-800/50 border border-slate-600 rounded-xl text-white placeholder-slate-500 focus:ring-2 focus:ring-securx-cyan outline-none">
                                    </div>
                                </div>

                                <div
                                    class="pt-4 border-t border-slate-700 flex flex-col sm:flex-row gap-4 justify-between items-center">
                                    <p class="text-sm text-slate-400">By dispensing, you are signing the permanent DOH audit
                                        log under your PRC license.</p>
                                    <button type="submit"
                                        class="w-full sm:w-auto px-8 py-3.5 bg-securx-cyan hover:bg-cyan-400 text-securx-navy font-extrabold rounded-xl transition-all shadow-lg hover:shadow-cyan-500/30 whitespace-nowrap">
                                        Log Dispense Transaction
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
