@extends('layouts.patient')

@section('page_title', 'Patient Dashboard')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    <div class="glass-panel p-8 bg-white/80 relative overflow-hidden flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="relative z-10">
            <h1 class="text-3xl font-extrabold text-securx-navy mb-2">Welcome back, John.</h1>
            <p class="text-gray-600 font-medium">Your medical profile is up to date. You have <span class="text-securx-cyan font-bold">2 active prescriptions</span> ready for dispensing.</p>
        </div>
        
        <div class="relative z-10 w-full md:w-auto">
            <a href="#" class="glass-btn-primary flex items-center justify-center gap-2 py-3 px-8 shadow-[0_4px_14px_0_rgba(28,181,209,0.39)]">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                View Live QR Code
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <div class="glass-panel p-6 bg-white/60 flex items-center gap-4 hover:-translate-y-1 transition-transform">
            <div class="w-12 h-12 rounded-full bg-securx-cyan/10 text-securx-cyan flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-bold text-gray-500">Active Rx</p>
                <p class="text-2xl font-extrabold text-securx-navy">2</p>
            </div>
        </div>

        <div class="glass-panel p-6 bg-white/60 flex items-center gap-4 hover:-translate-y-1 transition-transform">
            <div class="w-12 h-12 rounded-full bg-securx-gold/15 text-securx-gold flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
            </div>
            <div>
                <p class="text-sm font-bold text-gray-500">Refills Available</p>
                <p class="text-2xl font-extrabold text-securx-navy">4</p>
            </div>
        </div>

        <div class="glass-panel p-6 bg-white/60 flex items-center gap-4 hover:-translate-y-1 transition-transform">
            <div class="w-12 h-12 rounded-full bg-green-500/10 text-green-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-bold text-gray-500">Data Consent</p>
                <p class="text-lg font-extrabold text-green-600">Active</p>
            </div>
        </div>
    </div>

    <div class="glass-panel overflow-hidden bg-white/80">
        <div class="p-6 border-b border-gray-200/60 flex justify-between items-center">
            <h3 class="text-lg font-bold text-securx-navy">Recent Prescriptions</h3>
            <a href="#" class="text-sm font-bold text-securx-cyan hover:text-securx-navy transition">View All &rarr;</a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 text-xs text-gray-500 uppercase tracking-wider">
                        <th class="p-4 font-bold">Medication</th>
                        <th class="p-4 font-bold">Prescribed By</th>
                        <th class="p-4 font-bold">Date Issued</th>
                        <th class="p-4 font-bold">Status</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-700 divide-y divide-gray-100/50">
                    
                    <tr class="hover:bg-white/40 transition">
                        <td class="p-4">
                            <p class="font-bold text-securx-navy">Amoxicillin 500mg</p>
                            <p class="text-xs text-gray-500">Take 1 capsule every 8 hours</p>
                        </td>
                        <td class="p-4 font-medium">Dr. Santos</td>
                        <td class="p-4 text-gray-500">Oct 24, 2026</td>
                        <td class="p-4">
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-green-500/10 text-green-700 border border-green-500/20">
                                Active
                            </span>
                        </td>
                    </tr>

                    <tr class="hover:bg-white/40 transition">
                        <td class="p-4">
                            <p class="font-bold text-securx-navy">Loratadine 10mg</p>
                            <p class="text-xs text-gray-500">Take 1 tablet daily as needed</p>
                        </td>
                        <td class="p-4 font-medium">Dr. Reyes</td>
                        <td class="p-4 text-gray-500">Oct 15, 2026</td>
                        <td class="p-4">
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-securx-gold/10 text-securx-gold border border-securx-gold/30">
                                Dispensed
                            </span>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection