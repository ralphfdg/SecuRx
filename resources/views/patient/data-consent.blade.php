@extends('layouts.patient')

@section('page_title', 'Privacy & Consent')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="bg-white/80 backdrop-blur-md border border-gray-200 rounded-2xl p-6 shadow-sm mb-6 flex items-start gap-4">
        <div class="mt-1 w-10 h-10 bg-green-500/10 rounded-full flex items-center justify-center text-green-600 flex-shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
        </div>
        <div>
            <h3 class="font-bold text-gray-800 text-lg">RA 10173 Compliant</h3>
            <p class="text-sm text-gray-600 mt-1 leading-relaxed">
                SecuRx operates under the strict guidelines of the Philippine Data Privacy Act of 2012. You own your medical data. Use the controls below to determine exactly how your cryptographic prescriptions are shared within the network.
            </p>
        </div>
    </div>

    <div class="bg-slate-800 border border-slate-700 rounded-2xl p-8 shadow-xl text-slate-200">
        <h2 class="text-2xl font-extrabold text-white mb-2">Data Sharing Preferences</h2>
        <p class="text-slate-400 text-sm mb-8 leading-relaxed">
            Manage your Drug Utilization Review (DUR) visibility. Changes made here apply instantly to all partnered clinics and pharmacies.
        </p>

        <form action="#" method="POST" class="space-y-6">
            @csrf
            
            <div class="flex items-start justify-between p-5 bg-slate-900/50 border border-slate-700/50 rounded-xl hover:bg-slate-700/30 transition-colors">
                <div class="pr-6">
                    <h4 class="text-white font-bold text-base mb-1">Pharmacist Dispensing Visibility</h4>
                    <p class="text-sm text-slate-400">Allow scanning pharmacists to view your active prescriptions and recent 30-day dispensing history. <span class="text-securx-cyan font-semibold">Recommended to prevent dangerous drug interactions.</span></p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer flex-shrink-0 mt-1">
                    <input type="checkbox" name="allow_pharmacist" class="sr-only peer" checked>
                    <div class="w-11 h-6 bg-slate-600 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-securx-cyan shadow-inner"></div>
                </label>
            </div>

            <div class="flex items-start justify-between p-5 bg-slate-900/50 border border-slate-700/50 rounded-xl hover:bg-slate-700/30 transition-colors">
                <div class="pr-6">
                    <h4 class="text-white font-bold text-base mb-1">Physician Historical Access</h4>
                    <p class="text-sm text-slate-400">Allow verified SecuRx providers to view your past 12 months of prescriptions *before* issuing a new one. Ideal for managing chronic care.</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer flex-shrink-0 mt-1">
                    <input type="checkbox" name="allow_doctor" class="sr-only peer" checked>
                    <div class="w-11 h-6 bg-slate-600 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-securx-cyan shadow-inner"></div>
                </label>
            </div>

            <div class="flex items-start justify-between p-5 bg-slate-900/50 border border-slate-700/50 rounded-xl hover:bg-slate-700/30 transition-colors">
                <div class="pr-6">
                    <h4 class="text-white font-bold text-base mb-1">Anonymized Public Health Data</h4>
                    <p class="text-sm text-slate-400">Contribute strictly anonymized diagnosis and demographic data to the Department of Health (DOH) for disease tracking and outbreak prevention.</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer flex-shrink-0 mt-1">
                    <input type="checkbox" name="allow_research" class="sr-only peer">
                    <div class="w-11 h-6 bg-slate-600 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-securx-cyan shadow-inner"></div>
                </label>
            </div>

            <div class="mt-10 pt-8 border-t border-slate-700">
                <h4 class="text-red-400 font-bold text-base mb-2 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    Data Revocation
                </h4>
                <p class="text-sm text-slate-400 mb-5">Revoking access will immediately lock all active QR codes. Pharmacies will be unable to decrypt your prescriptions until access is restored. This action is logged for security purposes.</p>
                
                <button type="button" class="bg-transparent border border-red-500/50 text-red-400 hover:bg-red-500/10 font-bold py-2.5 px-6 rounded-lg transition-all text-sm">
                    Revoke All Clinical Access
                </button>
            </div>

            <div class="flex justify-end pt-6">
                <button type="submit" class="glass-btn-primary py-2.5 px-8">
                    Save Privacy Settings
                </button>
            </div>
        </form>
    </div>
</div>
@endsection