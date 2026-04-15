@extends('layouts.patient')

@section('page_title', 'Privacy & Consent')

@section('content')
    <div class="max-w-6xl mx-auto space-y-6">

        @if (session('success'))
            <div class="bg-green-50/80 border border-green-200 text-green-700 px-6 py-4 rounded-xl shadow-sm flex items-center gap-3">
                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="font-bold text-sm">{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white/80 backdrop-blur-md border border-gray-200 rounded-2xl p-6 shadow-sm mb-6 flex items-start gap-4 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-green-500/5 rounded-bl-full pointer-events-none"></div>
            <div class="mt-1 w-10 h-10 bg-green-500/10 rounded-full flex items-center justify-center text-green-600 flex-shrink-0 relative z-10">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
            </div>
            <div class="relative z-10">
                <h3 class="font-bold text-gray-800 text-lg">RA 10173 Compliant</h3>
                <p class="text-sm text-gray-600 mt-1 leading-relaxed max-w-3xl">
                    SecuRx operates under the strict guidelines of the Philippine Data Privacy Act of 2012. You own your
                    medical data. Use the master control below to determine if your cryptographic prescriptions can be
                    shared within the secure network.
                </p>
            </div>
        </div>

        <div class="bg-slate-800 border border-slate-700 rounded-2xl p-8 shadow-xl text-slate-200">
            <h2 class="text-2xl font-extrabold text-white mb-2">Master Clinical Access</h2>
            <p class="text-slate-400 text-sm mb-8 leading-relaxed">
                By enabling this master switch, you are granting the SecuRx network permission to process your data for continuity of care.
            </p>

            <form action="{{ route('patient.consent.update') }}" method="POST" class="space-y-6">
                @csrf

                <div class="flex flex-col md:flex-row items-start justify-between p-6 bg-slate-900/80 border border-securx-cyan/30 rounded-xl hover:border-securx-cyan/60 transition-all shadow-lg relative overflow-hidden">
                    
                    <div class="absolute -top-10 -right-10 w-40 h-40 bg-securx-cyan/10 rounded-full blur-3xl pointer-events-none"></div>

                    <div class="pr-6 relative z-10">
                        <h4 class="text-white font-extrabold text-lg mb-2">Comprehensive Data Sharing Consent</h4>
                        <p class="text-sm text-slate-400 mb-3">Enabling this grants authorization for the following secure actions:</p>
                        <ul class="space-y-2 text-sm text-slate-300">
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-securx-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Pharmacists can view your dispensing history to prevent dangerous drug interactions (DUR).
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-securx-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Verified physicians can review past prescriptions before issuing new ones.
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-securx-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Strictly anonymized metrics may be sent to the DOH for public health tracking.
                            </li>
                        </ul>
                    </div>
                    
                    <div class="mt-6 md:mt-0 relative z-10 flex-shrink-0 flex items-center justify-center">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="data_consent" class="sr-only peer" {{ ($profile->data_consent ?? false) ? 'checked' : '' }}>
                            <div class="w-14 h-7 bg-slate-600 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-securx-cyan shadow-inner"></div>
                        </label>
                    </div>
                </div>

                <div class="mt-10 pt-8 border-t border-slate-700">
                    <h4 class="text-red-400 font-bold text-base mb-2 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        Data Revocation
                    </h4>
                    <p class="text-sm text-slate-400 mb-5">
                        Revoking access by turning off the switch above will immediately lock all active QR codes. Pharmacies will be unable to decrypt your prescriptions until access is restored.
                    </p>
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit" class="bg-securx-cyan hover:bg-cyan-600 text-white font-bold py-3 px-8 rounded-xl transition-colors shadow-lg shadow-cyan-500/20">
                        Save Privacy Settings
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection