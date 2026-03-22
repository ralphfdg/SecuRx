@extends('layouts.patient')

@section('page_title', 'Privacy & Consent')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="bg-[#0B1120] border border-white/10 rounded-2xl p-8 shadow-xl text-gray-200">
        <h2 class="text-2xl font-extrabold text-white mb-2">Data Sharing Preferences</h2>
        <p class="text-gray-400 text-sm mb-8 leading-relaxed">
            Manage how your cryptographic prescriptions and Drug Utilization Review (DUR) history are shared within the SecuRx network. These settings comply with the <strong>Data Privacy Act of 2012 (RA 10173)</strong>.
        </p>

        <form action="#" method="POST" class="space-y-6">
            @csrf
            
            <div class="flex items-start justify-between p-5 bg-white/5 border border-white/10 rounded-xl hover:bg-white/10 transition-colors">
                <div class="pr-6">
                    <h4 class="text-white font-bold text-base mb-1">Pharmacist Dispensing Visibility</h4>
                    <p class="text-sm text-gray-400">Allow scanning pharmacists to view your active prescriptions and recent 30-day dispensing history to prevent dangerous drug interactions.</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer flex-shrink-0 mt-1">
                    <input type="checkbox" name="allow_pharmacist" class="sr-only peer" checked>
                    <div class="w-11 h-6 bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-securx-cyan shadow-inner"></div>
                </label>
            </div>

            <div class="flex items-start justify-between p-5 bg-white/5 border border-white/10 rounded-xl hover:bg-white/10 transition-colors">
                <div class="pr-6">
                    <h4 class="text-white font-bold text-base mb-1">Physician Historical Access</h4>
                    <p class="text-sm text-gray-400">Allow verified SecuRx providers to view your past prescriptions *before* issuing a new one. Highly recommended for chronic care patients.</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer flex-shrink-0 mt-1">
                    <input type="checkbox" name="allow_doctor" class="sr-only peer" checked>
                    <div class="w-11 h-6 bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-securx-cyan shadow-inner"></div>
                </label>
            </div>

            <div class="mt-10 pt-8 border-t border-white/10">
                <h4 class="text-red-400 font-bold text-base mb-2 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    Data Revocation
                </h4>
                <p class="text-sm text-gray-400 mb-4">Revoking access will immediately lock all active QR codes. You will not be able to claim pending prescriptions until access is restored.</p>
                
                <button type="button" class="bg-transparent border border-red-500/50 text-red-400 hover:bg-red-500/10 font-bold py-2.5 px-6 rounded-lg transition-all text-sm">
                    Revoke All Clinical Access
                </button>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="bg-securx-cyan hover:bg-cyan-500 text-white font-bold py-2.5 px-8 rounded-lg shadow-[0_0_15px_rgba(28,181,209,0.3)] transition-all">
                    Save Privacy Settings
                </button>
            </div>
        </form>
    </div>
</div>
@endsection